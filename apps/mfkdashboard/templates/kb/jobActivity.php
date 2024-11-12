<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <div class="spacer-header">
        <div class="d-flex align-items-center mb-3">
        <a href="/index.php/apps/mfkdashboard/company-jobs/kb/<?php echo($job["company"]);?>"><button class="return-button-x me-3"><img src="<?=$configurations['assets_path'] ?>/images/weui_arrow-filled.png"></button></a>
            <div>
                <h2 class="main-content-heading mb-0 pb-0"><?php echo($job["title"]);?></h2>
                <div class="heading-tagline d-flex align-items-center"><?php echo('(ID: '.$job["funnel_name"].' | '.$job["id"].')');?> &nbsp;&nbsp;&nbsp;<div class="d-flex align-items-center"><div class="status-dot active"></div> <span style="color:var(--primary) !important; font-weight:600 !important;"><?php echo($job["status"]);?></span>&nbsp;&nbsp;&nbsp; (? Tage verbleibend)</div></div>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle header-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Zufriedenheit: <span class="header-dropdown-active">Sehr Gut</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="card-heading-small">Historie</div>
                        <div class="progress-list-items mt-3 pt-3">
                            <div class="progress-item">
                                <div>
                                    <div class="white-tip"></div>
                                    <div class="red-tip"></div>
                                </div>
                                <div class="progress-content pb-3">
                                    <div class="progress-heading" style="color:var(--primary) !important;">Job Formular wurde ausgefullt</div>
                                    <div class="progress-sub-heading">2 May 12:00PM</div>
                                </div>
                                <div class="progress-dot">
                                    <div class="progress-dot-point"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div>
                                    <div class="red-tip"></div>
                                    <div class="red-tip"></div>
                                </div>
                                <div class="progress-content pb-3">
                                    <div class="progress-heading">Job Formular wurde ausgefullt</div>
                                    <div class="progress-sub-heading">2 May 12:00PM</div>
                                </div>
                                <div class="progress-dot filled">
                                    <div class="progress-dot-point filled"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div>
                                    <div class="red-tip"></div>
                                    <div class="red-tip"></div>
                                </div>
                                <div class="progress-content pb-3">
                                    <div class="progress-heading">Job Formular wurde ausgefullt</div>
                                    <div class="progress-sub-heading">2 May 12:00PM</div>
                                </div>
                                <div class="progress-dot filled">
                                    <div class="progress-dot-point filled"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div>
                                    <div class="red-tip"></div>
                                    <div class="red-tip"></div>
                                </div>
                                <div class="progress-content pb-3">
                                    <div class="progress-heading">Job Formular wurde ausgefullt</div>
                                    <div class="progress-sub-heading">2 May 12:00PM</div>
                                </div>
                                <div class="progress-dot filled">
                                    <div class="progress-dot-point filled"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div>
                                    <div class="red-tip"></div>
                                    <div class="red-tip"></div>
                                </div>
                                <div class="progress-content pb-3">
                                    <div class="progress-heading">Job Formular wurde ausgefullt</div>
                                    <div class="progress-sub-heading">2 May 12:00PM</div>
                                </div>
                                <div class="progress-dot filled">
                                    <div class="progress-dot-point filled"></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <div>
                                    <div class="red-tip"></div>
                                    <div class="white-tip"></div>
                                </div>
                                <div class="progress-content pb-3">
                                    <div class="progress-heading">Job Formular wurde ausgefullt</div>
                                    <div class="progress-sub-heading">2 May 12:00PM</div>
                                </div>
                                <div class="progress-dot filled">
                                    <div class="progress-dot-point filled"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-heading-small">weitere Felder</div>
                        <div class="form-group mb-3 mt-3 pt-3">
                        <label>Vor Ort Termin</label>
                        <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" placeholder="Datum">
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card-box">
                <div class="card-heading-small">Neuer Call</div>
                <div class="row pt-3 mt-3"> 
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Upsell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Testimonial</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Emphfehlung</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:t&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Cross Sell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col-2" style="">
                        <button class="condition-btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card-box">
                <div class="card-heading-small">Angebots - Historie</div>
                <div class="condition-divider-heading pt-3 mt-3">(27.06.2024)</div>
                <div class="row"> 
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Upsell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Testimonial</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Emphfehlung</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                    <div class="col" style="padding-left:24px">
                        <div class="condition-title">Cross Sell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                </div>
                <hr class="divider" align="center">
                <div class="condition-divider-heading mt-3">(27.06.2024)</div>
                <div class="row"> 
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Upsell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Testimonial</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title">Emphfehlung</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                    <div class="col" style="padding-left:24px">
                        <div class="condition-title">Cross Sell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label>&nbsp;&nbsp;&nbsp;
                        <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/no.png"></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card-heading-small mt-3 pt-3 pb-3">Top Bewerber</div>
            <table class="table rounded">
                <thead class="table-header">
                    <tr background="#000">
                        <th>Name</th>
                        <th>Score</th>
                        <th>Vollständigkeit</th>
                        <th>Beworben am</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Max Musterman</td>
                        <td><span class="badge rounded-pill text-bg-success">100%</span></td>
                        <td><lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label></td>
                        <td><lable class="d-flex align-items-center condition-label">27.08.1999:</label></td>
                        <td><div class="title mb-1 d-flex align-items-center">Zum Portal <a><img height="19px" class="ms-2" src="<?=$configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div></td>
                    </tr>
                    <tr>
                        <td>Max Musterman</td>
                        <td><span class="badge rounded-pill text-bg-success">87%</span></td>
                        <td><lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="<?=$configurations['assets_path'] ?>/images/yes.png"></label></td>
                        <td><lable class="d-flex align-items-center condition-label">27.08.1999:</label></td>
                        <td><div class="title mb-1 d-flex align-items-center">Zum Portal <a><img height="19px" class="ms-2" src="<?=$configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div></td>
                    </tr>
                    <tr>
                        <td>Max Musterman</td>
                        <td><span class="badge rounded-pill text-bg-warning">65%</span></td>
                        <td><lable class="d-flex align-items-center condition-label">nur gen. Lebenslauf</label></td>
                        <td><lable class="d-flex align-items-center condition-label">27.08.1999:</label></td>
                        <td><div class="title mb-1 d-flex align-items-center">Zum Portal <a><img height="19px" class="ms-2" src="<?=$configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card-heading-small mt-3 pt-3 pb-3">Kunden Benachrichtigungen Konsole</div>
            <div style="font-size:20px line-height:24px; margin-bottom:15px">Bewerber Benachrichtigungen:</div>
            <table class="table rounded" style="width: 100%; border-collapse: collapse;">
    <thead style="background: #000; color: #fff;">
        <tr>
            <th style="padding: 10px !important; text-align: left;">Jobs</th>
            <th style="padding: 10px; text-align: center;">Manager 1</th>
            <th style="padding: 10px; text-align: center;">Manager 2</th>
            <th style="padding: 10px; text-align: center;">Manager 3</th>
            <th style="padding: 10px; text-align: center;">Manager 4</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 10px; border-right: 1px solid var(--seventh); text-align: left;">Job 1</td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
        </tr>
        <tr>
            <td style="padding: 10px; border-right: 1px solid var(--seventh); text-align: left;">Job 2</td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/no.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
        </tr>
        <tr>
            <td style="padding: 10px; border-right: 1px solid var(--seventh); text-align: left;">Job 2</td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/no.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
            <td style="padding: 10px; text-align: center;"><img src="<?=$configurations['assets_path'] ?>/images/yes.png"></td>
        </tr>
    </tbody>
</table>    

        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>