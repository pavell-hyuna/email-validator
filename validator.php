<?php

require __DIR__ . '/vendor/autoload.php';


class Validator {

    private $auth_code;
    private $valid_domains;
    // Set the correct auth code to check
    private static $valid_auth_code = '123';

    function __construct($auth_code, $valid_domains=['my.projectarmy.net', 'dev.projectarmy.net'])
    {
        $this->auth_code = $auth_code;
        $this->valid_domains = $valid_domains;
    }

    /*
     * Magic method that is using "beforeCall" to restrict if there are
     * invalid domains or auth code
     */
    public function __call($method, $arguments) {
        if(method_exists($this, $method)) {
            $this->beforeCall();
            return call_user_func_array(array($this,$method),$arguments);
        }
    }

    /*
     * Will be called before any method
     */
    function beforeCall()
    {
        print_r($this->auth_code);
        print_r(self::$valid_auth_code);
        die();

        if(!in_array(parse_url($_SERVER['HTTP_REFERER']), $this->valid_domains) || $this->auth_code != self::$valid_auth_code) {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }
    }

    /*
     * Validation using email
     */
    function validate($email)
    {
        $validator = EmailValidation\EmailValidatorFactory::create($email);
        header('Content-Type: application/json');
        echo json_encode($validator->getValidationResults()->asJson());
        exit();
    }

}