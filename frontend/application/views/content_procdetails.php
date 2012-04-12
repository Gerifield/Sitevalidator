<?php
if(!$datalist):
  echo "Ismeretlen ID vagy tiltott hozzáférés.";
else:

  if(isset($errormsg)){
    echo '<div class="errormsg">'.$errormsg.'</div>';
  }
?>
<form method="post" action="">
<table class="proc_table" style="width: 100%">
<tr><td>ID:</td><td><?php echo $datalist["id"]; ?></td></tr>

<tr><td>URL:</td><td><input type="text" name="inurl" value="<?php echo $datalist["url"]; ?>" /></td></tr>
<tr><td>Futtatás ideje:</td><td><input type="text" name="runtime" value="<?php echo date("Y-m-d H:i", $datalist["runtime"]); ?>" /> <input type="submit" value="Módosítás" /></td></tr>

<tr><td>Állapot:</td><td><?php if($datalist['state'] == 0){echo "Várakozik"; }elseif($datalist['state'] == 1){ echo "Futtatás..."; }elseif($datalist['state'] == 2){ echo "Kész"; } ?></td></tr>

<tr><td>HTML Validitás:</td><td><?php if($datalist["htmlvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td></tr>
<tr><td>HTML Doctype:</td><td><?php if(!empty($datalist["htmldoctype"])){ echo $datalist["htmldoctype"]; }else{ echo "Ismeretlen"; } ?></td></tr>
<tr><td>HTML hibák:</td><td><?php echo $datalist["htmlerrornum"]; ?></td></tr>
<tr><td>HTML figyelmeztetések:</td><td><?php echo $datalist["htmlwarningnum"]; ?></td></tr>

<tr><td>CSS Validitás:</td><td><?php if($datalist["cssvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td></tr>
<tr><td>CSS Doctype:</td><td><?php if(!empty($datalist["cssdoctype"])){ echo $datalist["cssdoctype"]; }else{ echo "Ismeretlen"; } ?></td></tr>
<tr><td>CSS hibák:</td><td><?php echo $datalist["csserrornum"]; ?></td></tr>
<tr><td>CSS figyelmeztetések:</td><td><?php echo $datalist["csswarningnum"]; ?></td></tr>
</table>
</form>
<?php
endif;
?>