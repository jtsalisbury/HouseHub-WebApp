<?php
    include("../util/helper.php");
    include("main.php");

    if (!checkLogin()) {
        die("not logged in");
    }

    // Grab the post fields (from the form)
    $title = $_POST["title"];
    $desc  = $_POST["desc"];
    $loc   = $_POST["loc"];
    $base  = $_POST["base_price"];
    $add   = $_POST["add_price"];
    $hidden = isset($_POST["hidden"]) ? 1 : 0;
    $pid   = $_POST["pid"];

    $url = "http://u747950311.hostingerapp.com/househub/api/listings/update.php";

    // Construct our data payload
    $payload = array(
        "uid" => $_SESSION["uid"],
        "title" => $title,
        "desc" => $desc,
        "location" => $loc,
        "rent_price" => $base,
        "add_price" => $add,
        "hidden" => $hidden,
        "pid" => $pid
    );

    // Generate the token
    $token = $jwt->generateToken($payload);

    $data = array(
        "token" => $token,        
    );

    // Create the cURLFiles (basically we send the $_FILES to the new location)
    $countFiles = count($_FILES["file"]["name"]);
    foreach ($_FILES["file"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {

            $data["file[$key]"] = curl_file_create(
                $_FILES['file']['tmp_name'][$key],
                $_FILES['file']['type'][$key],
                $_FILES['file']['name'][$key]
            );
        }
    }

    // Open a channel to the creation API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    // No result => die
    if ($result === false) {
       die("");
    }

    // Decode the result
    $result_d = json_decode($result, true);
    
    if ($result_d["status"] == "error") {
        die($result);
    }

    // Grab the token from the result
    $token = $result_d["message"];
    if (!$jwt->verifyToken($token)) {
        die("");
    }

    // Grab the payload from the token
    $payload = $jwt->decodePayload($token);  

    die($payload);
?>