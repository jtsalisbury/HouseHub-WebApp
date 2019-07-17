<?php
  include("../util/helper.php");
  include("main.php");

  if (!checkLogin()) {
    die("not logged in");
  }

  // Grab the post fields
  $page = $_POST["page"];
  $search = $_POST["search"];
  $minPrice = $_POST["minPrice"];
  $maxPrice = $_POST["maxPrice"];
  $saved = $_POST["saved"];
  $myRequests = $_POST["mine"];
  $targetUserID = $_POST["targetUserID"];
  $showHidden = $_POST["show_hidden"];

  // Construct the payload
  $url = "http://u747950311.hostingerapp.com/househub/api/listings/retrieve.php";
  $data = array(
    "uid" => "",
    "saved" => $saved,
    "page" => $page,
    "price_min" => $minPrice,
    "price_max" => $maxPrice,
    "pid" => "",
    "search_criteria" => $search,
    "show_hidden" => $showHidden
  );

  if ($myRequests === 'true' || $saved === 'true') {
    $data["uid"] = $_SESSION["uid"];

  } else if (!empty($targetUserID)) {
    $data["uid"] = $targetUserID;
    $data["saved"] = "";
  }

  // Create the token
  $token = $jwt->generateToken($data);
  $token = json_encode(array("token" => $token));

  // Open a channel to the request api
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $token);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
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
  if ($jwt->verifyToken($token) === false) {
    die("");
  }

  // Grab the payload from the token
  $payload = $jwt->decodePayload($token);  

  die($payload);
?>