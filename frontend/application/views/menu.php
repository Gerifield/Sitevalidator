<div class="menu">
    <a class="menu_button" href="<?php echo site_url("main/index"); ?>">Főoldal</a>
    <a class="menu_button" href="<?php echo site_url("main/profile"); ?>">Profil</a>
    <?php
      if($this->dbmodel->isAdmin($this->session->userdata("user"))){
        echo '<a class="menu_button" href="'.site_url("main/admin").'">Admin</a>';
      }
    ?>
    <a class="menu_button" href="<?php echo site_url("main/logout"); ?>">Kilépés</a>
</div>
<div class="content">