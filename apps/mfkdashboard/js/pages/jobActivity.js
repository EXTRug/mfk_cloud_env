window.onload = function(){

}

function updateSatisfaction() {
    const id = 152;
    const satisfaction = 2;

    fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/setSatisfaction", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `compID=${encodeURIComponent(id)}&satisfaction=${encodeURIComponent(satisfaction)}`
    })
    .then(response => {
        if(response.status === 200) {
        } else {
            alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️");
        }
    })
    .catch(error => alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️"));
}