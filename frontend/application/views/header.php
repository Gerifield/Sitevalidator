<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Sitevalidator</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("style.css"); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("jquery-ui-1.8.18.custom.css"); ?>" />
        <script type = "text/javascript" src="<?php echo base_url("jquery.min.js"); ?>" ></script>
        <script type = "text/javascript" src="<?php echo base_url("jquery-ui-1.8.18.custom.min.js"); ?>" ></script>
        <script type = "text/javascript" src="<?php echo base_url("jquery-ui-timepicker-addon.js"); ?>" ></script>
        <script type="text/javascript">
          $(document).ready(function() {

              $('.proc_table tr.clickable').click(function(){
                  var id = $(this).children("td:first").text(); //select the first td item
                  //TODO: Valami szexi cucc...
                  //alert(id);
                  document.location.href = "<?php echo site_url("main/details"); ?>/"+id;
              });
            
              //$('input[name="runtime"]').watermark("ÉÉÉÉ.HH.NN ÓÓ:PP");
              $('input[name="runtime"]').datetimepicker({
                  minDate: 0,
                  maxDate: 300, //max 300 nappal elore lehet beallitani
                  dateFormat: "yy-mm-dd"
                  });
          });
        </script>
    </head>
    <body>
      <div style="text-align:center; padding-bottom: 35px; padding-top: 20px;"><img src="<?php echo base_url("images/page_logo.png"); ?>" alt="Page logo" /></div>
        <div class="main_page">
