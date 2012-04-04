      <?php
        if(isset($successmsg)){
          echo '<div class="successmsg">'.$successmsg.'</div>';
        }
      ?>
      <form method="post" action="">
      <table style="margin-left: auto; margin-right: auto;">
      <tr><td>Nyitott regisztráció:</td><td><input type="checkbox" name="freereg" <?php if($freereg){ echo 'checked="checked"'; } ?> /></td></tr>
      <tr><td><input type="hidden" name="formsent" value="true" /></td><td><input type="submit" value="Módosít" /></td></tr>
      </table>
      </form>