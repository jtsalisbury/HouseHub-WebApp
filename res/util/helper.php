<?php
    session_start();

    function checkLogin() {
        return isset($_SESSION["uid"]);
    }


?>