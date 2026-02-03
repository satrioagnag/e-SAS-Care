<?php
require_once 'config/database.php';
require_once 'classes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$functions = new Functions($koneksi);
$user_data = $functions->getUserData($_SESSION['id_user']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-SAS Care</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">