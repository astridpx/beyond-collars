<?php
session_start();
session_unset();
session_destroy();
header("Location: /bc/admin/index.php");
exit();
?>
