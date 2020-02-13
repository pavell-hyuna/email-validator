<?php

require __DIR__ . '/vendor/autoload.php';

class Validator {

    private $auth_code;
    private $valid_domains;
    private static $valid_auth_code = '123';

    function __construct($auth_code, $valid_domains=['my.projectarmy.net', 'dev.projectarmy.net'])
    {
        $this->auth_code = $auth_code;
        $this->valid_domains = $valid_domains;
    }

    public function __call($method, $arguments) {
        if(method_exists($this, $method)) {
            $this->beforeCall();
            return call_user_func_array(array($this,$method),$arguments);
        }
    }

    function beforeCall()
    {
        if(!in_array(parse_url($_SERVER['HTTP_REFERER']), $this->valid_domains) || $this->auth_code != self::$valid_auth_code) {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }
    }

    function validate($email)
    {
        $validator = EmailValidation\EmailValidatorFactory::create($email);
        header('Content-Type: application/json');
        echo json_encode($validator->getValidationResults()->asJson());
        exit();
    }

}