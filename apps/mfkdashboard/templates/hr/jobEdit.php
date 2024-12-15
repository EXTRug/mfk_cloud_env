<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
$campaign = json_decode($job["campaign"]);
if ($job["salary_range"] != null) {
    $salary = json_decode($job["salary_range"]);
}
if ($job["customerInput"] != null) {
    $customerInput = json_decode($job["customerInput"]);
}
?>
<!-- Main Content -->
<input type="text" name="" id="desc_prof" style="display: none;" value='<?php echo (json_encode($campaign->desc_job)); ?>'>
<input type="text" name="" id="desc_social" style="display: none;" value='<?php echo (json_encode($campaign->display_text)); ?>'>
<input type="text" name="" id="benefit_list" style="display: none;" value='<?php echo (json_encode($campaign->benefits)); ?>'>
<input type="text" name="" id="ebay_data" style="display: none;" value='<?php echo ($campaign->ebay->sub_category . "#" . $campaign->ebay->job); ?>'>
<div class="container-fluid p-5 main-content-area">
    <div class="d-flex align-items-center mb-3">
        <a href="/index.php/apps/mfkdashboard/company-jobs/hr/<?php echo ($job["company"]); ?>"><button class="return-button-x me-3"><img src="<?= $configurations['assets_path'] ?>/images/weui_arrow-filled.png"></button></a>
        <div>
            <h2 class="main-content-heading mb-0 pb-0"><?php echo ($job["title"]); ?></h2>
            <div class="heading-tagline"><?php echo ('(ID: ' . $job["funnel_name"] . ' | ' . $job["id"] . ')'); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card-box">
                <div class="title mb-1"><?php $loc = json_decode($job["location"])[0];
                                        echo ($loc->plz . ", " . $loc->city); ?></div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?= $configurations['assets_path'] ?>/images/ep_location.png">
                    Adresse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box">
                <?php
                if ($job["jobFolder"] != null) {
                    $path = $job["jobFolder"];
                } else {
                    $path = urlencode($company["name"] . " - " . $job["company"] . "/" . $job["funnel_name"]);
                }
                ?>
                <div class="title mb-1 d-flex align-items-center">Ordner<a href="https://cloud.ki-recruiter.com/index.php/apps/files/?dir=/03%20Marketing/01%20Kunden%20Marketing/<?php echo ($path); ?>" target="_blank"><img height="19px" class="ms-2" src="<?= $configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?= $configurations['assets_path'] ?>/images/iconamoon_link-light.png">
                    Link zum Job Ordner
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title mb-1"><?php echo ($campaign->industry); ?></div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?= $configurations['assets_path'] ?>/images/ep_location.png">
                    Job - Kategorie
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title mb-1 d-flex align-items-center">
                    <div class="status-dot" style="background-color: <?php echo ($statusColor); ?>;"></div> <?php echo ($job["status"]) ?>
                </div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?= $configurations['assets_path'] ?>/images/iconamoon_link-light.png">
                    Status des Jobs
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title heading mb-1 d-flex align-items-center">Allgemeine Job Informationen</div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Anforderungen:
                </div>
                <div class="paragraph">
                    <?php if (isset($customerInput)) {
                        echo ($customerInput->requirements);
                    } ?>
                </div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Aufgabengebiet:
                </div>
                <div class="paragraph">
                    <?php if (isset($customerInput)) {
                        echo ($customerInput->tasks);
                    } ?>
                </div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Benefits:
                </div>
                <div class="paragraph">
                    <?php if (isset($customerInput)) {
                        echo ($customerInput->benefits);
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title heading mb-1 d-flex align-items-center">Posting Informationen</div>
                <hr class="divider" align="center">
                <div class="form-group mb-3">
                    <label>Stellenbezeichnung</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" id="title" type="text" value="<?php echo ($job["title"]); ?>">
                </div>
                <div class="form-group mb-3">
                    <label>Stellenbeschreibung Text (professionell):</label>
                    <div id="editor_area" class="text-editor-area"></div>
                    <div id="toolbar1">
                        <select class="ql-size">
                            <option value="small"></option>
                            <option selected></option>
                            <option value="large"></option>
                            <option value="huge"></option>
                        </select>
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <select class="ql-align">
                            <option selected></option>
                            <option value="center"></option>
                            <option value="right"></option>
                            <option value="justify"></option>
                        </select>
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Stellenbeschreibung Text (persönlicher):</label>
                    <div id="editor_area_2" class="text-editor-area"></div>
                    <div id="toolbar2">
                        <select class="ql-size">
                            <option value="small"></option>
                            <option selected></option>
                            <option value="large"></option>
                            <option value="huge"></option>
                        </select>
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <select class="ql-align">
                            <option selected></option>
                            <option value="center"></option>
                            <option value="right"></option>
                            <option value="justify"></option>
                        </select>
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Link zur Stellenauschreibung</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="url" id="posting_link" value="<?php echo ($job["funnel_url"]) ?>">
                </div>
                <div class="form-group">
                    <label>Bilderauswahl</label>
                    <button class="drag-drop-button">
                        <img src="<?= $configurations['assets_path'] ?>/images/img.png">
                        Upload Image
                    </button>
                    <div class="selected-images p-2 mb-5">
                        <div class="selected-image d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="<?= $configurations['assets_path'] ?>/images/imgdark.png">
                                <div class="image-title">Image1.png <span class="image-size">(56kb)</span> <span class="image-progress">30%</span></div>
                            </div>
                            <button class="img-remove-button">
                                <img src="<?= $configurations['assets_path'] ?>/images/delete-btn.png">
                            </button>
                        </div>
                        <div class="selected-image d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="<?= $configurations['assets_path'] ?>/images/imgdark.png">
                                <div class="image-title">Image1.png <span class="image-size">(56kb)</span> <span class="image-progress">30%</span></div>
                            </div>
                            <button class="img-remove-button">
                                <img src="<?= $configurations['assets_path'] ?>/images/delete-btn.png">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-3">
                        <label>PLZ</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="number" value="<?php echo ($loc->plz); ?>" id="plz">
                    </div>
                    <!-- <div class="form-group col mb-3">
                        <label>&nbsp;</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="number" placeholder="Radius km">
                    </div> -->
                </div>
                <div class="row">
                    <div class="form-group col mb-3 relative-position-input">
                        <label>Gehaltsrange</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5" type="number" id="salaryMin" value="<?php if (isset($salary)) {
                                                                                                                                                    echo ($salary->start);
                                                                                                                                                } ?>">
                        <img src="<?= $configurations['assets_path'] ?>/images/tabler_coin-euro.png" class="absolute-icon-text">
                    </div>
                    <div class="form-group col mb-3 relative-position-input">
                        <label></label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5" type="number" id="salaryMax" value="<?php if (isset($salary)) {
                                                                                                                                                    echo ($salary->stop);
                                                                                                                                                } ?>">
                        <img src="<?= $configurations['assets_path'] ?>/images/tabler_coin-euro.png" class="absolute-icon-text">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-3">
                        <label>Ebay - Kategorie</label>
                        <select class="form-control rounded-0 border-secondary outline-0 text-input" id="ebay1">
                            <option>Ausbildung</option>
                            <option>Bau, Handwerk & Produktion</option>
                            <option>Büroarbeit & Verwaltung</option>
                            <option>Gastronomie & Tourismus</option>
                            <option>Kundenservice & Call Center</option>
                            <option>Praktika</option>
                            <option>Sozialer Sektor & Pflege</option>
                            <option>Transport, Logistik & Verkehr</option>
                            <option>Vertrieb, Einkauf & Verkauf</option>
                        </select>
                    </div>
                    <div class="form-group col mb-3">
                        <label>&nbsp;</label>
                        <select class="form-control rounded-0 border-secondary outline-0 text-input p-1" id="ebay2">
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Benefits</label>
                    <div class="benfit-section mb-3 mt-3" id="benefits">
                    </div>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" placeholder="Benefit" id="newBenefit">
                    <button class="add-benifit-button"><img src="<?= $configurations['assets_path'] ?>/images/formkit_add.png">&nbsp;&nbsp; Add</button>
                </div>
                <div class="form-group mb-3">
                    <label>Ansprechpartner</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" id="asp" type="text" value="<?php echo ($job["asp"]); ?>">
                </div>
                <button type="button" class="submit-btn">Zur Kundenrevision freigeben</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>