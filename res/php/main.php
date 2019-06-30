<?php
  error_reporting(E_ERROR | E_PARSE);

  include_once "../util/enums.php";
  include_once "../util/jwt.php";

  // Parse settings and initialize global Jobjects
  $data = parse_ini_file("../util/settings.ini");

  // Used for: creation, verification and decoding of tokens
  $jwt = new JWT($data["signKey"], $data["signAlgorithm"], $data["payloadSecret"], $data["payloadCipher"]);
  
  // Used for: global ENUMS
  $ENUMS = new ENUMS();
?>