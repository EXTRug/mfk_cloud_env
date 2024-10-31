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
        foreach ($configurations['css'] as $key => $value) {
            echo '<link rel="stylesheet" type="text/css" href="' . $value . '" />';
        }
    ?>
    <title>Dashboard | <?= $page_title ?? '😶' ?></title>
</head>
<body>
    <div>
        <!-- Navigation -->
        <?php include_once __DIR__ . '/navigation.php'; ?>
        <!-- Container with Sidebar and Main Content -->
        <div class="d-flex">
            <!-- Sidebar -->
            <?php include_once __DIR__ . '/sidebar.php'; ?>
            
        
    
