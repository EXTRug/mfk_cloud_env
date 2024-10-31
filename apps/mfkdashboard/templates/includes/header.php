<?php
$configurations = require_once __DIR__ . '/../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        foreach ($configurations['css_external'] as $key => $value) {
            echo '<link rel="stylesheet" type="text/css" href="' .$value . '" />';
        }
        foreach ($configurations['css_internal'] as $key => $value) {
            echo '<link rel="stylesheet" type="text/css" href="' .$configurations['assets_path']. $value . '" />';
        }
    ?>
    <title>Dashboard | <?= $page_title ?? '😶' ?></title>
</head>
<body>
    <div class="w-100 body-wrapper">
        <!-- Navigation -->
        <?php include_once __DIR__ . '/navigation.php'; ?>
        <!-- Container with Sidebar and Main Content -->
        <div class="d-flex">
            <!-- Sidebar -->
            <?php include_once __DIR__ . '/sidebar.php'; ?>
            
        
    
