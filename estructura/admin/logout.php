<?php

session_start();

//Si no hay un usuario logueado, redireccionar a "~/"
if(!isset($_SESSION['usr']))
{
	header('Location: ../');
	die();
}

$_SESSION = array();
session_destroy();

header('Location: ./');