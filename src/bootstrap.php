<?php

define('EXT','.php');
define('APP_PATH','./app');

include 'resources/config/base.php';


// connexion à la base de données
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$db = new PDO($config['db'][$config['defaultDatabase']]['generic'],
			  $config['db'][$config['defaultDatabase']]['username'],
			  $config['db'][$config['defaultDatabase']]['password'], $pdo_options);

