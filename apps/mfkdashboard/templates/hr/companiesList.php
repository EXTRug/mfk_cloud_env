<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <h2 class="main-content-heading">Übersicht Firmen</h2>
    <div class="d-flex align-items-center filter-area">
        <div class="search-field d-flex align-items-center">
            <img src="<?= $configurations['assets_path'] ?>/images/iconamoon_search-light.png">
            <input id="searchbar" type="search">
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>

            <ul class="dropdown-menu">
                <li style="display: flex;" id="filterActiveCompanies">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor" class="bi bi-check2" viewBox="0 0 20 20" style="scale: 1.5;">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                    </svg>
                    <a class="dropdown-item">nur Aktive</a>
                </li>
            </ul>
        </div>
    </div>
    <table class="table rounded">
        <thead class="table-header">
            <tr background="#000">
                <th>Firmenname</th>
                <th>Kundenbeziehung</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($companies as $key => $company) {
                $satisfaction = "";
                $style = "";
                if ($company["satisfaction"] == 2) {
                    $satisfaction = "Sehr zufrieden";
                    $style = "color: green;";
                } elseif ($company["satisfaction"] == 1) {
                    $satisfaction = "zufrieden";
                } elseif ($company["satisfaction"] == 0) {
                    $satisfaction = "neutral";
                } elseif ($company["satisfaction"] == -1) {
                    $satisfaction = "Handlungsbedarf";
                    $style = "color: red;font-weight: bold !important;";
                }
                echo ('<tr> <td><a href="/index.php/apps/mfkdashboard/company-jobs/' . $mode . "/" . $company["companyID"] . '">' . $company["name"] . '</a></td><td style="' . $style . '">' . $satisfaction . '</td></tr>');
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>