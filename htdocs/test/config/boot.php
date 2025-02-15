<?php

include 'util.php';

error_reporting (E_ALL ^ E_NOTICE);
$db = new Mysqli('localhost','root','','studenten'); 
$status = new Status();