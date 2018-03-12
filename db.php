<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'lebran_payroll';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
