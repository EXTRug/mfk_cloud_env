    </div>
</div>
<?php 
    foreach ($configurations['js'] as $key => $value) {
        echo '<script type="text/javascript" src="' . $value . '"></script>';
    }
?>
</body>
</html>