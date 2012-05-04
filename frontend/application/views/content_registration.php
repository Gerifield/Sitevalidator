      <div class="content" style="margin-top: 20px;">
        <?php
        
        if($allowedReg){ //engedelyezett a regisztralas
          if(isset($errormsg)){
            echo '<div class="errormsg">'.$errormsg.'</div>';
          }
          if(isset($successmsg)){
            echo '<div class="successmsg">'.$successmsg.'</div>';
          }
        ?>
        <form method="post" action="">
        <table style="margin-left: auto; margin-right: auto;">
        <tr><td>Felhasználó név:</td><td><input type="text" name="user" value="<?php echo $user; ?>" /></td></tr>
        <tr><td>E-mail:</td><td><input type="text" name="email" value="<?php echo $email; ?>" /></td></tr>
        <tr><td>Jelszó:</td><td><input type="password" name="pass1" /></td></tr>
        <tr><td>Jelszó újra:</td><td><input type="password" name="pass2" /></td></tr>
        <tr><td></td><td><input type="submit" value="Regisztrál" /></td></tr>
        </table>
        </form>
        <?php
        }else{
          //tiltott a regisztralas
          echo '<div class="errormsg">A regisztráció szünetel!</div>';
        }
        ?>
        <br />
        <div style="text-align: center;"><a href="<?php echo site_url("main/index"); ?>">Főoldal</a></div>