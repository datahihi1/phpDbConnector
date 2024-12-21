<?php
use Datahihi1\PhpDbConnector\MySqlQuery;
require_once 'vendor/autoload.php';

// use Datahihi1\PhpDbConnector\MySqlQuery;
// use Datahihi1\TinyEnv\TinyEnv;
// (new TinyEnv(__DIR__))->load();
// use function Datahihi1\TinyEnv\env;

// $host = env('HOST','localhost');
// $name = env('NAME','root');
// $pass = env('PASS','');
// $db = env('DB','chat_app');

$host = 'localhost';
$name = 'root';
$pass = '';
$db = 'chat_app';

$query = new MySqlQuery($host,$name,$pass, $db);

$test = $query->select('users')->execute();
print_r($test);