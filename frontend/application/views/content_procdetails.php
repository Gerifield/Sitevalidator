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
<table>
<tr><td>URL:</td><td><input type="text" name="inurl" value="<?php echo $datalist["url"]; ?>" size="70" /></td>
<td>Időpont: <input type="text" name="runtime" value="<?php echo date("Y-m-d H:i", $datalist["runtime"]); ?>" />
Értesítés: <input type="checkbox" name="sendemail" <?php if($datalist["sendmail"]){ echo 'checked="checked"'; } ?> /></td></tr>
<tr><td>Ismétlés:</td><td><input type="text" name="repeat" value="<?php echo $datalist['repeat']/86400; ?>" size="3" /> naponta.</td>
<td><input type="hidden" name="sendform" value="true" />
<input type="submit" value="Módosítás" /></td></tr></table>
</form>
<div style="text-align: center; padding: 10px 10px;"><a href="<?php echo site_url("main/delproc/".$datalist["id"]); ?>" style="text-decoration: none; font-size: 130%; font-weight: bold; color: red;" onclick="return confirm('Biztosan törölni szeretnéd ezt a bejegyzést?');">Törlés</a></div>
<?php

foreach($pages as $row):
?>
<table class="details_table" style="width: 100%">

<tr><td>URL:</td>
<td><?php if($row["code"] == 200) {
  if($row['htmlvalidity']){
    echo '<a href="'.$row["url"].'" class="ok_link">'.$row["url"].'</a>';
  }else{
    echo '<a href="http://validator.w3.org/check?uri='.$row["url"].'" style="color: red";>'.$row["url"].'</a>';
}
}else{ 
echo '<div style="color: red">'.$row["url"].' ('.$row["code"].')</div>'; } ?></td>
<td>Futtatás ideje:</td><td><?php if(!$row["runtime"]){ echo "-"; }else{ echo date("Y-m-d H:i", $row["runtime"]); }?></td></tr>

<tr><td>HTML Validitás:</td><td><?php if(!$row["htmlvalidity"]){ echo '<img src="'.base_url("images/error.png").'" alt="Error" />'; }else{ echo '<img src="'.base_url("images/ok.png").'" alt="Valid" />'; }; ?></td>
<td>HTML Doctype:</td><td><?php
if(!empty($row["htmldoctype"])){
  if($row["htmlvalidity"] == 0){
    echo "<div style='color: red;'>".$row["htmldoctype"]."</div>";
  }else{
    echo "<div style='color: green;'>".$row["htmldoctype"]."</div>";
  }
}else{
  echo "Ismeretlen";
}
?></td></tr>

<tr><td>HTML hibák:</td><td><?php echo $row["htmlerrornum"]; ?></td>
<td>HTML figyelmeztetések:</td><td><?php echo $row["htmlwarningnum"]; ?></td></tr>

<tr><td>CSS Validitás:</td><td><?php if($row["cssvalidity"] == 0){ echo '<img src="'.base_url("images/error.png").'" alt="Error" />'; }else{ echo '<img src="'.base_url("images/ok.png").'" alt="Valid" />'; }; ?></td>
<td>CSS Doctype:</td><td><?php
if(!empty($row["cssdoctype"])){
  if($row["cssvalidity"] == 0){
    echo "<div style='color: red;'>".$row["cssdoctype"]."</div>";
  }else{
    echo "<div style='color: green;'>".$row["cssdoctype"]."</div>";
  }
}else{
  echo "Ismeretlen";
}
?></td></tr>

<tr><td>CSS hibák:</td><td><?php echo $row["csserrornum"]; ?></td>
<td>CSS figyelmeztetések:</td><td><?php echo $row["csswarningnum"]; ?></td></tr>

<tr><td>HTML méret:</td><td><?php echo round($row["htmlsize"]/1000 ,2); ?> KB</td>
<td>CSS méret:</td><td><?php echo round($row["fullcsssize"]/1000 ,2); ?> KB</td></tr>

<tr><td>Javascript méret:</td><td><?php echo round($row["fulljssize"]/1000 ,2); ?> KB</td>
<td>Képek száma:</td><td><?php echo $row["imgnum"]; ?> db</td></tr>
</table>
<br />
<?php
endforeach;
?>
<div style="text-align: center; padding-top: 10px;"><?php echo $this->pagination->create_links(); ?></div>
<?php
endif;
?>
