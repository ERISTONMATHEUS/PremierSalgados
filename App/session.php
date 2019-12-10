<?php
	session_start();

	require_once '../App/Models/connect.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$hashedPassword  = md5($_POST['password']);

	$connect->login($username, $hashedPassword, $password);