<?php
include('connect.php');
unset($_SESSION['UID']);
unset($_SESSION['UNAME']);
header("Location: index.php");
?>