window.onload = function() { document.querySelector("#searchbar").onkeyup = queryCompanies; }


function updateCompaniesList(searchterm){
    fetch(window.location.origin+"/ocs/v2.php/apps/mfkdashboard/api/queryCompanies?searchTerm="+searchterm)
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
            updateCompaniesList(searchTerm);
    }, 1000);
    }
}

function updateTable(data){
    let tbody = document.querySelector("tbody");
    let mode = window.location.pathname.split("/")[5];
    tbody.innerHTML = "";
    children = "";
    data.forEach(company => {
        children += '<tr><td><a href="/index.php/apps/mfkdashboard/company-jobs/'+mode+'/'+company.companyID+'"</a>'+company.name+'</td></tr>'
    });
    tbody.innerHTML = children;
}