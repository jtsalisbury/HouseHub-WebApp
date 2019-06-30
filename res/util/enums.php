<?php

    /*
        Includes all enumerations for errors, messages, etc;
    */

    class ENUMS {
        const SUCCESS = "success";

        const TOKEN_INVALID = "invalid_request_token";
        const FIELD_NOT_SET = "fields_not_set";
        const PASS_NOT_EQUAL = "password_not_equal";
        const DB_NOT_CONNECTED = "database_not_connected";
        const FAILED_NEW_USER = "failed_insert_user";
        const INSERT_USER_EXISTS = "failed_insert_user_exists";

        const USER_NOT_EXIST = "user_does_not_exist";
        const FIELD_NOT_EXIST = "user_field_does_not_exist";
        const UPDATE_PASS_NOT_EQUAL = "update_user_new_pass_not_equal";
    }

?>