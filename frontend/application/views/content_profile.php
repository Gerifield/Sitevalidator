      <?php
      if(isset($errormsg)){
        echo '<div class="errormsg">'.$errormsg.'</div>';
      }
      ?>
      <form method="post" action="">
      <table style="margin-left: auto; margin-right: auto;">
      <tr><td>E-mail:</td><td><input type="text" name="email" value="<?php if($email){echo $email; } ?>" /></td></tr>
      <tr><td>Jelszó*:</td><td><input type="password" name="pass1" /></td></tr>
      <tr><td>Jelszó újra*:</td><td><input type="password" name="pass2" /></td></tr>
      <tr><td></td><td><input type="submit" value="Módosít" /></td></tr>
      </table>
      <div style="text-align: center;">*: Csak akkor add meg, ha módosítani szeretnéd!</div>
      </form>