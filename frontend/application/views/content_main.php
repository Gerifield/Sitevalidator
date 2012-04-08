<form method="post" action="">
<p>URL: <input type="text" name="inurl" /> <input type="submit" value="Hozzáad" /></p>
</form>
<br />
<table class="proc_table">
<tr><th>ID</th><th>URL</th><th>Futtatás</th><th>Állapot</th></tr>
<?php
  foreach($datalist as $row):
?>
<tr class="clickable">
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['url']; ?></td>
<td class="runtime"><?php echo $row['runtime']; ?></td>
<td><?php echo $row['state']; ?></td>
</tr>
<?php
  endforeach;
?>
</table>

<?php
  foreach($datalist as $row):
?>
<div id="id<?php echo $row['id']; ?>" style="display:none">
Sok<br />
adat<br />
jön<br />
ide<br />
</div>
<?php
  endforeach;
?>