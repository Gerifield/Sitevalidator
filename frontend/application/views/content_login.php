      <div class="content" style="margin-top: 100px;">
        <?php
        if(isset($errormsg)){
          echo '<div class="errormsg">'.$errormsg.'</div>';
        }
        ?>
        <form method="post" action="">
        <table style="margin-left: auto; margin-right: auto;">
        <tr><td>Felhasználó név:</td><td><input type="text" name="user" value="<?php if($user){echo $user; } ?>" /></td></tr>
        <tr><td>Jelszó:</td><td><input type="password" name="pass" /></td></tr>
        <tr><td></td><td><input type="submit" value="Login" /></td></tr>
        <?php
        if($allowedReg){
          echo '<tr><td></td><td><a href="#">Regisztrál</a></td></tr>';
        }
        ?>
        </table>
        </form>