window.onload = function () {
    document.querySelector("#requestJobInformation").onclick = requestJobInformation;
    document.querySelector("#requestCV").onclick = requestCV;
    document.querySelector(".submit-btn").onclick = submit;
    document.getElementById("reached").value = "Nein";
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("reached").onchange = updateForm;
    document.querySelector("#select_everyday").onchange = updateTimeslots;
});

function updateForm() {
    if (document.getElementById("reached").value == "Ja") {
        document.querySelector("#reached_section").classList.remove("hidden");
    } else {
        document.querySelector("#reached_section").classList.add("hidden");
    }
}

function updateTimeslots() {
    if (document.getElementById("select_everyday").value == "Täglich") {
        document.querySelector("#remaining_slots").classList.add("hidden");
    } else {
        document.querySelector("#remaining_slots").classList.remove("hidden");
    }
}

function requestJobInformation() {
    fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/sendJobData?id=" + window.location.pathname.split("/")[5] + "&email=" + window.location.pathname.split("/")[6])
        .then(response => {
            if (response.status == 200) {
                alert("Job Informationen erfolgreich versendet ✅");
            } else {
                alert("Es ist ein Fehler beim Versenden aufgetreten! ⚠️");
            }
        })
        .catch(error => alert("Es ist ein Fehler beim Versenden aufgetreten! ⚠️"));
}

function requestCV() {
    fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/requestCV?id=" + window.location.pathname.split("/")[5] + "&email=" + window.location.pathname.split("/")[6])
        .then(response => {
            if (response.status == 200) {
                alert("Lebenslauf erfolgreich angefragt ✅");
            } else {
                alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️");
            }
        })
        .catch(error => alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️"));
}

function submit() {
    let reached = document.getElementById("reached").value;
    let data = {};
    if (reached == "Ja") {
        data["education"] = document.getElementById("education").value;
        data["education_completion"] = document.getElementById("education_completion").value;
        data["change_motivation"] = document.getElementById("change_motivation").value;
        data["professional_status"] = document.getElementById("professional_status").value;
        data["next_possible_change"] = document.getElementById("next_possible_change").value;
        data["salary_change"] = document.getElementById("salary_range").value;
        data["german_level"] = document.getElementById("german_level").value;
        data["notes"] = document.getElementById("notes").value;
        data["successfullCC"] = document.getElementById("successfull_call").value;
        let ts1 = document.getElementById("ts1");
        if (ts1.querySelector("select").value == " Täglich") {
            data["reachability"] = [{
                "day": "Täglich",
                "start": ts1.querySelectorAll("input")[0].value,
                "end": ts1.querySelectorAll("input")[1].value,
            }];
        } else {
            data["reachability"] = [{
                "day": document.getElementById("ts1").querySelector("select").value,
                "start": document.getElementById("ts1").querySelectorAll("input")[0].value,
                "end": document.getElementById("ts1").querySelectorAll("input")[1].value,
            }, {
                "day": document.getElementById("ts2").querySelector("select").value,
                "start": document.getElementById("ts2").querySelectorAll("input")[0].value,
                "end": document.getElementById("ts2").querySelectorAll("input")[1].value,
            }, {
                "day": document.getElementById("ts3").querySelector("select").value,
                "start": document.getElementById("ts3").querySelectorAll("input")[0].value,
                "end": document.getElementById("ts3").querySelectorAll("input")[1].value,
            }];
        }
    }
    data["reached"] = reached;
    data["recruiter"] = document.getElementById("recruiter").value;
    data["email"] = window.location.pathname.split("/")[6];
    data["additional_notices"] = document.getElementById("additional_reach_notes").value;
    console.log(data);
    console.log(JSON.stringify(data));
    fetch('/ocs/v2.php/apps/mfkdashboard/api/logCall', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Fehler:', error));
}