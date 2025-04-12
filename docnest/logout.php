<?php
session_start();
session_destroy();
header("Location: hospital_login.php");
exit();
?>
