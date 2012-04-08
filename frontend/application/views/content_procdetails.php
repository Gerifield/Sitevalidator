<table class="proc_table" style="width: 100%">
<tr><td>ID:</td><td><?php echo $datalist["id"]; ?></td></tr>
<tr><td>URL:</td><td><?php echo $datalist["url"]; ?></td></tr>
<tr><td>Futtatás ideje:</td><td><?php echo $datalist["runtime"]; ?></td></tr>
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