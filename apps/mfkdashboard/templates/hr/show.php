<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <div class="d-flex align-items-center">
        <button class="return-button"><img src="<?=$configurations['assets_path'] ?>/images/weui_arrow-filled.png"></button>
        <h2 class="main-content-heading">Übersicht Firmen</h2>
    </div>
    <div class="d-flex align-items-center filter-area">
        <div class="search-field d-flex align-items-center">
            <img src="<?=$configurations['assets_path'] ?>/images/iconamoon_search-light.png">
            <input type="search">
        </div>
        <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown link
            </a>

            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
    </div>
    <table class="table rounded">
        <thead class="table-header">
            <tr background="#000">
                <th>Firemenname</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Max Musterman Gmbh</td>
                <td class="d-flex align-items-center"><div class="status-dot active"></div> Active</td>
            </tr>
            <tr>
                <td>Max Musterman Gmbh</td>
                <td class="d-flex align-items-center"><div class="status-dot"></div> Offline</td>
            </tr>
        </tbody>
    </table>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>