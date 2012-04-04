      <?php
        if(isset($errormsg)){
          echo '<div class="errormsg">'.$errormsg.'</div>';
        }
        if(isset($successmsg)){
          echo '<div class="successmsg">'.$successmsg.'</div>';
        }
      ?>
      <form method="post" action="">
      <table style="margin-left: auto; margin-right: auto;">
      <tr><td>Felhasználó név:</td><td><?php echo $this->session->userdata('user'); ?></td></tr>
      <tr><td>E-mail:</td><td><input type="text" name="email" value="<?php echo $email; ?>" /></td></tr>
      <tr><td>Jelszó*:</td><td><input type="password" name="pass1" /></td></tr>
      <tr><td>Jelszó újra*:</td><td><input type="password" name="pass2" /></td></tr>
      <tr><td></td><td><input type="submit" value="Módosít" /></td></tr>
      </table>
      <div style="text-align: center;">*: Csak akkor add meg, ha módosítani szeretnéd!</div>
      </form>