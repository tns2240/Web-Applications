<?php
session_start();
session_destroy();
header('Location: Login Page.html');
exit;
?>