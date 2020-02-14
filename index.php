<?php

require_once 'validator.php';

if(isset($_GET['key']) && isset($_GET['email'])) {
    $validator = new Validator($_GET['key']);
    $validator->validate($_GET['email']);
} else {
    header('HTTP/1.0 403 Forbidden');
    exit();
}