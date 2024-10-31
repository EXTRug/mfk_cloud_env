<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-4 main-content-area">
    <h2>Main Content</h2>
    <p>This is where the main content will appear.</p>
    
    <?php include(__DIR__ . '/../components/datatable.php'); ?>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>