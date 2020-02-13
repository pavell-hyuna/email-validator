<?php

require_once 'validator.php';

$validator = new Validator($_GET['key']);
$validator->validate($_GET['email']);