<?php
if(isset($errormsg)){
	echo '<div class="errormsg">'.$errormsg.'</div>';
}
if(isset($successmsg)){
  echo '<div class="successmsg">'.$successmsg.'</div>';
}
?>
<form method="post" action="">
<p>URL*: <input type="text" name="inurl" value="<?php echo $inurl; ?>" size="70" /> Időpont: <input type="text" name="runtime" value="<?php echo $runtime; ?>" /><input type="submit" value="Hozzáad" />
<br /></p><div style="font-size:85%">*:Teljes url cím, http-vel és .htm, .html, .php vagy .asp végződéssel!</div>
</form>
<br />
<table class="proc_table">
<tr>
<th>ID</th>
<th>URL</th>
<th>Futtatás</th>
<th>Állapot</th>
<th>HTML Validitás</th>
<th>CSS Validitás</th>
<th>Teszt lefutott</th>
</tr>
<?php
  foreach($datalist as $row):
?>
<tr class="clickable">
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['url']; ?></td>
<td><?php echo date("Y-m-d H:i", $row['runtime']); ?></td>
<td><?php if($row['state'] == 0){echo "Várakozik"; }elseif($row['state'] == 1){ echo "Futtatás..."; }elseif($row['state'] == 2){ echo "Kész"; } ?></td>
<td><?php if($row["htmlvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td>
<td><?php if($row["cssvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td>
<td><?php if($row['starttime'] == 0){ echo "-"; }else{ echo date("Y-m-d H:i", $row['starttime']);} ?></td>
</tr>
<?php
  endforeach;
?>
</table>