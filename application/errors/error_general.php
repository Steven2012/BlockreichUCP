<?php
$pagetitle = "Fehler";
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $pagetitle." - ".SITE_NAME ?></title>
        <meta name="description" content="">
        <meta http-equiv="refresh" content="5; URL=<?php echo site_url(''); ?>">
        <link rel="stylesheet" href="<?php echo base_url("styles/css/main.css"); ?>">
    </head>

    <body>
    
    <div class="container">
        
		<div class="error">
            <h2>Es ist ein Fehler aufgetreten</h2><br>
    		<b><?php echo $message; ?></b><br>
    		<a href="<?php echo site_url(''); ?>">Du wirst in K&uuml;rze weitergeleitet. Wenn nicht, dann klicke bitte hier.</a>
		</div>
	
	</div>
    	
	</body>
</html>