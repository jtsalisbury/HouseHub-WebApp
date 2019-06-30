<?php
  include("../util/helper.php");
  include("main.php");

  // Grab the passed parameters
  $email = $_POST["email"];
  $pass  = $_POST["password"];
  $repass = $_POST["repass"];
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];

  // Construct the token to send
  $url = "http://u747950311.hostingerapp.com/househub/api/user/create.php";
  $data = array(
    "email" => $email, 
    "pass" => $pass,
    "repass" => $repass,
    "fname" => $fname,
    "lname" => $lname
  );

  $token = $jwt->generateToken($data);

  $token = json_encode(array("token" => $token));

  // Open a curl channel to the url with the token
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $token);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // Grab the result
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

  $payload_dec = json_decode($jwt->decodePayload($token), true);

  // Set the session user's id
  $_SESSION["uid"] = $payload_dec["uid"];

  die($payload);
?>