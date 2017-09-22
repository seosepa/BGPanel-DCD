<?php
require 'vendor/autoload.php';

use BGPanelDCD\ServerConfig;

// in
$uri            = $_SERVER['REQUEST_URI'];
$remoteIp       = $_SERVER['REMOTE_ADDR'];

// compute
$configs        = ServerConfig::getConfigsByRemoteIp($remoteIp);
$encodedConfigs = json_encode($configs, JSON_PRETTY_PRINT);

// out
header("Content-type:application/json");
echo $encodedConfigs;

