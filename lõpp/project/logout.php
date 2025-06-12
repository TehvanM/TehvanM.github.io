<?php
require_once 'config.php';

// Hävita sessioon
havitaSessioon();

// Suuna sisselogimislehele
header('Location: login.php');
exit;
?>