window.onload = function() { document.querySelector("#searchbar").onkeyup = queryJobs; }
var currentFilters = {

}


function updateJobsList(searchterm){
    fetch(window.location.origin+"/ocs/v2.php/apps/mfkdashboard/api/queryJobs?searchTerm="+searchterm+"&compID="+window.location.pathname.split("/")[6])
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
function queryJobs() {
    let element = document.querySelector("#searchbar");
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    if (element.value.length > 2 || element.value.length == 0) {
        searchTimeout = setTimeout(() => {
            searchTerm = element.value;
            console.log(searchTerm);
            updateJobsList(searchTerm);
    }, 1000);
    }
}

function updateTable(data){
    let tbody = document.querySelector("tbody");
    let mode = window.location.pathname.split("/")[5];
    if(mode == "hr"){
        mode = "edit-job";
    }else{
        mode = "job-activity";
    }
    tbody.innerHTML = "";
    children = "";
    console.log(data);
    data.forEach(job => {
        if(job.status == "active"){
            children += '<tr><td><a href="/index.php/apps/mfkdashboard/'+mode+'/'+job.id+'">'+job.title+'</a></td> <td class="d-flex align-items-center"><div class="status-dot active"></div>aktiv</td> </tr>';
        }else{
            children += '<tr><td><a href="/index.php/apps/mfkdashboard/'+mode+'/'+job.id+'">'+job.title+'</a></td> <td class="d-flex align-items-center"><div class="status-dot"></div>'+job.status+'</td> </tr>';
        }
    });
    tbody.innerHTML = children;
}