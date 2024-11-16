<?php
     session_start();
   
     include("classes/connect.php");
     include("classes/login.php");
     include("classes/user.php");
     include("classes/post.php");
 
 
     $login = new Login();
     $user_data = $login->check_login($_SESSION['mybook_userid']);

     //postin starts here
     if($_SERVER['REQUEST_METHOD'] == "POST")
     {
      
      if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
      {
       if($_FILES['file']['type'] == "image/jpeg")
       {
          
         $allowed_size = (1024 * 1024) * 3;
         if($_FILES['file']['size'] < $allowed_size)
         {
             //everything is fine
             $filename = "uploads/" . $_FILES['file']['name'];
             move_uploaded_file($_FILES['file']['tmp_name'], $filename);
         
             if(file_exists($filename))
             {
               
               $userid = $user_data['userid'];
               $query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";
               $DB = new Database();
               $DB->save($query);
      
               header("location: profile.php");
               die;
             }
         }else
         {

            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey'>";
            echo "<br>The following errors occured:<br><br>";
            echo "Only images of size 3Mb or lower are allowed";
            echo "</div>"; 
         }
       }else
       {
          
         echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey'>";
         echo "<br>The following errors occured:<br><br>";
         echo "Only images of Jpeg type are allowed";
         echo "</div>"; 
       }

     }else
     {
      echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey'>";
      echo "<br>The following errors occured:<br><br>";
      echo "please add a valid image";
      echo "</div>"; 
     }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile Image | Mybook</title>
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


     #post_button{
        float:right;
        background-color:#405d9b;
        border:none;
        color:white;
        padding:4px;
        font-size:14px;
        border-radius:2px;
        width:100px;
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

      <!--below cover area-->

     
        <div style="display:flex;">

      
            <!--posts area-->
            <div style="min-height:400px;flex:2.5; padding:20px; padding-right:0px;">

            <form method="POST" enctype="multipart/form-data">
                <div style="border:solid thin #aaa; padding: 10px;background-color:white;">
                 
                  <input type="file" name="file"><br>
                  <input id="post_button" type="submit" value="Change">
                  <br>
            </div>
      </form>
            
             
               </div>
             </div>

             </div>
        </div>
    </div>


</body>
</html>