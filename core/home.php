<?php

   include 'core/init.php';

   $user_id = $_SESSION['user_id'];

   $user = User::getData($user_id);

   if (User::checkLogIn() === false)
   header('location: index.php');


   $tweets = Tweet::tweets($user_id);
   $who_users = Follow::whoToFollow($user_id);
   $notify_count = User::CountNotification($user_id);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | SLIZ</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>

        <link rel="stylesheet" href="assets/css/style.css">













</head>
<body>


  <!-- This is a modal for welcome the new signup account! -->

<script src="assets/js/jquery-3.5.1.min.js"></script>

  <?php  if (isset($_SESSION['welcome'])) { ?>
    <script>
     $(document).ready(function(){
      // Open modal on page load
      $("#welcome").modal('show');


     });
    </script>
    <!-- Modal -->
<div class="modal fade" id="welcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div  class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="">
        <div class="text-center">
         <span  class="modal-title font-weight-bold text-center" id="exampleModalLongTitle">
          <span style="font-size: 20px;">Welcome <span style="color:#207ce5"><?php echo $user->name; ?></span>  </span>
         </span>
        </div>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <div class="text-center">

        <h4 style="font-weight: 600; " >You've Signed up Successfully!</h4>

        </div>
        <p>Cette application est développé par  <span style="font-weight: 700;">Frank bassilekin & tachrifa hamada </span> dans le cadre d'un projet de classe.</p>
        <p>Le projet clone comprend tweet , retweet , quote ou même citer le tweet cité , comme tweet et commentaires imbriqués.
          Vous pouvez mentionner ou ajouter un hashtag à votre tweet, modifier votre mot de passe ou votre nom d'utilisateur.
          uivez ou ne suivez plus les gens. recevoir une notification si une action se produit. Rechercher des utilisateurs par nom ou nom d'utilisateur. et plus!
        </p>
        <p>Par défaut, vous avez suivi
          <a style="color:#207ce5;" href="codeastro">@bass</a>
            pour voir nos tweets.</p>
      </div>

    </div>
  </div>
</div>

      <?php unset($_SESSION['welcome']); } ?>

      <!-- End welcome -->

    <div id="mine">


  <nav>
        <div class="container"style="position: relative;">
            <h2 class="log">
                SLIZ
            </h2>


<div class="search-bar"style="position: relative;">
          <div class="uil uil-search">

  <!--======================== search bar ==========================-->
          <input type="search" class="form-control search-input" placeholder="Search Twitter">
          <div class="search-result">
            </div>
            </div>
            </div>


                <div class="create">

                    <!-- menu button to show sidebar -->
                    <button id="menu-btn"><i class="uil uil-bars"></i></button>
                </div>
            </div>
        </nav>

        <!------------------------- MAIN -------------------------->
        <main>
            <div class="container"style="position: relative;">

                <!--======================== PHOTO DE PROFILE LEFT HOME PAGE ==========================-->
                <div class="left">
            <div class="profile">
              <div class="profile-photo">
                <img
                  src="assets/images/users/<?php echo $user->img ?>"
                  alt="user"
                  class="img-user"
                />
              </div>
              <div>
                <p class="handle"><h4><?php if($user->name !== null) {
                echo $user->name; } ?></h4></p>
                <p class="text-muted">@<?php echo $user->username; ?></p>
              </div>

      </div>

                    <!-- close button -->
                    <span id="close-btn"><i class="uil uil-multiply"></i></span>





                    <!-------------------- SIDEBAR ------------------------->

                    <!-------------------- HOME ------------------------->
                    <a href="home.php">
                    <div class="sidebar">
                        <a class="menu-item active">
                            <span><i class="uil uil-home" href="home.php" ></i></span><h3>Home</h3>
                        </a>
                        </a>







                      <!-------------------- PROFILE ------------------------->
                        <a href="<?php echo BASE_URL . $user->username; ?>">
                      <div class="menu-item">

                        <span><i class="uil uil-compass"></i></span>
                          <!-- <a href="/twitter/<?php echo $user->username; ?>" </a> -->
                            <span><a href="<?php echo BASE_URL . $user->username; ?>"></a></span><h3>Profile</h3></a>

                        </div>
                      </a>











                      <!-------------------- NOTIFICATION ------------------------->
                      <div class="menu-item">
                      <a href="notification.php">



                       <span><i class="uil uil-bell"></i></span>
                           <?php if ($notify_count > 0) { ?>
                         <i class="notify-count"><?php echo $notify_count; ?></i>
                         <?php } ?>
                        <span><a href="notification.php"></a></span><h3>Notifications</h3>
                       </div>
                     </a>




                         <!-------------------- messages ------------------------->
                        <a class="menu-item" id="messages-notification">
                            <span><i class="uil uil-envelope-alt"></i></span><h3>Messages</h3>

                            <!-------------------- Theme ------------------------->

                        <a class="menu-item" id="theme">
                            <span><i class="uil uil-palette"></i></span><h3>Theme</h3>
                        </a>



                        <!-------------------- Settings ------------------------->
                        <a href="<?php echo BASE_URL . "account.php"; ?>">
          <div class="menu-item">
            <span><i class="uil uil-setting"></i></span>
              <span><a href=" account.php"></a></span><h3>Settings</h3>

            </div>
            </div>




                    <!------------------- Logout-------------------->
                    <a href="includes/logout.php">
              <div class="create-post">
                <label class="btn btn-primary">Logout</label>
                  <a href="includes/logout.php"></a>
                </div>
                </div>

                <!------------------- END OF LEFT -------------------->












                            <!--======================== MIDDLE ==========================-->
                            <div class="middle">

                                <!------------------- STORIES -------------------->
                                <div class="stories">

                                    <?php
                                     foreach($who_users as $user){
                                       //  $u = User::getData($user->user_id);
                                        $user_follow = Follow::isUserFollow($user_id , $user->id) ;
                                        ?>
                                    <div class="story">
                                        <div class="profile-photo">
                                          <a style="color: white" href="<?php echo $user->username;  ?>">
                                            <img src="assets/images/users/<?php echo $user->img; ?>"
                                           alt=""
                                         />
                                        </div>
                                        </a>
                                        <p class="name">
                                         <a href="<?php echo $user->username;  ?>">
                                         <?php echo $user->name; ?>
                                         </a>
                                           </div>
                                         </p>
                                             <?php }?>



                                             <?php
                                              foreach($who_users as $user){
                                                //  $u = User::getData($user->user_id);
                                                 $user_follow = Follow::isUserFollow($user_id , $user->id) ;
                                                 ?>
                                         <div class="story">
                                             <div class="profile-photo">
                                               <a style="color: white" href="<?php echo $user->username;  ?>">
                                                 <img src="assets/images/users/<?php echo $user->img; ?>"
                                                alt=""
                                              />
                                             </div>
                                             </a>
                                             <p class="name">
                                              <a href="<?php echo $user->username;  ?>">
                                              <?php echo $user->name; ?>
                                              </a>
                                                </div>
                                              </p>
                                              <?php }?>

                                </div>




                                 <!------------------- END OF STORIES -------------------->
                                 <div class="create-post">


                                   <div class="text">
                      <form class="" action="handle/handleTweet.php" method="post" enctype="multipart/form-data">
                        <div class="inner">
                          <div class="profile-photo">

                            <img src="assets/images/users/default.jpg" alt="user" class="img-user">
                            </div>

                          <label>

                            <textarea class="text-whathappen" name="status" rows="8" cols="80" placeholder="What's happening?"></textarea>

                        </label>
                        </div>

                         <!-- tmp image upload place -->
                        <div class="position-relative upload-photo">
                          <img class="img-upload-tmp" src="assets/images/tweets/tweet-60666d6b426a1.jpg" alt="">
                          <div class="icon-bg">
                          <i id="#upload-delete-tmp" class="fas fa-times position-absolute upload-delete"></i>

                          </div>
                        </div>


                        <div class="bottom">

                          <div class="bottom-container">

                            <label for="tweet_img" class="ml-3 mb-2 uni">

                              <i class="fa fa-image item1-pair"></i>
                            </label>
                            <input class="tweet_img" id="tweet_img" type="file" name="tweet_img">

                          </div>

                          <div class="hash-box">

                              <ul style="margin-bottom: 0;">


                              </ul>

                          </div>








                          <?php if (isset($_SESSION['errors_tweet'])) {

                            foreach($_SESSION['errors_tweet'] as $t) {?>

                          <div class="alert alert-danger">
                          <span class="item2-pair"> <?php echo $t; ?> </span>
                          </div>

                         <?php } } unset($_SESSION['errors_tweet']); ?>
                          <div>

                            <span class="bioCount" id="count">140</span>
                            <input id="tweet-input" type="submit" name="tweet" value="Tweet" class="btn btn-primary"
                            >
                          </div>
                      </div>
                      </form>
                      </div>
                    </div>





















                <div class="feeds" >

                <?php  include 'includes/tweets.php'; ?>
                </div>
                </div>


















                <!--======================== RIGHT ==========================-->
                <div class="right">
                    <div class="messages">
                        <div class="heading">
                            <h4>Messages</h4><i class="uil uil-edit"></i>
                        </div>
                        <!------------ SEARCH BAR -------------->
                        <div class="search-bar">
                            <i class="uil uil-search"></i>
                            <input type="search" placeholder="Search messages" id="message-search">
                        </div>


                        <!------------ MESSAGES CATEGORY -------------->
                        <div class="category">
                            <h6 class="active">Primary</h6>
                            <h6>General</h6>
                            <h6 class="message-requests">Requests(7)</h6>
                        </div>
                        <!------------ MESSAGE -------------->
                        <!----- MESSAGE ----->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile-2.jpg">
                            </div>
                            <div class="message-body">
                                <h5>Edem Quist</h5>
                                <p class="text-muted">Just woke up bruh</p>
                            </div>
                        </div>
                        <!----- MESSAGE ----->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile-3.jpg">
                                <div class="active"></div>
                            </div>
                            <div class="message-body">
                                <h5>Franca Deila</h5>
                                <p class="text-bold">Received bruh. Thanks!</p>
                            </div>
                        </div>
                        <!----- MESSAGE ----->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile-4.jpg">
                            </div>
                            <div class="message-body">
                                <h5>Jane Doe</h5>
                                <p class="text-bold">ok</p>
                            </div>
                        </div>
                        <!----- MESSAGE ----->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile-5.jpg">
                            </div>
                            <div class="message-body">
                                <h5>Daniella Jackson</h5>
                                <p class="text-bold">2 new messages</p>
                            </div>
                        </div>
                        <!----- MESSAGE ----->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile-6.jpg">
                            </div>
                            <div class="message-body">
                                <h5>Juliet Makarey</h5>
                                <p class="text-muted">lol u right</p>
                            </div>
                        </div>
                        <!----- MESSAGE ----->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile-7.jpg">
                                <div class="active"></div>
                            </div>
                            <div class="message-body">
                                <h5>Chantel Msiza</h5>
                                <p class="text-bold">Birthday Tomorrow!</p>
                            </div>
                        </div>
                    </div>
                    <!------------ END OF MESSAGES -------------->








                     <!------------ FRIEND REQUESTS -------------->

                     <div class="friend-requests">
                               <h4>Who to follow</h4>

                               <?php
                               foreach($who_users as $user) {
                                 //  $u = User::getData($user->user_id);
                                  $user_follow = Follow::isUserFollow($user_id , $user->id) ;
                                  ?>
                             <div class="request">

                             <a href="<?php echo $user->username;  ?>">

                                         <img

                                           src="assets/images/users/<?php echo $user->img; ?>"
                                           alt=""
                                           />

                                       <div>
                                         <a style="color: black" href="<?php echo $user->username;  ?>">
                                         <strong><?php echo $user->name; ?></strong>
                                         </a>
                                           </div>




                                         <p class="text-muted">@<?php echo $user->username; ?>
                                         <?php if (Follow::FollowsYou($user->id , $user_id)) { ?>
                                     <span class="ml-1 follows-you">Follows You</span></p>
                                     <?php } ?></p>

                                       <div class="action">
                                         <button class="follow-btn follow-btn-m btn btn-primary
                                         <?= $user_follow ? 'following' : 'follow' ?>"
                                         data-follow="<?php echo $user->id; ?>"
                                         data-user="<?php echo $user_id; ?>"
                                         data-profile="<?php echo $u_id; ?>">
                                         <?php if($user_follow) { ?>
                                           Following
                                         <?php } else {  ?>
                                             Follow
                                           <?php }  ?>
                                         </button>
                                       </div>
                                     </div>
                                     




                                     <?php }?>

                           </div>
                       </div>
                   </div>
                   </div>
               </div>
               <!--====================== END OF RIGHT ==========================-->
           </div>
       </main>

     <!--================================================ THEME CUSTOMIZATION =============================================-->
     <div class="customize-theme">
        <div class="card">
            <h2>Customize your view</h2>
            <p class="text-muted">Manage your font size, color, and background.</p>

            <!------------ FONT SIZES ------------->
            <div class="font-size">
                <h4>Font Size</h4>
                <div>
                    <h6>Aa</h6>
                <div class="choose-size">
                    <span class="font-size-1"></span>
                    <span class="font-size-2"></span>
                    <span class="font-size-3"></span>
                    <span class="font-size-4"></span>
                    <span class="font-size-5"></span>
                </div>
                <h3>Aa</h3>
                </div>
            </div>

            <!------------ PRIMARY COLORS ------------->
            <div class="color">
                <h4>Color</h4>
                <div class="choose-color">
                <span class="color-1 active"></span>
                <span class="color-2"></span>
                <span class="color-3"></span>
                <span class="color-4"></span>
                <span class="color-5"></span>
                </div>
            </div>

            <!---------- BACKGROUND COLORS ------------>
            <div class="background">
                <h4>Background</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Light</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5>Dim</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Lights Out</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/index.js"></script>
      <script src="assets/js/search.js"></script>
          <script src="assets/js/photo.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/hashtag.js"></script>
          <script type="text/javascript" src="assets/js/like.js"></script>
          <script type="text/javascript" src="assets/js/comment.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/retweet.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/follow.js?v=<?php echo time(); ?>"></script>

      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
      <script src="assets/js/jquery-3.5.1.min.js"></script>

        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>


</body>
</html>
