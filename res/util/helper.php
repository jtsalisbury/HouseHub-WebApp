<?php
  session_start();

  function checkLogin() {
      return isset($_SESSION["uid"]);
  }

  function isAdmin() {
      return $_SESSION["admin"] === 1;
  }
?>