var mediaPath = "";

function getMediaPath() {
    if (window.location.host == "cloud.ki-recruiter.com") {
        mediaPath = "/extra-apps/mfkdashboard/assets"
    } else {
        mediaPath = "/apps/mfkdashboard/assets"
    }
}

window.onload = function () {
    getMediaPath();
    loadDescriptions();
    loadBenefits();
    loadEbayJob();
    document.querySelector("#ebay1").addEventListener("change", updateEbayFilter);
    document.getElementById("formSubmitBtn").addEventListener("click", submitForm);
}

function loadDescriptions() {
    let descProf = decodeBase64(document.querySelector("#desc_prof").value);
    let descSocial = decodeBase64(document.querySelector("#desc_social").value);
    if (descProf != "null" && descProf != '"\\n"') {
        quill.container.children[0].innerHTML = descProf
    }
    if (descSocial != "null" && descSocial != '"\\n"') {
        quill2.container.children[0].innerHTML = descSocial
    }
}

function updateEbayFilter() {
    let category = document.querySelector("#ebay1").value;
    let ebay2 = document.querySelector("#ebay2");

    switch (category) {
        case "Bau, Handwerk & Produktion":
            ebay2.innerHTML = '<option>Bauhelfer/-in</option> <option>Dachdecker/-in</option> <option>Elektriker/-in</option> <option>Fliesenleger/-in</option> <option>Maler/-in</option> <option>Maurer/-in</option> <option>Produktionshelfer/-in</option> <option>Schlosser/-in</option> <option>Tischler/-in</option>';
            break;
        case "Büroarbeit & Verwaltung":
            ebay2.innerHTML = '<option>Buchhalter/-in</option> <option>Bürokaufmann/-frau</option> <option>Sachbearbeiter/-in</option> <option>Sekretär/-in</option>';
            break;
        case "Gastronomie & Tourismus":
            ebay2.innerHTML = '<option>Barkeeper/-in</option> <option>Hotelfachmann/-frau</option> <option>Kellner/-in</option> <option>Koch/Köchin</option> <option>Küchenhilfe</option> <option>Servicekraft</option> <option>Schlosser/-in</option> <option>Housekeeping</option>';
            break;
        case "Sozialer Sektor & Pflege":
            ebay2.innerHTML = '<option>Altenpfleger/-in</option> <option>Arzthelfer/-in</option> <option>Erzieher/-in</option> <option>Krankenpfleger/-in</option> <option>Physiotherapeut/-in</option>';
            break;
        case "Transport, Logistik & Verkehr":
            ebay2.innerHTML = '<option>Kraftfahrer/-in</option> <option>Kurierfahrer/-in</option> <option>Lagerhelfer/-in</option> <option>Staplerfahrer/-in</option>';
            break;
        case "Vertrieb, Einkauf & Verkauf":
            ebay2.innerHTML = '<option>Buchhalter/-in</option> <option>Immobilienmakler/-in</option> <option>Kaufmann/-frau</option> <option>Verkäufer/-in</option>';
            break;
        case "Weitere Jobs":
            ebay2.innerHTML = '<option>Designer/-in & Grafiker/-in</option> <option>Friseur/-in</option> <option>Haushaltshilfe</option> <option>Hausmeister/-in</option> <option>Reinigungskraft</option>';
            break;
        default:
            break;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Elemente abrufen
    const benefitsContainer = document.getElementById('benefits');
    const addBenefitButton = document.querySelector('.add-benifit-button');
    const benefitInput = document.querySelector('#newBenefit');
    const plzContainer = document.getElementById('plzs');
    const addPLZButton = document.querySelector('.add-plz-button');
    const plzInput = document.querySelector('#plz');

    // Funktion zum Hinzufügen eines neuen Benefits
    addBenefitButton.addEventListener('click', () => {
        const benefitText = benefitInput.value.trim();

        // Überprüfen, ob ein Text eingegeben wurde
        if (benefitText === '') {
            alert('Bitte geben Sie einen Benefit ein.');
            return;
        }

        // Neues Benefit-Element erstellen
        const benefitItem = document.createElement('div');
        benefitInput.style = "margin-top: 5px;"
        benefitItem.classList.add('benifit-item');

        const benefitTitle = document.createElement('div');
        benefitTitle.classList.add('benifit-title');
        benefitTitle.textContent = benefitText;

        const removeButton = document.createElement('button');
        removeButton.classList.add('img-remove-button');

        const removeIcon = document.createElement('img');
        removeIcon.src = mediaPath + '/images/delete-btn.png';
        removeButton.appendChild(removeIcon);

        // Entfernen-Funktion hinzufügen
        removeButton.addEventListener('click', () => {
            benefitsContainer.removeChild(benefitItem);
        });

        // Zusammenfügen der Elemente
        benefitItem.appendChild(benefitTitle);
        benefitItem.appendChild(removeButton);

        // Hinzufügen zum Container
        benefitsContainer.appendChild(benefitItem);

        // Eingabefeld leeren
        benefitInput.value = '';
    });

    // Funktion zum Hinzufügen einer neuen PLZ
    addPLZButton.addEventListener('click', () => {
        const plz = plzInput.value.trim();

        // Überprüfen, ob ein Text eingegeben wurde
        if (plz === '') {
            alert('Bitte geben Sie einen PLZ ein.');
            return;
        }

        // Neues Benefit-Element erstellen
        const plzItem = document.createElement('div');
        plzInput.style = "margin-top: 5px;"
        plzItem.classList.add('benifit-item');

        const benefitTitle = document.createElement('div');
        benefitTitle.classList.add('benifit-title');
        benefitTitle.textContent = plz;

        const removeButton = document.createElement('button');
        removeButton.classList.add('img-remove-button');

        const removeIcon = document.createElement('img');
        removeIcon.src = mediaPath + '/images/delete-btn.png';
        removeButton.appendChild(removeIcon);

        // Entfernen-Funktion hinzufügen
        removeButton.addEventListener('click', () => {
            plzContainer.removeChild(plzItem);
        });

        // Zusammenfügen der Elemente
        plzItem.appendChild(benefitTitle);
        plzItem.appendChild(removeButton);

        // Hinzufügen zum Container
        plzContainer.appendChild(plzItem);

        // Eingabefeld leeren
        plzInput.value = '';
    });
});

function loadEbayJob() {
    let category = document.querySelector("#ebay_data").value.split("#")[1];
    let sub_category = document.querySelector("#ebay_data").value.split("#")[0];

    const cat = document.getElementById("ebay1");
    for (let option of cat.options) {
        if (option.text === category) {
            option.selected = true;
            break;
        }
    }
    updateEbayFilter();
    const scat = document.getElementById("ebay2");
    for (let option of scat.options) {
        if (option.text === sub_category) {
            option.selected = true;
            break;
        }
    }
}

function loadBenefits() {
    let benefits = JSON.parse(document.querySelector("#benefit_list").value);
    content = "";
    if (benefits != null) {
        try {
            benefits.forEach(benefit => {
                content += '<div class="benifit-item" style="margin-top: 5px;"><div class="benifit-title">' + benefit + '</div><button class="img-remove-button"><img src="' + mediaPath + '/images/delete-btn.png" class="benefit-remove-button"></button></div>';
            });
        } catch (error) {
            
        }
        document.getElementById('benefits').innerHTML = content;
    }
    document.getElementById('benefits').addEventListener('click', function (event) {
        if (event.target.classList.contains('benefit-remove-button')) {
            event.target.parentElement.parentElement.remove();
        }
    });
}

function getFormData() {
    let data = {};
    data["job"] = window.location.pathname.split("/")[5];
    data["title"] = document.querySelector("#title").value;
    data["descProf"] = encodeBase64(quill.container.children[0].innerHTML);
    data["descSoc"] = encodeBase64(quill2.container.children[0].innerHTML);
    data["link"] = document.querySelector("#posting_link").value;
    data["plz"] = document.querySelector("#plz").value;
    data["salaryMin"] = document.querySelector("#salaryMin").value;
    data["salaryMax"] = document.querySelector("#salaryMax").value;
    data["ebay1"] = document.querySelector("#ebay1").value;
    data["ebay2"] = document.querySelector("#ebay2").value;
    data["asp"] = document.querySelector("#asp").value;
    let benefits = [];
    Array.from(document.getElementById('benefits').children).forEach(benefit => {
        benefits.push(benefit.querySelector(".benifit-title").innerHTML);
    });
    data["benefits"] = benefits;

    let plzs = [];
    Array.from(document.getElementById('plzs').children).forEach(benefit => {
        plzs.push(benefit.querySelector(".benifit-title").innerHTML);
    });
    data["plz"] = plzs;
    return data;
}

function submitForm() {
    let action = document.getElementById("formSubmitBtn").innerHTML;
    data = getFormData();
    if (!document.getElementById("formSubmitBtn").disabled) {
        data["action"] = action;
        fetch('/ocs/v2.php/apps/mfkdashboard/api/updateJobPosting', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(response => {
            if (response.status === 500) {
                alert("Serverfehler: Statuscode 500 ⚠️");
            } else if (response.ok) {
                if (action === "Freigabe anfordern") {
                    document.getElementById("formSubmitBtn").innerHTML = "Zur Kundenrevision freigeben";
                    document.getElementById("jobStatus").innerHTML = "In revision";
                } else if (action === "Angaben aktualisieren" || action === "Zur Kundenrevision freigeben") {
                    alert("Aktion erfolgreich.");
                }
            } else {
                alert("Ein Fehler ist aufgetreten: " + response.status + " " + response.statusText);
            }
        })
            .catch(error => {
                console.error("Es ist ein Fehler aufgetreten:", error);
                alert("Es ist ein Netzwerkfehler aufgetreten. ⚠️");
            });
    }
}

function encodeBase64(input) {
    return btoa(unescape(encodeURIComponent(input)));
}

function decodeBase64(encoded) {
    try {
        return decodeURIComponent(escape(atob(encoded)));
    } catch (error) {
        return encoded;
    }
}
