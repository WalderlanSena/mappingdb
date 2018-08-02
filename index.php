<?php

include_once "src/Mapping.php";

$app = new \App\Mapping($_SERVER);
$app->verifyArguments();
$app->init();