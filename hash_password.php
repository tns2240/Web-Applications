<?php
$password = 'admin123'; // Choose a strong password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
?>