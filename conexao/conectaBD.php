<?php

$localhost = 'localhost';
$dbname = 'SCHOOL';
$user = 'postgres';
$password = 'sampaio1319';

try {
    $pdo = new PDO("pgsql:host=$localhost;port=5432;dbname=$dbname",$user,$password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo $e->getMessage();
}