<?php
if(!$datalist):
  echo "Ismeretlen ID vagy tiltott hozzáférés.";
else:

  if(isset($errormsg)){
    echo '<div class="errormsg">'.$errormsg.'</div>';
  }
  if(isset($successmsg)){
    echo '<div class="successmsg">'.$successmsg.'</div>';
  }
?>
<form method="post" action="">
<input type="text" name="inurl" value="<?php echo $datalist["url"]; ?>" size="70" />
<input type="text" name="runtime" value="<?php echo date("Y-m-d H:i", $datalist["runtime"]); ?>" /> <input type="submit" value="Módosítás" />
</form>
<?php

foreach($pages as $row):
?>
<table class="proc_table" style="width: 100%">

<tr><td>URL:</td><td><?php echo $row["url"]; ?></td></tr>
<tr><td>Futtatás ideje:</td><td><?php if($row["starttime"] == 0){ echo "-"; }else{ echo date("Y-m-d H:i", $row["starttime"]); }?></td></tr>

<tr><td>HTML Validitás:</td><td><?php if($row["htmlvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td></tr>
<tr><td>HTML Doctype:</td><td><?php if(!empty($row["htmldoctype"])){ echo $row["htmldoctype"]; }else{ echo "Ismeretlen"; } ?></td></tr>
<tr><td>HTML hibák:</td><td><?php echo $row["htmlerrornum"]; ?></td></tr>
<tr><td>HTML figyelmeztetések:</td><td><?php echo $row["htmlwarningnum"]; ?></td></tr>

<tr><td>CSS Validitás:</td><td><?php if($row["cssvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td></tr>
<tr><td>CSS Doctype:</td><td><?php if(!empty($row["cssdoctype"])){ echo $row["cssdoctype"]; }else{ echo "Ismeretlen"; } ?></td></tr>
<tr><td>CSS hibák:</td><td><?php echo $row["csserrornum"]; ?></td></tr>
<tr><td>CSS figyelmeztetések:</td><td><?php echo $row["csswarningnum"]; ?></td></tr>
</table>

<?php
endforeach;
?>
<div style="text-align: center; padding-top: 10px;"><a href="<?php echo site_url("main/delproc/".$datalist["id"]); ?>" style="text-decoration: none; font-size: 130%; font-weight: bold; color: red;" onclick="return confirm('Biztosan törölni szeretnéd ezt a bejegyzést?');">Törlés</a></div>
<?php
endif;
?>