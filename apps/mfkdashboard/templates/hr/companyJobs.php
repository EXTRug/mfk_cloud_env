<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <div class="d-flex align-items-center mb-3">
        <a href="/index.php/apps/mfkdashboard/company-overview"><button class="return-button-x me-3"><img src="<?=$configurations['assets_path'] ?>/images/weui_arrow-filled.png"></button></a>
        <h2 class="main-content-heading mb-0 pb-0"><?php echo($company["name"]);?></h2>
    </div>
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
                <th>Job-Titel</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($jobs as $key => $job) {
                    echo('<tr><td><a href="/index.php/apps/mfkdashboard/'.$followingLink.'/'.$job['id'].'">'.$job["title"].'</a></td> <td class="d-flex align-items-center"><div class="status-dot" style="background-color:'.$job["color"].';"></div>'.$job["status"].'</td> </tr>');
                }
            ?>
        </tbody>
    </table>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>