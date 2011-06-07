<?php

if(!empty($_SESSION['id']))
{
	header("Location: index.php");
	unset($_SESSION['id']);
	unset($_SESSION['isAdmin']);
}