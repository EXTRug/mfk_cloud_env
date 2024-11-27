window.onload = function(){
    document.getElementById("logCall").addEventListener("click",logNewCall);
    document.querySelector("#customer_relation").querySelectorAll(".dropdown-item").forEach(element => {
        element.addEventListener("click",() => {
            updateSatisfaction(element);
        })
    });
    document.querySelectorAll(".notification-mode").forEach(element => {
        element.addEventListener("click",() => {
            changeNotificationSetting(element);
        })
    });
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
        if(response.status === 200) {
            document.getElementById("customer_satisfaction_display").innerHTML = element.innerHTML;
        } else {
            alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️");
        }
    })
    .catch(error => alert("Es ist ein Fehler beim Anfragen aufgetreten! ⚠️"));
}

function logNewCall(){
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
    })
    .then(response => response.json())
    .then(data => window.alert("Erfolgreich gespeichert."))
    .catch(error => console.log("error"));
}

function changeNotificationSetting(element){
    let manager = element.parentElement.parentElement.querySelector(".notification-manager").innerHTML;
    let currentMode = element.dataset.mode;
    if(currentMode == "on"){
        newMode = "off";
    }else{
        newMode = "on";
    }
    console.log(manager+": "+currentMode);
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