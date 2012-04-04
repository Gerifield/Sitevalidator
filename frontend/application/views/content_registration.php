      <div class="content" style="margin-top: 100px;">
        <?php
        if(isset($errormsg)){
          echo '<div class="errormsg">'.$errormsg.'</div>';
        }
        ?>
        <form method="post" action="">
        <table style="margin-left: auto; margin-right: auto;">
        <tr><td>Felhasználó név:</td><td><input type="text" name="user" /></td></tr>
        <tr><td>E-mail:</td><td><input type="text" name="email" /></td></tr>
        <tr><td>Jelszó:</td><td><input type="password" name="pass1" /></td></tr>
        <tr><td>Jelszó újra:</td><td><input type="password" name="pass2" /></td></tr>
        <tr><td></td><td><input type="submit" value="Regisztrál" /></td></tr>
        </table>
        </form>