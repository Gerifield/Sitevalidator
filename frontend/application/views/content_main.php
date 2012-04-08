<form method="post" action="">
<p>URL: <input type="text" name="inurl" /> <input type="submit" value="Hozzáad" /></p>
</form>
<br />
<table class="proc_table">
<tr><th>ID</th><th>URL</th><th>Futtatás</th><th></th></tr>
<?php
  foreach($datalist as $row):
?>
<tr><td><?php echo $row['id']; ?></td> <td><?php echo $row['url']; ?></td></tr>
<?php
  endforeach;
?>
</table>