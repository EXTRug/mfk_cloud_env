<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
$campaign = json_decode($job["campaign"]);
?>
<!-- Main Content -->
<?php
if ($applicant["applicant"] != null && $applicant["progress"] != null && $job != null) {
?>
    <div class="container-fluid p-5 main-content-area">
        <div class="d-flex align-items-center header-with-between mb-3">
            <h2 class="main-content-heading mb-0 pb-0"><?php echo ($job["funnel_name"]); ?></h2>
            <div class="d-flex align-items-center header-buttons">
                <button id="requestCV" class="service-btn me-2">Lebenslauf anfordern</button>
                <button id="requestJobInformation" class="service-btn">Job Informationen senden</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="card-box">
                    <div class="title heading mb-1 d-flex align-items-center">Allgemeine Job Informationen</div>
                    <hr class="divider" align="center">
                    <div class="title service-title mb-1"><?php echo ($job["title"]); ?></div>
                    <div class="mini-taglines d-flex align-items-center">
                        Jobtitel
                    </div>
                    <div class="title service-title mb-1"><?php $loc = json_decode($job["location"])[0];
                                                            echo ($loc->plz . ", " . $loc->city); ?></div>
                    <div class="mini-taglines d-flex align-items-center">
                        PLZ
                    </div>
                    <div class="title service-title mb-1"><?php echo ($campaign->working_hours); ?></div>
                    <div class="mini-taglines d-flex align-items-center">
                        Beschäftigungsform
                    </div>
                    <div class="title service-title mb-1"><?php echo ($campaign->work_experience); ?></div>
                    <div class="mini-taglines d-flex align-items-center mb-1">
                        Erfahrung
                    </div>
                    <ul class="service-list">
                        <?php
                        foreach ($campaign->benefits as $key => $benefit) {
                            echo ("<li>" . $benefit . "</li>");
                        }
                        ?>
                    </ul>
                    <div class="mini-taglines d-flex align-items-center mb-1">
                        Benefits
                    </div>
                    <ul class="service-list">
                        <?php
                        foreach ($campaign->tasks as $key => $task) {
                            echo ("<li>" . $task . "</li>");
                        }
                        ?>
                    </ul>
                    <div class="mini-taglines d-flex align-items-center">
                        Aufgabenbereich
                    </div>
                </div>
                <div class="card-box mt-3">
                    <div class="title heading mb-1 d-flex align-items-center">Bewerber Informationen</div>
                    <hr class="divider" align="center">
                    <div class="title service-title mb-1"><?php echo ($applicant["applicant"]["firstname"] . " " . $applicant["applicant"]["lastname"]); ?></div>
                    <div class="mini-taglines d-flex align-items-center">
                        Name
                    </div>
                    <div class="title service-title mb-1"><?php
                                                            if (strpos($applicant["applicant"]["cv"], "mfkgen") !== false) {
                                                                echo ("⚠️ nur generierter Lebenslauf vorhanden.");
                                                            } else {
                                                                echo ("persönlicher Lebenslauf vorhanden.");
                                                            }
                                                            ?></div>
                    <div class="mini-taglines d-flex align-items-center">
                        Lebenslauf
                    </div>
                    <div class="title service-title mb-1"><?php echo ($applicant["progress"]["joined"]); ?></div>
                    <div class="mini-taglines d-flex align-items-center">
                        Bewerbungsdatum
                    </div>
                    <?php
                    $qs = json_decode($applicant["progress"]["interviewQS"]);
                    foreach ($qs as $key => $question) {
                        echo ('<div class="title service-title mb-1">' . $question->answer . '</div> <div class="mini-taglines d-flex align-items-center"> ' . $question->question . ' </div>');
                    }
                    ?>
                </div>
                <div class="card-box mt-3">
                    <div class="title heading mb-1 d-flex align-items-center">Firmen Informationen</div>
                    <hr class="divider" align="center">
                    <div class="title service-title mb-1"><?php echo ($company["name"]); ?></div>
                    <div class="mini-taglines d-flex align-items-center mb-1">
                        Unternehmensnamen
                    </div>
                    <div class="title mb-1 d-flex align-items-center" style="margin-top:15px">Website <a href="https://www.<?php echo ($company["website"]); ?>" target="_blank"><img height="19px" class="ms-2" src="<?= $configurations['assets_path'] ?>/images/iconamoon_link-external-light.png"></a></div>
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
                        <select class="form-control rounded-0 border-secondary outline-0 text-input" id="reached">
                            <option selected>Nein</option>
                            <option>Ja</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Weitere Erreichbarkeitsanmerkungen</label>
                        <select class="form-control rounded-0 border-secondary outline-0 text-input" id="additional_reach_notes">
                            <option>keine</option>
                            <option>falsche Nummer</option>
                            <option>wünscht Rückruf</option>
                            <option>Mailbox</option>
                            <option>Anruf abgelehnt</option>
                        </select>
                    </div>
                    <input type="hidden" id="recruiter" value="<?php echo ($recruiter); ?>">
                    <div id="reached_section" class="hidden">
                        <div class="d-flex align-items-center heading-divider">
                            <hr>
                            <div class="divider-heading">Gesprächsinhalt:&nbsp;&nbsp;</div>
                            <hr class="divider" width="80%" align="center">
                        </div>

                        <div class="form-group mb-3">
                            <label>abgeschlossene Ausbildung</label>
                            <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" id="education">
                        </div>
                        <div class="form-group mb-3">
                            <label>In welchem Jahr wurde die Ausbildung abgeschlossen?</label>
                            <input class="form-control rounded-0 border-secondary outline-0 text-input" type="number" id="education_completion">
                        </div>
                        <div class="form-group mb-3">
                            <label>Wechselmotivation</label>
                            <textarea class="form-control rounded-0 border-secondary outline-0 text-input" rows="7" id="change_motivation"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Aktueller Berufsstatus</label>
                            <select class="form-control rounded-0 border-secondary outline-0 text-input" id="professional_status">
                                <option>arbeitssuchend</option>
                                <option>beschäftigt</option>
                                <option>vorübergehend arbeitsunfähig (krank)</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Nächstmögliches Wechseldatum</label>
                            <input class="form-control rounded-0 border-secondary outline-0 text-input" type="date" id="next_possible_change">
                        </div>
                        <div class="form-group mb-3">
                            <label>Gehaltsrange</label>
                            <input class="form-control rounded-0 border-secondary outline-0 text-input" type="text" id="salary_range">
                        </div>
                        <div class="form-group">
                            <label>Timeslots</label>
                            <div class="timeslot" id="ts1">
                                <div class="time-slot-heading">Timeslot 1</div>
                                <div class="row">
                                    <select class="col form-control rounded-0 border-secondary outline-0 text-input mt-1" id="select_everyday">
                                        <option>Montag</option>
                                        <option>Dienstag</option>
                                        <option>Mittwoch</option>
                                        <option>Donnerstag</option>
                                        <option>Freitag</option>
                                        <option>Täglich</option>
                                    </select>
                                    <div class="col-5 relative-position-input">
                                        <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="time">
                                        <div class="absolute-icon-text slot-label">Start</div>
                                    </div>
                                    <div class="col-5 relative-position-input">
                                        <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="time">
                                        <div class="absolute-icon-text slot-label">End</div>
                                    </div>
                                </div>
                            </div>
                            <div id="remaining_slots">
                                <div class="timeslot" id="ts2">
                                    <div class="time-slot-heading">Timeslot 2</div>
                                    <div class="row">
                                        <select class="col form-control rounded-0 border-secondary outline-0 text-input mt-1">
                                            <option>Montag</option>
                                            <option>Dienstag</option>
                                            <option>Mittwoch</option>
                                            <option>Donnerstag</option>
                                            <option>Freitag</option>
                                        </select>
                                        <div class="col-5 relative-position-input">
                                            <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="time">
                                            <div class="absolute-icon-text slot-label">Start</div>
                                        </div>
                                        <div class="col-5 relative-position-input">
                                            <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="time">
                                            <div class="absolute-icon-text slot-label">End</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeslot" id="ts3">
                                    <div class="time-slot-heading">Timeslot 3</div>
                                    <div class="row">
                                        <select class="col form-control rounded-0 border-secondary outline-0 text-input mt-1">
                                            <option>Montag</option>
                                            <option>Dienstag</option>
                                            <option>Mittwoch</option>
                                            <option>Donnerstag</option>
                                            <option>Freitag</option>
                                        </select>
                                        <div class="col-5 relative-position-input">
                                            <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="time">
                                            <div class="absolute-icon-text slot-label">Start</div>
                                        </div>
                                        <div class="col-5 relative-position-input">
                                            <input class="form-control rounded-0 border-secondary outline-0 text-input ps-5 slot-input" type="time">
                                            <div class="absolute-icon-text slot-label">End</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Notizen</label>
                            <textarea class="form-control rounded-0 border-secondary outline-0 text-input" rows="7" id="notes"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Sprachniveau - Deutsch</label>
                            <select class="form-control rounded-0 border-secondary outline-0 text-input" id="german_level">
                                <option>sehr gut</option>
                                <option>gut</option>
                                <option>mittelmäßig</option>
                                <option>schlecht</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Wurde ein erfolgreiches Kandidatengespräch geführt?</label>
                            <select class="form-control rounded-0 border-secondary outline-0 text-input" id="successfull_call">
                                <option>Ja</option>
                                <option>Nein</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="submit-btn">Speichern</button>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    echo ("<h3 style='color: white;'>Hier ging etwas schief! Überprüfe deine Anfrage!</h3>");
}
include_once(__DIR__ . '/../includes/footer.php');
?>