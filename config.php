<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';

define("HOST", "localhost");
define("USER", 'postgres');
define("PASSWORD", 'root');
define("DBNAME", "guestbook");
define("CHARSET", "utf8");
define("SALT", "first");
