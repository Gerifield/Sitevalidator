<form method="post" action="">
<p>URL: <input type="text" name="inurl" /> <input type="submit" value="Hozzáad" /></p>
</form>
<br />
<table class="proc_table">
<tr>
<th>ID</th>
<th>URL</th>
<th>Futtatás</th>
<th>Állapot</th>
<th>HTML Validitás</th>
<th>HTML Doctype</th>
<th>HTML Hiba</th>
<th>HTML Figyelmeztetés</th>
<th>CSS Validitás</th>
<th>CSS Doctype</th>
<th>CSS Hiba</th>
<th>CSS Figyelmeztetés</th>
</tr>
<?php
  foreach($datalist as $row):
?>
<tr class="clickable">
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['url']; ?></td>
<td><?php echo $row['runtime']; ?></td>
<td><?php if($row['state'] == 0){echo "Várakozik"; }elseif($row['state'] == 1){ echo "Futtatás..."; }elseif($row['state'] == 2){ echo "Kész"; } ?></td>
<td><?php if($row["htmlvalidity"]){ echo "Invalid"; }else{ echo "Valid"; }; ?></td>
<td><?php if(empty($row["htmldoctype"])){ echo "Ismeretlen"; }else{ echo $row["htmldoctype"]; }; ?></td>
<td><?php echo $row["htmlerrornum"]; ?></td>
<td><?php echo $row["htmlwarningnum"]; ?></td>
<td><?php if($row["cssvalidity"]){ echo "Invalid"; }else{ echo "Valid"; }; ?></td>
<td><?php if(empty($row["cssdoctype"])){ echo "Ismeretlen"; }else{ echo $row["htmldoctype"]; }; ?></td>
<td><?php echo $row["csserrornum"]; ?></td>
<td><?php echo $row["csswarningnum"]; ?></td>
<td><a href="#">Töröl</a> <a href="#">Módosít</a></td>
</tr>
<?php
  endforeach;
?>
</table>