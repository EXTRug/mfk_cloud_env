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
                <div class="form-group">
                    <label>Bilderauswahl</label>
                    <button class="drag-drop-button">
                        <img src="<?=$configurations['assets_path'] ?>/images/img.png">
                        Upload Image
                    </button>
                    <div class="selected-images p-2 mb-5">
                        <div class="selected-image d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="<?=$configurations['assets_path'] ?>/images/imgdark.png">
                                <div class="image-title">Image1.png <span class="image-size">(56kb)</span> <span class="image-progress">30%</span></div>
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
                <div class="row">
                    <div class="form-group col mb-3">
                        <label>Postleitzahl Ausstrahlung</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" placeholder="https://" value="https://">
                    </div>
                    <div class="form-group col mb-3">
                        <label>&nbsp;</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-3 relative-position-input">
                        <label>Postleitzahl Ausstrahlung</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5" type="text">
                        <img src="<?=$configurations['assets_path'] ?>/images/tabler_coin-euro.png" class="absolute-icon-text">
                    </div>
                    <div class="form-group col mb-3 relative-position-input">
                        <label>Postleitzahl Ausstrahlung</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5" type="text">
                        <img src="<?=$configurations['assets_path'] ?>/images/tabler_coin-euro.png" class="absolute-icon-text">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col mb-3">
                        <label>Ebay - Kategorie</label>
                        <select class="form-control rounded-0 border-secondary outline-0 text-input">
                            <option>Select</option>
                        </select>
                    </div>
                    <div class="form-group col mb-3">
                        <label>&nbsp;</label>
                        <select class="form-control rounded-0 border-secondary outline-0 text-input p-1">
                            <option>Select</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Link Stellenauschreibung</label>
                    <div class="benfit-section mb-3 mt-3">
                        <div class="benifit-item">
                            <div class="benifit-title">Flexible Enivornemnt</div>
                            <button class="img-remove-button">
                                <img src="<?=$configurations['assets_path'] ?>/images/delete-btn.png">
                            </button>
                        </div>
                    </div>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" placeholder="Benifit">
                    <button class="add-benifit-button"><img src="<?=$configurations['assets_path'] ?>/images/formkit_add.png">&nbsp;&nbsp; Add</button>
                </div>
                <div class="form-group mb-3">
                    <label>Ansprechpartner</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                </div>
                <button type="button" class="submit-btn">Zur Kundenrevision freigeben</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>