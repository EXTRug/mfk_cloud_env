<div style="width: 200px;height: 94vh">
    <div class="">
        <h4 class="text-center dashboard-title">Ansichten</h4>
        <ul class="flex-column sidebar-list">
                <?php 
                    foreach ($navLinks as $key => $link) {
                        echo('<li class="sidebar-item"><a class="nav-link text-center" href="/index.php/apps/mfkdashboard/'.$link["path"].'">'.$link["title"].'</a></li>');
                    }
                ?>
        </ul>
    </div>
</div>