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
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                    </div>
                    <div class="form-group col mb-4">
                        <label>Nachname</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-4">
                        <label>Ebay - Kategorie</label>
                        <select id="tom-select" class="form-control rounded-0 border-secondary outline-0 text-input">
                            <option>Select</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-4">
                        <label>Email</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="email">
                    </div>
                    <div class="form-group col mb-4">
                        <label>Phonenummer</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="tel">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label>Bilderauswahl</label>
                        <button class="drag-drop-button">
                            <img src="<?=$configurations['assets_path'] ?>/images/img.png">
                            Drag & Drop or <u>Upload</u>
                        </button>
                        <div class="selected-images p-2 mb-5">
                            <div class="selected-image d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="<?=$configurations['assets_path'] ?>/images/pencil.png">
                                    <div class="image-title">document.pdf <span class="image-size">(56kb)</span> <span class="image-progress">30%</span></div>
                                </div>
                                <button class="img-remove-button">
                                    <img src="<?=$configurations['assets_path'] ?>/images/delete-btn.png">
                                </button>
                            </div>
                            <div class="selected-image d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="<?=$configurations['assets_path'] ?>/images/imgdark.png">
                                    <div class="image-title">Image1.png <span class="image-size">(56kb)</span> <span class="image-progress">30%</span></div>
                                </div>
                                <button class="img-remove-button">
                                    <img src="<?=$configurations['assets_path'] ?>/images/delete-btn.png">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label>Nachricht in Notizen Chat</label>
                        <textarea class="form-control rounded-0 border-secondary outline-0 text-input" rows="7"></textarea>
                    </div>
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