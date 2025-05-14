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
<input id="desc_prof" style="display: none;" value='<?php echo $campaign->desc_job; ?>'>
<input id="desc_social" style="display: none;" value='<?php echo $campaign->display_text; ?>'>
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
                <div class="title mb-1 d-flex align-items-center">Ordner<a href="https://cloud.ki-recruiter.com/index.php/apps/files/?dir=/03%20Marketing/01%20Kunden%20Marketing/<?php echo (urlencode($path)); ?>" target="_blank"><img height="19px" class="ms-2" src="<?= $configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?= $configurations['assets_path'] ?>/images/iconamoon_link-light.png">
                    Link zum Job Ordner
                </div>
                <?php
                if ($numberOfFiles == -1) {
                    echo ("<br><div>⚠️ Der Job Ordner ist nicht korrekt!</div>");
                }
                ?>
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
                    <div class="status-dot" style="background-color: <?php echo ($statusColor); ?>;"></div>
                    <div id="jobStatus"><?php echo ($job["status"]) ?></div>
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
                        echo (str_replace("\n", "<br>", $customerInput->requirements));
                    } ?>
                </div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Aufgabengebiet:
                </div>
                <div class="paragraph">
                    <?php if (isset($customerInput)) {
                        echo (str_replace("\n", "<br>", $customerInput->tasks));
                    } ?>
                </div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Benefits:
                </div>
                <div class="paragraph">
                    <?php if (isset($customerInput)) {
                        echo (str_replace("\n", "<br>", $customerInput->benefits));
                    } ?>
                </div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Unternehmensbeschreibung:
                </div>
                <div class="paragraph">
                    <?php echo (str_replace("\n", "<br>", $company["description"])); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title heading mb-1 d-flex align-items-center">Posting Informationen</div>
                <?php
                if (!$companyLogo) {
                    echo ("<br><div>⚠️ Diese Firma hat kein Logo!</div>");
                }
                ?>
                <hr class="divider" align="center">
                <div class="form-group mb-3">
                    <label>Stellenbezeichnung</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" id="title" type="text" value="<?php echo ($job["title"]); ?>">
                </div>
                <div class="form-group mb-3">
                    <label>Stellenbeschreibung Text (professionell):</label><br>
                    <a href="https://cloud.ki-recruiter.com/index.php/f/38172" target="_blank" style="color: blue !important;">professionelle Vorlage ↗️</a>
                    <div id="editor_area" class="text-editor-area"></div>
                    <div id="toolbar1">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Stellenbeschreibung Text (persönlicher):</label><br>
                    <a href="https://cloud.ki-recruiter.com/index.php/f/38212" target="_blank" style="color: blue !important;">kreative Vorlage ↗️</a>
                    <div id="editor_area_2" class="text-editor-area"></div>
                    <div id="toolbar2">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Link zur Stellenauschreibung</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="url" id="posting_link" value="<?php echo ($job["funnel_url"]) ?>">
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label>Bilderauswahl</label><br>
                    <span>
                        <?php
                        if ($numberOfFiles == 0) {
                            echo ("Aktuell sind <bold>keine</bold> Bilder ausgewählt.");
                        } elseif ($numberOfFiles == 1) {
                            echo ("Aktuell ist <bold>ein</bold> Bild ausgewählt.");
                        } else {
                            echo ("Aktuell sind <bold>" . $numberOfFiles . "</bold> Bilder ausgewählt.");
                        }
                        ?>
                    </span><br>
                </div>
                <div class="row">
                    <div class="form-group col mb-3">
                        <label>PLZ</label>
                        <!-- <input class="form-control rounded-0 border-secondary outline-0 text-input" type="number" value="<?php echo ($loc->plz); ?>" id="plz"> -->
                        <div class="benfit-section mb-3 mt-3" id="plzs">
                    </div>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" placeholder="PLZ" id="plz">
                        <button class="add-plz-button"><img src="<?= $configurations['assets_path'] ?>/images/formkit_add.png">&nbsp;&nbsp; Add</button>
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
                        <?php
                        $cat1 = html_entity_decode($campaign->ebay->job, ENT_QUOTES, 'UTF-8'); ?>
                        <select class="form-control rounded-0 border-secondary outline-0 text-input" id="ebay1">
                            <option <?php if ($cat1 == "Ausbildung") {
                                        echo ("selected");
                                    } ?>>Ausbildung</option>
                            <option <?php if ($cat1 == "Bau, Handwerk & Produktion") {
                                        echo ("selected");
                                    } ?>>Bau, Handwerk & Produktion</option>
                            <option <?php if ($cat1 == "Büroarbeit & Verwaltung") {
                                        echo ("selected");
                                    } ?>>Büroarbeit & Verwaltung</option>
                            <option <?php if ($cat1 == "Gastronomie & Tourismus") {
                                        echo ("selected");
                                    } ?>>Gastronomie & Tourismus</option>
                            <option <?php if ($cat1 == "Kundenservice & Call Center") {
                                        echo ("selected");
                                    } ?>>Kundenservice & Call Center</option>
                            <option <?php if ($cat1 == "Praktika") {
                                        echo ("selected");
                                    } ?>>Praktika</option>
                            <option <?php if ($cat1 == "Sozialer Sektor & Pflege") {
                                        echo ("selected");
                                    } ?>>Sozialer Sektor & Pflege</option>
                            <option <?php if ($cat1 == "Transport, Logistik & Verkehr") {
                                        echo ("selected");
                                    } ?>>Transport, Logistik & Verkehr</option>
                            <option <?php if ($cat1 == "Vertrieb, Einkauf & Verkauf") {
                                        echo ("selected");
                                    } ?>>Vertrieb, Einkauf & Verkauf</option>
                        </select>
                    </div>
                    <div class="form-group col mb-3">
                        <label>&nbsp;</label>
                        <select class="form-control rounded-0 border-secondary outline-0 text-input p-1" id="ebay2">
                            <?php
                            if ($campaign->ebay->sub_category != "") {
                                echo ('<option selected>' . $campaign->ebay->sub_category . '</option>');
                            } ?>
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
                <?php
                $btnText = "unbekannter Status";
                $disabled = "";
                if ($job["status"] == "In preparation") {
                    $btnText = "Freigabe anfordern";
                } elseif ($job["status"] == "active") {
                    $btnText = "Angaben aktualisieren";
                } elseif ($job["status"] == "archieved") {
                    $btnText = "Dieser Job ist archiviert.";
                    $disabled = "disabled";
                } elseif ($job["status"] == "In revision") {
                    $btnText = "Zur Kundenrevision freigeben";
                } else {
                    $disabled = "disabled";
                }
                ?>
                <button type="button" class="submit-btn" id="formSubmitBtn" <?php echo ($disabled); ?>><?php echo ($btnText); ?></button>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>