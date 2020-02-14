<?php

require __DIR__ . '/vendor/autoload.php';


class Validator {

    private $auth_code;
    // Set the correct auth code to check
    private static $valid_auth_code = '123';

    function __construct($auth_code)
    {
        $this->auth_code = $auth_code;
    }

    /*
     * Will be called before any method. Middleware
     */
    function beforeCall()
    {
        if ($this->auth_code != self::$valid_auth_code) {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }
    }

    /*
     * Validation using email
     */
    function validate($email)
    {
        $this->beforeCall();
        $validator = EmailValidation\EmailValidatorFactory::create($email);
        header('Content-Type: application/json');
        echo json_encode($validator->getValidationResults()->asJson());
        exit();
    }

}