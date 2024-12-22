<?php

use Datahihi1\PhpDbConnector\MySqlQuery;

require_once 'vendor/autoload.php';

$host = 'localhost';
$name = 'root';
$pass = '';
$db = 'chat_app';

$query = new MySqlQuery(host: $host, username: $name, password: $pass, database: $db);

// # select all
// $test = $query->select('users')->execute();
// print_r($test);
// # select all with debug (show SQL query)
// $test = $query->select('users')->limit()->execute(true);
// print_r($test);
// # select all join
// $test = $query->select('users')->join("messages")->on("users.id","messages.user_id")->execute();
// print_r($test);

// # select where by id
// $test = $query->select('users','id,username,email')->where("id",1)->execute();
// print_r($test);
// # select where username like 'test'
// $test = $query->select(table: 'users',columns: 'id,username,email')->where(columns: "username",values: "test",operator: "LIKE")->execute();
// print_r($test);
// # select where username like 'test' with limit
// $test = $query->select(table: 'users')->where(columns: "username",values: "test",operator: "LIKE")->limit()->execute();
// print_r($test);
// # select 2 table where by table1.id
// $test = $query->select('users')->join("messages")->on("users.id","messages.user_id")->where("users.id",1)->execute();
// print_r($test);

// # insert
// $query->insert(table: 'users',columns: 'username,email,password')->values('hehe','hehe@mail','pass')->execute();
// //or
// $query->insert(table: 'users')->values( ['username' => 'hehe','email' => 'hehe@mail','password' => 'pass'])->execute();

# update
// $query->update("users")
//     ->set(["username" => "updateduser", "email" => "updated@example.com"])
//     ->where("id", 8)
//     ->execute();

# delete
// $query->delete("users")->where("id",8)->execute();