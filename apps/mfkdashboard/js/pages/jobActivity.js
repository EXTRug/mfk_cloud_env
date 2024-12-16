window.onload = function () {
    // register event handlers
    document.getElementById("logCall").addEventListener("click", logNewCall);
    document.querySelector("#customer_relation").querySelectorAll(".dropdown-item").forEach(element => {
        element.addEventListener("click", () => {
            updateSatisfaction(element);
        })
    });
    document.querySelector("#optimization_menu").querySelectorAll(".dropdown-item").forEach(element => {
        element.addEventListener("click", () => {
            triggerJobAction(element);
        })
    });
    document.querySelector("#jobActionContainer").querySelectorAll(".submit-btn").forEach(element => {
        element.addEventListener("click", () => {
            triggerJobAction(element);
        })
    });
    document.querySelectorAll(".notification-mode").forEach(element => {
        element.addEventListener("click", () => {
            changeNotificationSetting(element);
        })
    });
    document.getElementById("customerVisitField").addEventListener("change", customerVisitChanged);
    quill.on('text-change', jobNotesChanged);
    // update Interface
    loadNotes();
    if(document.querySelector("#jobStatusField").innerText == "active"){
        document.querySelector("#visibilityBtn").innerHTML = "Offline nehmen";
    }else{
        document.querySelector("#visibilityBtn").innerHTML = "Go Live";
    }
}

function updateSatisfaction(element) {
    const id = parseInt(document.getElementById("company_id").value);
    let satisfaction = parseInt(element.dataset.satifaction);

    fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/setSatisfaction", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `compID=${encodeURIComponent(id)}&satisfaction=${encodeURIComponent(satisfaction)}`
    })
        .then(response => {
            if (response.status === 200) {
                document.getElementById("customer_satisfaction_display").innerHTML = element.innerHTML;
            } else {
                alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️");
            }
        })
        .catch(error => alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️"));
}

function logNewCall() {
    data = {
        "upsell": {},
        "testimonial": {},
        "recommendation": {},
        "crossSell": {}
    }
    data["job"] = window.location.pathname.split("/")[5];
    data["upsell"]["pitched"] = document.getElementById("log-upsell").parentElement.querySelectorAll("input")[0].checked;
    data["upsell"]["sold"] = document.getElementById("log-upsell").parentElement.querySelectorAll("input")[1].checked;
    data["testimonial"]["pitched"] = document.getElementById("log-testimonial").parentElement.querySelectorAll("input")[0].checked;
    data["testimonial"]["sold"] = document.getElementById("log-testimonial").parentElement.querySelectorAll("input")[1].checked;
    data["recommendation"]["pitched"] = document.getElementById("log-recommendation").parentElement.querySelectorAll("input")[0].checked;
    data["recommendation"]["sold"] = document.getElementById("log-recommendation").parentElement.querySelectorAll("input")[1].checked;
    data["crossSell"]["pitched"] = document.getElementById("log-crossSell").parentElement.querySelectorAll("input")[0].checked;
    data["crossSell"]["sold"] = document.getElementById("log-crossSell").parentElement.querySelectorAll("input")[1].checked;
    fetch('/ocs/v2.php/apps/mfkdashboard/api/logKBCall', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => {
        console.log(`Statuscode: ${response.status}`);
        if (response.ok) {
            insertNewlyCreatedLog(data);
        } else {
            window.alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️");
        }
    })
}

function changeNotificationSetting(element) {
    let manager = element.parentElement.parentElement.querySelector(".notification-manager").innerHTML;
    let currentMode = element.dataset.mode;
    if (currentMode == "on") {
        newMode = "off";
    } else {
        newMode = "on";
    }
    fetch('/ocs/v2.php/apps/mfkdashboard/api/changeManagerNotification', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "manager": manager,
            "mode": newMode,
            "job": window.location.pathname.split("/")[5]
        })
    })
        .then(data => {
            if (newMode == "on") {
                element.src = "http://127.0.0.1/apps/mfkdashboard/assets/images/yes.png";
                element.dataset.mode = "on";
            } else {
                element.src = "http://127.0.0.1/apps/mfkdashboard/assets/images/no.png";
                element.dataset.mode = "off";
            }
        })
        .catch(error => console.log("error"));
}

let inputTimeout;
function customerVisitChanged() {
    let inputField = document.getElementById("customerVisitField");
    if (inputTimeout) {
        clearTimeout(inputTimeout);
    }
    inputTimeout = setTimeout(() => {
        newDate = new Date(inputField.value).toISOString().slice(0, 19).replace("T", " ");
        fetch('/ocs/v2.php/apps/mfkdashboard/api/updateJobCustomerVisit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "date": newDate,
                "job": window.location.pathname.split("/")[5]
            })
        }).then(data => {
        })
            .catch(error => console.log("Es ist ein Fehler beim speichern aufgetreten.")
            );
    }, 1000);
}

let typeTimeout;
function jobNotesChanged() {
    if (typeTimeout) {
        clearTimeout(typeTimeout);
    }
    typeTimeout = setTimeout(() => {
        fetch('/ocs/v2.php/apps/mfkdashboard/api/updateJobNotes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "note": quill.root.innerHTML,
                "job": window.location.pathname.split("/")[5]
            })
        }).then(data => {
        })
            .catch(error => console.log("Es ist ein Fehler beim speichern aufgetreten.")
            );
    }, 2000);
}

function loadNotes() {
    const delta = quill.clipboard.convert(document.querySelector("#internal_note").value);
    quill.setContents(delta, 'silent');
}

function insertNewlyCreatedLog(data) {
    let parentElement = document.getElementById("kbCallsContainer").children[0];
    const now = new Date();

    // Datum im Format dd.mm.yyyy
    const formattedDate = now.toLocaleDateString("de-DE", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric"
    });
    const html = `
    <hr class="divider" align="center">
    <div class="condition-divider-heading mt-3">(${formattedDate})</div>
    <div class="row">
        <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
            <div class="condition-title">Upsell</div>
            <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["upsell"]["pitched"])}.png">
            </label>&nbsp;&nbsp;&nbsp;
            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["upsell"]["sold"])}.png">
            </label>
        </div>
        <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
            <div class="condition-title">Testimonial</div>
            <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["testimonial"]["pitched"])}.png">
            </label>&nbsp;&nbsp;&nbsp;
            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["testimonial"]["sold"])}.png">
            </label>
        </div>
        <div class="col" style="border-right:1px solid var(--seventh) !important;padding-left:24px">
            <div class="condition-title">Empfehlung</div>
            <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["recommendation"]["pitched"])}.png">
            </label>&nbsp;&nbsp;&nbsp;
            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["recommendation"]["sold"])}.png">
            </label>
        </div>
        <div class="col" style="padding-left:24px">
            <div class="condition-title">Cross Sell</div>
            <lable class="d-flex align-items-center condition-label">gepitcht:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["crossSell"]["pitched"])}.png">
            </label>&nbsp;&nbsp;&nbsp;
            <lable class="d-flex align-items-center condition-label">gekauft:&nbsp;&nbsp;&nbsp;
                <img src="/apps/mfkdashboard/assets/images/${getStatus(data["crossSell"]["sold"])}.png">
            </label>
        </div>
    </div>`;
    parentElement.insertAdjacentHTML("beforeend", html);
    // clean up checkboxes
    checkboxes = document.querySelector("#logCallContainer").querySelectorAll("input");
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}

function getStatus(value) {
    return value ? "yes" : "no";
}

function triggerJobAction(element){
    let action = null;
    let context = "";
    if(element.dataset.context != undefined){
        // handle buttons
        action = element.dataset.context;
        if(element.dataset.context == "visibility"){
            if(document.getElementById("jobStatusField").innerText != "active"){
                context = "setOnline";
            }else{
                context = "setOffline";
            }
        }
    }else{
        // handle dropdown
        action = element.innerHTML
    }
    if(action != null){
        fetch('/ocs/v2.php/apps/mfkdashboard/api/jobActivityActions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "action": action,
                "context": context,
                "job": window.location.pathname.split("/")[5]
            })
        }).then(data => {
            if(context == "setOffline"){
                element.innerHTML = "Go Live";
                document.getElementById("jobStatusField").innerHTML = "archieved";
                document.querySelector(".status-dot").style = "background-color: #8C9499;";
            }else if(context == "setOnline"){
                element.innerHTML = "Offline nehmen";
                document.getElementById("jobStatusField").innerHTML = "active";
                document.querySelector(".status-dot").style = "background-color: #1dbd1d;";
            }else{
                alert("Die Aktion wurde erfolgreich ausgeführt.");
            }
        }
    ).catch(error => console.log("Es ist ein Fehler beim speichern aufgetreten.")
            );
    }
}