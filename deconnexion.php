<?php
session_start();
session_unset();
session_destroy();

header("Location: Site/index.php");
?>