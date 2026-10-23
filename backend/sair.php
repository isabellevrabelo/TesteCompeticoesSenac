<?php
session_start();
session_destroy();
session_unset();
header("Location: /teste/index.php");
exit();
?>