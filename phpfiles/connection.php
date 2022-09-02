<?php
$server = "us-cdbr-east-06.cleardb.net";
$username = "bee2eef6c5f3c7";
$dbname = "heroku_275cd760e77c089";
$password = "bd97b44a";

$conn = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
