<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <div class="d-flex align-items-center header-with-between mb-3">
        <h2 class="main-content-heading mb-0 pb-0">Max Mustermann Gmbh - Servicetechniker...</h2>
        <div class="d-flex align-items-center header-buttons">
            <button class="service-btn me-2">Lebenslauf anfordern</button>
            <button class="service-btn">Job Informationen senden</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title heading mb-1 d-flex align-items-center">Allgemeine Job Informationen</div>
                <hr class="divider" align="center">
                <div class="title service-title mb-1">Job Formular wurde ausgefullt</div>
                <div class="mini-taglines d-flex align-items-center">    
                    Jobtitel
                </div>
                <div class="title service-title mb-1">20095, Hamburg  69115, Heidelberg  10117, Berlin  </div>
                <div class="mini-taglines d-flex align-items-center">    
                    Jobtitel
                </div>
                <div class="title service-title mb-1">Vollzeit</div>
                <div class="mini-taglines d-flex align-items-center">    
                    Beschäftigungsform
                </div>
                <div class="title service-title mb-1">Mit Berufserfahrung</div>
                <div class="mini-taglines d-flex align-items-center mb-1">    
                    Erfahrung
                </div>
                <ul class="service-list">
                    <li>Premium Lage</li>
                    <li>Dienstwagen</li>
                    <li>geiles Team</li>
                </ul>
                <div class="mini-taglines d-flex align-items-center mb-1">    
                Benefits
                </div>
                <ul class="service-list">
                    <li>Aufgabe 1</li>
                    <li>Aufgabe 1</li>
                    <li>Aufgabe 1</li>
                </ul>
                <div class="mini-taglines d-flex align-items-center">    
                Aufgabenbereich
                </div>
            </div>
            <div class="card-box mt-3">
                <div class="title heading mb-1 d-flex align-items-center">Bewerber Informationen</div>
                <hr class="divider" align="center">
                <div class="title service-title mb-1">Peter Brechtl</div>
                <div class="mini-taglines d-flex align-items-center">    
                    Name
                </div>
                <div class="title service-title mb-1">nur generierter Lebenslauf vorhanden</div>
                <div class="mini-taglines d-flex align-items-center">    
                    Lebenslauf
                </div>
                <div class="title service-title mb-1">11.10.2001</div>
                <div class="mini-taglines d-flex align-items-center">    
                    Bewerbungsdatum
                </div>
                <div class="title service-title mb-1">Mit Berufserfahrung</div>
                <div class="mini-taglines d-flex align-items-center">    
                    Erfahrung
                </div>
                <div class="title service-title mb-1">97859</div>
                <div class="mini-taglines d-flex align-items-center">    
                    PLZ
                </div>
            </div>
            <div class="card-box mt-3">
                <div class="title heading mb-1 d-flex align-items-center">Firmen Informationen</div>
                <hr class="divider" align="center">
                <div class="title service-title mb-1">Max Mustermann Gmbh</div>
                <div class="mini-taglines d-flex align-items-center mb-1">    
                    Unternehmensnamen
                </div>
                <div class="title mb-1 d-flex align-items-center" style="margin-top:15px">Website <a><img height="19px" class="ms-2" src="<?=$configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div>
                <div class="mini-taglines d-flex align-items-center">  
                    Unternehmensnamen
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card-box">
                <div class="title heading mb-1 d-flex align-items-center">Posting Informationen</div>
                <hr class="divider" align="center">
                <div class="form-group mb-3">
                    <label>Wurde der Bewerber erreicht?</label>
                    <select class="form-control rounded-0 border-secondary outline-0 text-input">
                        <option>Select</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Weitere Erreichbarkeitsanmerkungen</label>
                    <select class="form-control rounded-0 border-secondary outline-0 text-input">
                        <option>Select</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Frage Katalog 1</label>
                    <select class="form-control rounded-0 border-secondary outline-0 text-input">
                        <option>Select</option>
                    </select>
                </div>
                <div class="d-flex align-items-center heading-divider">
                    <div class="divider-heading">Angenommen:&nbsp;&nbsp;</div>
                    <hr class="divider" width="80%" align="center">
                </div>
                <div class="form-group mb-3">
                    <label>Frage Katalog 2</label>
                    <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text">
                </div>
                <div class="form-group mb-3">
                    <label>Sprachniveau</label>
                    <select class="form-control rounded-0 border-secondary outline-0 text-input">
                        <option>Select</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Notizen (intern)</label>
                    <textarea class="form-control rounded-0 border-secondary outline-0 text-input" rows="7"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Extern</label>
                    <textarea class="form-control rounded-0 border-secondary outline-0 text-input" rows="7"></textarea>
                </div>
                <div class="form-group">
                    <label>Timeslots</label>
                    <div class="timeslot">
                        <div class="time-slot-heading">Slot 1</div>
                        <div class="row ">
                            <select class="col form-control rounded-0 border-secondary outline-0 text-input mt-1">
                                <option>Tues</option>
                            </select>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">Start</div>
                            </div>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">End</div>
                            </div>
                        </div>
                    </div>
                    <div class="timeslot">
                        <div class="time-slot-heading">Slot 1</div>
                        <div class="row ">
                            <select class="col form-control rounded-0 border-secondary outline-0 text-input mt-1">
                                <option>Tues</option>
                            </select>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">Start</div>
                            </div>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">End</div>
                            </div>
                        </div>
                    </div>
                    <div class="timeslot">
                        <div class="time-slot-heading">Slot 1</div>
                        <div class="row ">
                            <select class="col form-control rounded-0 border-secondary outline-0 text-input mt-1">
                                <option>Tues</option>
                            </select>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">Start</div>
                            </div>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">End</div>
                            </div>
                        </div>
                    </div>
                    <div class="timeslot">
                        <div class="time-slot-heading">Slot 1</div>
                        <div class="row ">
                            <select class="col form-control rounded-0 border-secondary outline-0 text-input mt-1">
                                <option>Tues</option>
                            </select>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">Start</div>
                            </div>
                            <div class="col-5 relative-position-input">
                                <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="text">
                                <div class="absolute-icon-text slot-label">End</div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="submit-btn">Speichern</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>