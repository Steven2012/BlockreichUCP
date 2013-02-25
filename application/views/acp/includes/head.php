<!-- 
  ZULETZT GEÄNDERT: Steven
  Datum: 31.12.12 - 14:14 Uhr
-->
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $pagetitle." - Administration - ".SITE_NAME ?></title>
        <meta name="description" content="">
        <link rel="stylesheet" href="<?php echo base_url("styles/css/main.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("styles/css/acp-main.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("styles/css/tablesorter-blue.css"); ?>">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url("styles/js/jquery.tablesorter.min.js"); ?>" type="text/javascript"></script>
        <style media="screen" type="text/css">/*<![CDATA[*/@import '<?php echo base_url("styles/fonts/minecraft/stylesheet.css"); ?>';/*]]>*/</style>

<?php if(isset($additional_head_contents)) echo $additional_head_contents; ?>
    </head>

    <body>