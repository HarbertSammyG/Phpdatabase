 <!--top bar-->
 <div id="blue_bar">
       <div style="margin:auto; width:800px; font-size:30px;">
        <a href="index.php" style="color:white">Mybook</a>
        
        &nbsp &nbsp <input type="text" id="search_box" placeholder="Search for people">

    <a href="profile.php">
          <?php
               $image = "";
               if(file_exists($user_data['profile_image']))
               {
                  $image = $user_data['profile_image'];
               }
            ?>
        <img src="<?php echo $image; ?>" style="width:50px; float:right;">
    </a>

        <a href="logout.php">
        <span style="font-size:11px;float:right;margin:10px;color:white;">Logout</span>
       </a>
        <br>
       </div>
    </div>
