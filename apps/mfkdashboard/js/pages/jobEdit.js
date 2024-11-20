window.onload = function(){
    LoadDescriptions();
    LoadBenefits();
    document.querySelector("#ebay1").addEventListener("change", updateEbayFilter);
}

function LoadDescriptions(){
    quill.setText(document.querySelector("#desc_prof").value);
    quill2.setText(document.querySelector("#desc_social").value);
}

function updateEbayFilter(){
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
        benefitItem.classList.add('benifit-item');

        const benefitTitle = document.createElement('div');
        benefitTitle.classList.add('benifit-title');
        benefitTitle.textContent = benefitText;

        const removeButton = document.createElement('button');
        removeButton.classList.add('img-remove-button');

        const removeIcon = document.createElement('img');
        removeIcon.src = '/apps/mfkdashboard/assets/images/delete-btn.png';
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
});

function LoadBenefits(){
    let benefits = JSON.parse(document.querySelector("#benefit_list").value);
    content = "";
    benefits.forEach(benefit => {
        content += '<div class="benifit-item"><div class="benifit-title">'+benefit+'</div><button class="img-remove-button"><img src="/apps/mfkdashboard/assets/images/delete-btn.png"></button></div>';
    });
    document.getElementById('benefits').innerHTML = content;
}

function loadFormData(){
    let title = document.querySelector("#title").value;
    let desc_prof = quill.getText();
    let desc_social = quill2.getText();
    let link = document.querySelector("#posting_link").value;
    let plz = "";
    let salaryMin = document.querySelector("#salaryMin").value;
    let salaryMax = document.querySelector("#salaryMax").value;
    let ebay1 = document.querySelector("#ebay1").value;
    let ebay2 = document.querySelector("#ebay2").value;
    let benefits = [];
    let asp = document.querySelector("#asp").value;

    Array.from(document.getElementById('benefits').children).forEach(benefit => {
        benefits.push(benefit.querySelector(".benifit-title").innerHTML);
    });
}
