<?php
    session_start();
    

    include("classes/connect.php");
    include("classes/login.php");
    include("classes/user.php");
    include("classes/post.php");


    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_userid']);

    //posting starts here
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $post = new Post();
        $id = $_SESSION['mybook_userid'];
       $result = $post->create_post($id, $_POST);

       if($result== "")
       {
         header("Location: profile.php");
         die;
       }else
       {

         echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey'>";
         echo "<br>The following errors occured:<br><br>";
         echo $result;
         echo "</div>"; 
       }
    }

    //collect posts
    $post = new Post();
    $id = $_SESSION['mybook_userid'];

    $posts = $post->get_posts($id);
   
    //collect friends
    $post = new User();
    $id = $_SESSION['mybook_userid'];

    $friends = $post->get_friends($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Mybook</title>
</head>
<style>
     #blue_bar{
        height: 50px;
        background-color: #405d9b;
        color: #d9dfeb;
     }

     #search_box{
        width:440px;
        height:20px;
        border-radius: 5px;
        border:none;
        padding:4px;
        font-size:14px;
        background-image:url("search.png");
        background-size:20px;
        background-repeat: no-repeat;
        background-position:right;
     }

     #profile_pic{
        width:150px;
        margin-top:-200px;
        border-radius: 50%;
        border:solid 2px white;
     }

     #menu_buttons{
        width:100px;
        display:inline-block;
        margin:2px;
     }

     #friends_img{
        width:75px;
        height:75px;
        float:left;
        margin:8px;
     }

     #friends_bar{
        background-color: white;
        min-height:400px;
        margin-top:20px;
        color:#aaa;
        padding:8px;
     }

     #friends{
        clear:both;
        font-size:12px;
        font-weight:bold;
        color:#405d9b;
     }

     textarea{
        
        width:100%;
        border:none;
        font-family:tahoma;
        font-size:14px;
        height:60px;
        outline:none;
        resize:none;
     }

     #post_button{
        float:right;
        background-color:#405d9b;
        border:none;
        color:white;
        padding:4px;
        font-size:14px;
        border-radius:2px;
        width:50px;
     }

     #post_bar{
        margin-top:20px;
        background-color:white;
        padding:10px;
     }

     #post{
      padding:4px;
      font-size:13px;
      display:flex;
      margin-bottom:20px;
     }
</style>
<body style="font-family:tahoma; background-color:#d0d8e4;">

    <br>
   <?php include("header.php");?>
    
       <!--cover area-->
      <div style="width:800px; margin:auto; min-height:520px;">
        <div style="background-color:white; text-align:center; color:#405d9b";>
          <img src="uploads/sam_cover.jpg" style="width:100%; height:400px;">
          <span style="font-size:12px;">
            <?php
               $image = "";
               if(file_exists($user_data['profile_image']))
               {
                  $image = $user_data['profile_image'];
               }
            ?>
            <img src="<?php echo $image ?>" id="profile_pic"><br>
           <a style="text-decoration:none; color:#f0f;" href="change_profile_image.php">Change Image</a>
         </span>
          <br>
            <div style="font-size:20px;"><?php echo $user_data['first_name'] . " " .$user_data['last_name'] ?></div>
          <br>
          <a href="index.php"><div id="menu_buttons">Timeline</div></a>
          <div id="menu_buttons">About</div>
          <div id="menu_buttons">Friends</div>
          <div id="menu_buttons">Photos</div> 
          <div id="menu_buttons">Settings</div>
      </div>

      <!--below cover area-->
        <div style="display:flex;">

        <!--friends area-->
            <div style="min-height:400px;flex:1;">
              <div id="friends_bar">
                
              Friends<br>

              <?php
                if($friends)
                {
                  foreach($friends as $FRIEND_ROW){  
                     $user = new User();
                     $ROW_USER = $user->get_user($FRIEND_ROW['userid']);

                     include("user.php");
                  }
                }
             ?>

        </div>
     </div>

            <!--posts area-->
            <div style="min-height:400px;flex:2.5; padding:20px; padding-right:0px;">
                <div style="border:solid thin #aaa; padding: 10px;background-color:white;">

                <form method="POST">
                  <textarea name="post" placeholder="Whats on your mind?"></textarea>
                  <input id="post_button" type="submit" value="Post">
                  <br>
              </form>
            </div>
            
             <!--posts-->
             <div id="post_bar">
             
             <?php
                if($posts)
                {
                  foreach($posts as $ROW){  
                     $user = new User();
                     $ROW_USER = $user->get_user($ROW['userid']);

                     include("post.php");
                  }
                }
             ?>
          
             </div>

             </div>
        </div>
    </div>

  


    
</body>
</html>