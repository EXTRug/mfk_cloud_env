<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <div class="d-flex align-items-center mb-3">
        <button class="return-button-x me-3"><img src="<?=$configurations['assets_path'] ?>/images/weui_arrow-filled.png"></button>
        <div>
            <h2 class="main-content-heading mb-0 pb-0">Max Mustermann Gmbh</h2>
            <div class="heading-tagline">(ID: Funnelname | 765432)</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card-box">
                <div class="title mb-1">Drehbahn 7, 97555 Hamburg</div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?=$configurations['assets_path'] ?>/images/ep_location.png">    
                    Adresse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box">
                <div class="title mb-1 d-flex align-items-center">Media <a><img height="19px" class="ms-2" src="<?=$configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?=$configurations['assets_path'] ?>/images/iconamoon_link-light.png">    
                    Link zum Media Ordner
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title mb-1">Handwerk</div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?=$configurations['assets_path'] ?>/images/ep_location.png">    
                    Job - Kategorie
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title mb-1 d-flex align-items-center"><div class="status-dot info"></div> In Bearbeitung</div>
                <div class="mini-taglines d-flex align-items-center">
                    <img class="me-1" src="<?=$configurations['assets_path'] ?>/images/iconamoon_link-light.png">    
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
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et.
                </div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Anforderungen:
                </div>
                <div class="paragraph">
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et.
                </div>
                <hr class="divider" align="center">
                <div class="sub-heading mb-2">
                    Anforderungen:
                </div>
                <div class="paragraph">
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et.
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title heading mb-1 d-flex align-items-center">Posting Informationen</div>
                <hr class="divider" align="center">
                <div class="form-group mb-3">
                    <label>Stellenbezeichnung</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                </div>
                <div class="form-group mb-3">
                    <label>Stellenbezeichnung</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                </div>
                <div class="form-group mb-3">
                    <label>Stellenbezeichnung</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>