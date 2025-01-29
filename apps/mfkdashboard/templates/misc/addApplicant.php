<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <h2 class="main-content-heading mb-2 pb-0">Bewerber manuell hinzufügen</h2>


    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card-box">
                <div class="title heading mb-1 d-flex align-items-center">Bewerber Informationen</div>
                <hr class="divider" align="center">
                <div class="row">
                    <div class="form-group col mb-4">
                        <label>Vorname</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" id="firstname">
                    </div>
                    <div class="form-group col mb-4">
                        <label>Nachname*</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" id="lastname" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-4">
                        <div class="dropdown">
                            <button id="job-dropdown" class="dropbtn">Funnel Auswählen</button>
                            <div id="myDropdown" class="dropdown-content">
                                <input type="text" placeholder="Search.." id="job-dropdown-search">
                                <?php 
                                foreach ($jobs as $key => $job) {
                                   echo('<a>'.$job["funnel_name"].'</a>');
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-4">
                        <label>Email*</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="email" id="email" required>
                    </div>
                    <div class="form-group col mb-4">
                        <label>Telefonnummer</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="tel" id="phone" placeholder="49111111111111">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label>Lebenslauf hochladen</label>
                        <button class="drag-drop-button">
                            <img src="<?= $configurations['assets_path'] ?>/images/img.png">
                            Drag & Drop or <u>Upload</u>
                            <input type="file" id="fileInput" hidden>
                        </button>
                        <div class="selected-images p-2 mb-5">
                        </div>
                    </div>
                    <!-- <div class="form-group col">
                        <label>Nachricht in Notizen Chat</label>
                        <textarea class="form-control rounded-0 border-secondary outline-0 text-input" rows="7"></textarea>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-6 m-auto">
                        <button class="submit-btn" type="button">Bewerber anlegen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>