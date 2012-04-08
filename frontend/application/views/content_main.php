<form method="post" action="">
<p>URL*: <input type="text" name="inurl" size="70" /> Időpont: <input type="text" name="runtime" /><input type="submit" value="Hozzáad" />
<br /><div style="font-size:85%">*:Teljes url cím, http-vel és .html, .html, .php vagy .asp végződéssel!</div></p>
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
</tr>
<?php
  foreach($datalist as $row):
?>
<tr class="clickable">
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['url']; ?></td>
<td><?php echo $row['runtime']; ?></td>
<td><?php if($row['state'] == 0){echo "Várakozik"; }elseif($row['state'] == 1){ echo "Futtatás..."; }elseif($row['state'] == 2){ echo "Kész"; } ?></td>
<td><?php if($row["htmlvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td>
<td><?php if($row["cssvalidity"] == 0){ echo "Invalid"; }else{ echo "Valid"; }; ?></td>
</tr>
<?php
  endforeach;
?>
</table>