<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
$daysRemaining = "";
if ($job["duration"] != null) {
    $date = new DateTime($job["duration"]);
    $today = new DateTime();
    $daysRemaining = $today->diff($date)->days;
}
?>
<!-- Main Content -->
<input type="hidden" value="<?php echo($job["company"]);?>" id="company_id">
<div class="container-fluid p-5 main-content-area">
    <div class="spacer-header">
        <div class="d-flex align-items-center mb-3">
            <a href="/index.php/apps/mfkdashboard/company-jobs/kb/<?php echo ($job["company"]); ?>"><button class="return-button-x me-3"><img src="<?= $configurations['assets_path'] ?>/images/weui_arrow-filled.png"></button></a>
            <div>
                <h2 class="main-content-heading mb-0 pb-0"><?php echo ($job["title"]); ?></h2>
                <div class="heading-tagline d-flex align-items-center"><?php echo ('(ID: ' . $job["funnel_name"] . ' | ' . $job["id"] . ')'); ?> &nbsp;&nbsp;&nbsp;<div class="d-flex align-items-center">
                        <div class="status-dot" style="background-color: <?php echo($statusColor);?>;"></div> <span style="color:var(--primary) !important; font-weight:600 !important;"><?php echo ($job["status"]); ?></span>&nbsp;&nbsp;&nbsp; (<?php echo ($daysRemaining); ?> Tage verbleibend)
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle header-dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Zufriedenheit: <span id="customer_satisfaction_display"><?php if ($company["satisfaction"] == 2) {
                                            echo ("Sehr zufrieden");
                                        } elseif ($company["satisfaction"] == 1) {
                                            echo ("zufrieden");
                                        } elseif ($company["satisfaction"] == 0) {
                                            echo ("neutral");
                                        } elseif ($company["satisfaction"] == -1) {
                                            echo ("Handlungsbedarf");
                                        } ?></span>
            </button>
            <ul class="dropdown-menu" id="customer_relation">
                <li><a class="dropdown-item" data-satifaction="2"<?php if ($company["satisfaction"] == 2) {
                                                    echo ("selected");
                                                } ?>>Sehr zufrieden</a></li>
                <li><a class="dropdown-item" data-satifaction="1"<?php if ($company["satisfaction"] == 1) {
                                                    echo ("selected");
                                                } ?>>zufrieden</a></li>
                <li><a class="dropdown-item" data-satifaction="0"<?php if ($company["satisfaction"] == 0) {
                                                    echo ("selected");
                                                } ?>>neutral</a></li>
                <li><a class="dropdown-item" data-satifaction="-1"<?php if ($company["satisfaction"] == -1) {
                                                    echo ("selected");
                                                } ?>>Handlungsbedarf</a></li>
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
                            <?php
                            $first = true;
                            foreach ($job["history"] as $key => $event) {
                                $date = new DateTime($event["timestamp"]);
                                $formatedDate = $date->format('j M H:i');
                                if (!$first) {
                                    echo (' <div class="progress-item"> <div> <div class="red-tip"></div> <div class="red-tip"></div> </div> <div class="progress-content pb-3"> <div class="progress-heading">' . $event["title"] . '</div> <div class="progress-sub-heading">' . $formatedDate . '</div> </div> <div class="progress-dot filled"> <div class="progress-dot-point filled"></div> </div> </div>');
                                } else {
                                    echo (' <div class="progress-item"> <div> <div class="white-tip"></div> <div class="red-tip"></div> </div> <div class="progress-content pb-3"> <div class="progress-heading" style="color:var(--primary) !important;">' . $event["title"] . '</div> <div class="progress-sub-heading">' . $formatedDate . '</div> </div> <div class="progress-dot"> <div class="progress-dot-point"></div> </div> </div>');
                                    $first = false;
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-heading-small">weitere Felder</div>
                        <div class="form-group mb-3 mt-3 pt-3">
                            <label>Vor Ort Termin</label>
                            <input class="form-control rounded-0 border-secondary outline-0 text-input" type="date" placeholder="Datum">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card-box">
                <div class="card-heading-small">Neuer Call</div>
                <div class="row pt-3 mt-3" id="logCallContainer">
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title" id="log-upsell">Upsell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title" id="log-testimonial">Testimonial</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title" id="log-recommendation">Empfehlung</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
                        <div class="condition-title" id="log-crossSell">Cross Sell</div>
                        <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>&nbsp;&nbsp;&nbsp;
                            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <input type="checkbox" class="custom-checkbox"></label>
                    </div>
                    <div class="col-2" style="">
                        <button class="condition-btn" id="logCall">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card-box" id="kbCallsContainer">
                <div class="card-heading-small">Angebots - Historie</div>
                <?php
                foreach ($calls as $key => $call) {
                    $timestamp = strtotime($call["timestamp"]);
                    $time = date('d.m.Y',$timestamp);
                    if($call["upsellPitched"]){$upsell_pitched = "yes";}else{$upsell_pitched = "no";};
                    if($call["upsellSold"]){$upsell_sold = "yes";}else{$upsell_sold = "no";};
                    if($call["testimonialPitched"]){$testimonial_pitched = "yes";}else{$testimonial_pitched = "no";};
                    if($call["testimonialSold"]){$testimonial_sold = "yes";}else{$testimonial_sold = "no";};
                    if($call["recommendationPitched"]){$recommendation_pitched = "yes";}else{$recommendation_pitched = "no";};
                    if($call["recommendationSold"]){$recommendation_sold = "yes";}else{$recommendation_sold = "no";};
                    if($call["crossSellPitched"]){$crossSell_pitched = "yes";}else{$crossSell_pitched = "no";};
                    if($call["crossSellSold"]){$crossSell_sold = "yes";}else{$crossSell_sold = "no";};
                    echo('<hr class="divider" align="center"> <div class="condition-divider-heading mt-3">('.$time.')</div> <div class="row"> <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px"> <div class="condition-title">Upsell</div> <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$upsell_pitched.'.png"></label>&nbsp;&nbsp;&nbsp; <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$upsell_sold.'.png"></label> </div> <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px"> <div class="condition-title">Testimonial</div> <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$testimonial_pitched.'.png"></label>&nbsp;&nbsp;&nbsp; <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$testimonial_sold.'.png"></label> </div> <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px"> <div class="condition-title">Empfehlung</div> <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$recommendation_pitched.'.png"></label>&nbsp;&nbsp;&nbsp; <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$recommendation_sold.'.png"></label> </div> <div class="col" style="padding-left:24px"> <div class="condition-title">Cross Sell</div> <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$crossSell_pitched.'.png"></label>&nbsp;&nbsp;&nbsp; <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$crossSell_sold.'.png"></label> </div> </div>');
                }
                ?>
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
                    <?php 
                    foreach ($topApplicants as $key => $applicant) {
                        if($applicant["score"] == null){
                            $score = 0;
                        }else{
                            $score = intval($applicant["score"]);
                        }
                        if(str_contains($applicant["cv"], "mfkgen_")){
                            $cv = "generiert";
                            $cv_img = "yes";
                        }else{
                            $cv = "eigener";
                            $cv_img = "yes";
                        }
                        if($applicant["cv"] == null){
                            $cv = "fehlt";
                            $cv_img = "no";
                        }
                        if($score < 25){
                            $bg_color = "text-bg-danger";
                        }elseif($score < 76){
                            $bg_color = "text-bg-warning";
                        }else{
                            $bg_color = "text-bg-success";
                        }
                        echo('<tr><td>'.$applicant["firstname"].' '.$applicant["lastname"].'</td> <td><span class="badge rounded-pill '.$bg_color.'">'.$score.'%</span></td> <td> <lable class="d-flex align-items-center condition-label">'.$cv.'&nbsp;&nbsp;&nbsp; <img src="/apps/mfkdashboard/assets/images/'.$cv_img.'.png"></label> </td> <td> <lable class="d-flex align-items-center condition-label">'.$applicant["joined"].':</label> </td> <td> <div class="title mb-1 d-flex align-items-center">Zum Portal <a href="https://app.ki-recruiter.com/index.php/applicant/'.urlencode($applicant["email"]).'?job='.$job["id"].'" target="_blank"><img height="19px" class="ms-2" src="/apps/mfkdashboard/assets/images/iconamoon_link-external-light.png"></a></div> </td></tr>');
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card-heading-small mt-3 pt-3 pb-3">Kunden Benachrichtigungen Konsole</div>
            <table class="table rounded" style="width: 100%; border-collapse: collapse;">
                <thead style="background: #000; color: #fff;">
                    <tr>
                        <th style="padding: 10px !important; text-align: left;">Jobs</th>
                        <th style="padding: 10px; text-align: center;">Benachrichtigungsstatus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $active_manager = json_decode($job["manager"])->manager;
                    $company_manager = json_decode($company["manager"]);
                    foreach ($company_manager as $key => $manager) {
                        if (in_array($manager, $active_manager)) {
                            echo ('<tr> <td style="padding: 10px; border-right: 1px solid var(--seventh); text-align: left;" class="notification-manager">'.$manager.'</td> <td style="padding: 10px; text-align: center;" data-manager="" class="notification-toggle"><img class="notification-mode" data-mode="on" src="/apps/mfkdashboard/assets/images/yes.png"></td> </tr>');
                        } else {
                            echo ('<tr> <td style="padding: 10px; border-right: 1px solid var(--seventh); text-align: left;" class="notification-manager">'.$manager.'</td> <td style="padding: 10px; text-align: center;" data-manager="" class="notification-toggle"><img class="notification-mode" data-mode="off" src="/apps/mfkdashboard/assets/images/no.png"></td> </tr>');
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>