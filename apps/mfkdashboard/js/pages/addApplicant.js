var selectedFunnel = "";
var mediaPath = "";

function getMediaPath(){
    if(window.location.host == "cloud.ki-recruiter.com"){
        mediaPath = "/extra-apps/mfkdashboard/assets"
    }else{
        mediaPath = "/apps/mfkdashboard/assets"
    }
}

window.onload = function () {
    getMediaPath();
    setupFunnelSelection();
    document.querySelector(".submit-btn").addEventListener("click", submit);
    // document.querySelector("#job-dropdown-search").onkeyup = queryJobs;
    document.querySelectorAll("a").forEach(anchor => {
        anchor.addEventListener("click", () => {
            document.querySelector("#myDropdown").classList.remove("show");
        });
    });
}

function submit() {
    let firstname = document.getElementById("firstname").value;
    let lastname = document.getElementById("lastname").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;

    const fileInput = document.querySelector("#fileInput");

    // create Applicant
    if (firstname != "" && lastname != "" && selectFunnel != "" && email != "" && phone != "") {
        fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/createApplicant?firstname=" + firstname +
            "&lastname=" + lastname + "&email=" + email + "&phone=" + phone + "&funnel=" + selectedFunnel)
            .then(response => response.text())
            .then(data => { console.log(data); })
            .catch(error => window.alert("Es ist ein Fehler beim Anlegen des Bewerberprofils aufgetreten."));
    } else {
        if (!fileInput && fileInput.files.length != 1) {
            window.alert("Bitte geben Sie alle notwendigen Informationen ein.");
        }
    }
 
    if (fileInput && fileInput.files.length == 1 && email != "") {
        const file = fileInput.files[0]; // Die hochgeladene Datei
        const formData = new FormData();
        formData.append("cv", file);
        formData.append("email", email);

        // Datei mit Fetch an den Server senden
        fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/uploadCV", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log("Erfolgreich hochgeladen:", data);
            })
            .catch(error => {
                window.alert("Es ist ein Fehler beim Hohcladen des Lebenslaufs aufgetreten.");
            });
    } else {
        console.log("Keine Datei ausgewählt.");
    }
    window.alert("erfolg.");
}

function setupFunnelSelection() {
    let selection = document.getElementById("myDropdown");
    anchorTags = selection.querySelectorAll("a");
    anchorTags.forEach(tag => {
        tag.addEventListener("click", selectFunnel.bind(tag));
    });
}

function selectFunnel() {
    console.log(this);
    selectedFunnel = this.innerText;
}

document.addEventListener("DOMContentLoaded", () => {
    const dragDropArea = document.querySelector(".drag-drop-button");
    const fileInput = document.getElementById("fileInput");
    const selectedImages = document.querySelector(".selected-images");

    // Drag-and-Drop Events
    dragDropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dragDropArea.classList.add("drag-over");
    });

    dragDropArea.addEventListener("dragleave", () => {
        dragDropArea.classList.remove("drag-over");
    });

    dragDropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dragDropArea.classList.remove("drag-over");
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    dragDropArea.addEventListener("click", () => {
        fileInput.click();
    });

    fileInput.addEventListener("change", () => {
        const files = Array.from(fileInput.files);
        handleFiles(files);
    });

    // Dateien verarbeiten und anzeigen
    function handleFiles(files) {
        files.forEach((file) => {
            const fileItem = document.createElement("div");
            fileItem.classList.add("selected-image");

            fileItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <img src="`+mediaPath+`/images/pencil.png" alt="File">
                    <div class="image-title">${file.name} 
                        <span class="image-size">(${(file.size / 1024).toFixed(1)} KB)</span>
                    </div>
                <button class="img-remove-button"><img src="`+mediaPath+`/images/delete-btn.png"></button></div>
            `;

            fileItem.querySelector(".img-remove-button").addEventListener("click", () => {
                fileItem.remove();
            });

            selectedImages.appendChild(fileItem);
        });
    }
});


let searchTimeout;
function queryJobs() {
    let element = document.querySelector("#job-dropdown-search");
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    if (element.value.length > 2 || element.value.length == 0) {
        searchTimeout = setTimeout(() => {
            searchTerm = element.value;
            updateJobs(searchTerm);
        }, 1000);
    }
}

function updateJobs(searchterm) {
    fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/queryJobs?searchTerm=" + searchterm)
        .then(response => response.text())
        .then(data => {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(data, 'application/xml');

            const ocs = xmlDoc.getElementsByTagName('ocs')[0];
            const dataElement = ocs.getElementsByTagName('data')[0];

            if (dataElement) {
                updateDropdown(JSON.parse(dataElement.textContent));
            } else {
                console.log('No data element found inside ocs.');
            }
        })
        .catch(error => console.error('Error fetching XML:', error));
}

function updateDropdown(data) {
    console.log(data);
}