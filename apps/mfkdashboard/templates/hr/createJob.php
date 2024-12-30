<?php
$page_title = 'HR';
include_once(__DIR__ . '/../includes/header.php');
?>
<!-- Main Content -->
<div class="container-fluid p-5 main-content-area">
    <h2 class="main-content-heading">Neuer Job für <?php echo ($company["name"]); ?></h2>
    <iframe
        id="JotFormIFrame-232044725930048"
        title="Formular Stellenausschreibung"
        onload="window.parent.scrollTo(0,0)"
        allowtFransparency="true"
        src="https://form.jotform.com/232044725930048?ihrFirmenname=<?php echo ($company["name"]);?>&companyid=<?php echo ($company["billing_id"]);?>"
        frameborder="0"
        style="min-width:100%;max-width:100%;height:700px;border:none;">
    </iframe>
    <script src='https://cdn.jotfor.ms/s/umd/latest/for-form-embed-handler.js'></script>
    <script>
        window.jotformEmbedHandler("iframe[id='JotFormIFrame-232044725930048']", "https://form.jotform.com/")
    </script>
</div>

<?php
include_once(__DIR__ . '/../includes/footer.php');
?>