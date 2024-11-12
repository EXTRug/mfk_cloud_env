<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <h2 class="main-content-heading">Übersicht Firmen</h2>
    <div class="d-flex align-items-center filter-area">
        <div class="search-field d-flex align-items-center">
            <img src="<?=$configurations['assets_path'] ?>/images/iconamoon_search-light.png">
            <input id="searchbar" type="search">
        </div>
        <!-- <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>

            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div> -->
    </div>
    <table class="table rounded">
        <thead class="table-header">
            <tr background="#000">
                <th>Firmenname</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($companies as $key => $company) {
                echo('<tr> <td><a href="/index.php/apps/mfkdashboard/company-jobs/'.$mode."/".$company["companyID"].'">'.$company["name"].'</a></td></tr>');
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>