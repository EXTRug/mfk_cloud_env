filterSettings = {
    "onlyActiveCompanies": true
}

var lastsearchTerm = "";

window.onload = function () { 
    document.querySelector("#searchbar").onkeyup = queryCompanies; 
    document.querySelector("#filterActiveCompanies").addEventListener("click", updateFilterActiveCompanies);
}


function updateCompaniesList(searchterm) {
    fetch(window.location.origin + "/ocs/v2.php/apps/mfkdashboard/api/queryCompanies?searchTerm=" + searchterm+"&filterActive="+filterSettings["onlyActiveCompanies"])
        .then(response => response.text())
        .then(data => {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(data, 'application/xml');

            const ocs = xmlDoc.getElementsByTagName('ocs')[0];
            const dataElement = ocs.getElementsByTagName('data')[0];

            if (dataElement) {
                updateTable(JSON.parse(dataElement.textContent));
            } else {
                console.log('No data element found inside ocs.');
            }
        })
        .catch(error => console.error('Error fetching XML:', error));
}

let searchTimeout;
function queryCompanies() {
    let element = document.querySelector("#searchbar");
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    if (element.value.length > 2 || element.value.length == 0) {
        searchTimeout = setTimeout(() => {
            searchTerm = element.value;
            lastsearchTerm = searchTerm;
            updateCompaniesList(searchTerm);
        }, 1000);
    }
}

function updateTable(data) {
    console.log(data);
    let tbody = document.querySelector("tbody");
    let mode = window.location.pathname.split("/")[5];
    tbody.innerHTML = "";
    children = "";
    data.forEach(company => {
        satisfaction = "";
        style = "";
        if (company["satisfaction"] == 2) {
            satisfaction = "Sehr zufrieden";
            style = "color: green;";
        } else if (company["satisfaction"] == 1) {
            satisfaction = "zufrieden";
        } else if (company["satisfaction"] == 0 || company["satisfaction"] == null) {
            satisfaction = "neutral";
        } else if (company["satisfaction"] == -1) {
            satisfaction = "Handlungsbedarf";
            style = "color: red;font-weight: bold !important;";
        }
        children += '<tr><td><a href="/index.php/apps/mfkdashboard/company-jobs/' + mode + '/' + company.companyID + '"</a>' + company.name + '</td><td style="' + style + '">' + satisfaction + '</td></tr>'
    });
    tbody.innerHTML = children;
}

function updateFilterActiveCompanies(){
    console.log("I am here");
    if(filterSettings["onlyActiveCompanies"]){
        document.getElementById("filterActiveCompanies").querySelector("svg").classList.add("hidden");
        filterSettings["onlyActiveCompanies"] = false;
    }else{
        document.getElementById("filterActiveCompanies").querySelector("svg").classList.remove("hidden");
        filterSettings["onlyActiveCompanies"] = true;
    }
    updateCompaniesList(lastsearchTerm);
}