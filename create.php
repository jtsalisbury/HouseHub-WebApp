<?php

    header("Access-Control-Allow-Origin: http://u747950311.hostingerapp.com/househub/api/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once "../core/core.php";

    $data = json_decode(file_get_contents("php://input"), true);

    $token = $data["token"];

    if (!$jwt->verifyToken($token)) {
        output("error", ENUMS::TOKEN_INVALID);
    }

    $data = json_decode($jwt->decodePayload($token), true);

    $fname = $data["fname"];
    $lname = $data["lname"];
    $email = $data["email"];
    $pass  = $data["pass"];
    $repass = $data["repass"];

    /*
        Check to ensure that all fields are set
    */

    if (empty($fname) || empty($lname) || empty($email) || empty($pass) || empty($repass)) {
        output("error", ENUMS::FIELD_NOT_SET);
    }

    /*
        CHeck to ensure passwords are equal
    */

    if ($pass != $repass) {
        output("error", ENUMS::PASS_NOT_EQUAL);
    }

    $link = $db->getLink();

    if (!$link) {
        output("error", ENUMS::DB_NOT_CONNECTED);
    }

    // Clean all fields
    $email = htmlspecialchars(strip_tags($email));
    $fname = htmlspecialchars(strip_tags($fname));
    $lname = htmlspecialchars(strip_tags($lname));
    $pass  = password_hash(htmlspecialchars(strip_tags($pass)), PASSWORD_BCRYPT);

    // Prepare SQL statement for insertion
    $sql = "INSERT INTO users (firstname, lastname, email, hashed_pass) VALUES (:fname, :lname, :email, :pass)";
    $stmt = $link->prepare($sql);

    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":pass", $pass);

    // Try to insert the user. Send a message that the user exists if there's a problem.
    try {

        $stmt->execute();

    } catch (PDOException $e) {

        output("error", ENUMS::INSERT_USER_EXISTS);
    }

    // Grab the user ID based on the entry just submitted
    $stmt = $link->prepare("SELECT id from users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1) {

        // Return the user's information including the ID in an encrypted token  
        $data = array(
            "fname" => $fname, 
            "lname" => $lname, 
            "email" => $email, 
            "uid" => $result["id"]
        );

        $token = $jwt->generateToken($data);

        output("success", $token);
    }

    // Die for any other reason
    output("error", ENUMS::FAILED_NEW_USER);
?>