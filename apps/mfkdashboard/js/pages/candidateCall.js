window.onload = function() {
    document.querySelector("#requestJobInformation").onclick = requestJobInformation;
    document.querySelector("#requestCV").onclick = requestCV;
}

function requestJobInformation() {
    fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/sendJobData?id=" + window.location.pathname.split("/")[5] + "&email=" + window.location.pathname.split("/")[6])
    .then(response => {
        if(response.status == 200) {
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
        if(response.status == 200) {
            alert("Lebenslauf erfolgreich angefragt ✅");
        } else {
            alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️");
        }
    })
    .catch(error => alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️"));
}
