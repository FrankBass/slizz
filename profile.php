<?php

    if (isset($_GET['username']) === true && empty($_GET['username']) === false ) {
        include 'core/init.php';
        $username = User::checkInput($_GET['username']);
        $profileId = User::getIdByUsername($username);
        $profileData = User::getData($profileId);
        $user_id = $_SESSION['user_id'];
        $user = User::getData($user_id);
        $who_users = Follow::whoToFollow($user_id);
        $tweets = Tweet::tweetsUser($profileData->id);
        $liked_tweets = Tweet::likedTweets($profileData->id);
        $media_tweets = Tweet::mediaTweets($profileData->id);
        $notify_count = User::CountNotification($user_id);

        if (!$profileData)
            header('location: index.php');

            if (User::checkLogIn() === false)
            header('location: index.php');

    }

  /*  $ah = " <link rel='stylesheet' href='assets/css/profile_style.css?v=<?php echo time(); ?>'>"; */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $profileData->name; ?> (@<?php echo $profileData->username; ?>) |  SLIZ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">

</head>
<body>

<script src="assets/js/jquery-3.5.1.min.js"></script>


    <div id="mine">

      <nav>


        <div class="container">
            <h2 class="log">
                    <a href="home.php"><img src="http://localhost/slizz//assets/images/Group6.png" alt="" height="40px" width="40px">

            </h2>

          </a>


<div class="container2">
          <div class="search-bar"style="position: relative;">
          <div class="uil uil-search">

  <!--======================== search bar ==========================-->
          <input type="search" class="form-control search-input" placeholder="Search">
          <div class="search-result">
            </div>
            </div>
            </div>
            </div>







        </nav>

        <!------------------------- MAIN -------------------------->

<container>
    <a class="container2"style="position: relative;word-break: break-word;">
              <div class="left2">




                      <!-- CARD PROFILE-->
                      <div class="middle">
                      <div class="feeds2">
                        <div class="feed2">

<div class="wrapper">
  <!-- barrre de retour en arriere page profil-->
              <a href="javascript: history.go(-1);"> <i style="font-size:20px; "top:100px"" class="fas fa-arrow-left arrow-style"></i> </a>
 <div class="profile-image">
<div class="row justify-content-between">
    <img class="home-img-user" src="assets/images/users/<?php echo $profileData->img; ?>" alt="">
    </div>
    </div>



          <div class="profile-bottom">
            <div class="profile-infos">

            </div>

            <div class="profile-stats">
              <div class="stat-item">
                <p class="stat"><span class="count-following-i"data-follow = "<?php echo $profileData->id; ?>"><?php echo Follow::countFollowing($profileData->id); ?></span></p>
                <p class="grey">Followings</p>
              </div>
              <div class="stat-item">
                <p class="stat2"><?php echo $profileData->name; ?></p>
                <p class="grey2">@<?php echo $profileData->username; ?></p>
              </div>
              <div class="stat-item">
                <p class="stat"><span class="count-followers-i"data-follow = "<?php echo $profileData->id; ?>"><?php echo Follow::countFollowers($profileData->id); ?></span> </p>
                <p class="grey"> Followers</p>
              </div>
            </div>
          </div>
        </div>
        </div>









                                  <!-- BOX EDIT PROFIL-->
                        <div class="box-home feed">
                          <div class="container">



                 <?php if ($user->id == $profileData->id) { ?>
                      <button class="btn btn-primary" data-toggle="modal" data-target="#edit">Edit Profile</button>

                    <!-- Modal Edit Profile -->
                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">

                        <form method="POST" action="handle/handleUpdateData.php" enctype="multipart/form-data">

                            <div style="width: 300%;" class="d-flex justify-content-between">
                            <div>
                            <h5 class="modal-title d-inline" id="exampleModalLongTitle">Edit Profile</h5>
                            </div>
                             </div>



                       <!-- modifier l'image de profil dans edit  -->
                        <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12">

                            <div class="image-upload">

                            <label for="file-input">
                                <i style="top: 224px;
                                 left:13px;
                                 color:black;
                                 font-size:30px;
                                 z-index:20 " class="far fa-images position-absolute"></i>
                                  </label>
                                <input id="file-input" name="image" type="file"/>
                            </div>
                            </div>


                            <img id="preview-user" class="home-img-user" src="assets/images/users/<?php echo $profileData->img; ?>" alt="">

                            </div>
                            <!-- <form class="" action=""> -->
                            <?php  if (isset($_SESSION['errors'] )) { ?>
                            <script>
                                $(document).ready(function(){
                            // Open modal on page load
                            $("#edit").modal('show');

                          });
                          </script>
                                    <?php foreach ($_SESSION['errors'] as $error) { ?>
                                          <div  class="alert alert-danger" role="alert">
                                            <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </div>  <?php }  }
                                            unset($_SESSION['errors']) ?> </p>


                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="<?php echo $user->name; ?>" aria-describedby="emailHelp" placeholder="Name">
                            </div>
                            <div class="form-group">
                            <input type="text" name="bio" class="form-control" id="exampleInputEmail1" value="<?php if ($user->bio !== null)
                            echo $user->bio ;?>" aria-describedby="emailHelp" placeholder="Bio">
                            </div>
                        <div class="form-group">

                            <input type="text" name="website" class="form-control" id="exampleInputEmail1" value="<?php if ($user->website !== null)
                            echo $user->website ;?>" aria-describedby="emailHelp" placeholder="Website">

                        </div>
                        <div class="form-group">

                            <input type="text" name="location" class="form-control" value="<?php if ($user->location !== null)
                            echo $user->location ;?>" id="exampleInputPassword1" placeholder="Location">
                        </div>
                        <div class="text-center">
                          <div>
                          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                           <!-- btn submit form -->
                          <button type="submit" name="update"  class="btn2 btn-primary">Save</button>
                        </div>
                        <!-- <button type="submit" name="signup" class="btn btn-primary">Sign Up</button> -->
                        </div>
                            </form>
                        </div>

                        </div>
                    </div>
                    </div>


                    <!-- End Edit Modal -->






                             <!-- BOUTON FOLLOW  -->
                             <div class="friend-requests">
                              <div class="request">

                    <?php } else {
                      $user_follow = Follow::isUserFollow($user_id , $profileData->id) ;
                      ?>



                   <button class=" follow-btn follow-btn-m btn btn-primary
                   <?= $user_follow ? 'follow' : 'following' ?>"
                  data-follow="<?php echo $profileData->id; ?>">
                    <?php if($user_follow) { ?>
                        Follow
                      <?php } else {  ?>
                          Following
                        <?php }  ?>
                    </button>
                      <?php } ?>
                 </div>
                 </div>
                 </div>








                   <!-- AFFICHAGE INFOR PERSO -->

                  <div class ="feeds2">
                    <div class ="feed2">

                  <div class="home-title">

                    <?php if (Follow::FollowsYou($profileData->id , $user_id)) { ?>
                  <span class="ml-1 follows-you">Follows You</span></p>
                  <?php } ?>


                    <p class="bio"><?php echo $profileData->bio; ?> </p>
                  </div>

                  <div class="row home-loc-link ml-2">
                      <?php if (!empty($profileData->location)) { ?>
                    <div class="col-md-4">


                      <li class=""> <i class="fas fa-map-marker-alt"></i> <?php echo $profileData->location; ?></li>
                    </div>
                    <?php } ?>
                    <?php if (!empty($profileData->website)) { ?>
                    <div class="col-md-4">
                    <li><i class="fas fa-link"></i>
                    <a href="<?php echo $profileData->website ;?>" target="_blank">
                    <?php echo parse_url($profileData->website, PHP_URL_HOST);; ?>
                  </a> </li>
                    </div>
                    <?php } ?>


                  </div>
                  </div>
                  </div>


                  <div class="popupUsers">

                  </div>



                                 <!-- ONGLET TWEET MEDIA LIKES -->
                     <ul class="nav nav-tabs justify-content-center mt-4" id="myTab" role="tablist">
                       <li class="nav-item">
                         <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                           Tweets</a>
                       </li>
                       <li class="nav-item">
                         <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                           Media</a>
                       </li>
                       <li class="nav-item">
                         <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                           Likes</a>
                       </li>
                     </ul>

                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <?php include 'includes/tweets.php'; ?>

                  </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?php
                       $tweets = $media_tweets;
                       include 'includes/tweets.php'; ?>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                       <?php
                       $tweets = $liked_tweets;
                       include 'includes/tweets.php'; ?>

                  </div>
                  </div>

               </div>


</container>



           <script src="assets/js/search.js"></script>
            <script src="assets/js/photo.js"></script>
            <script src="assets/js/follow.js?v=<?php echo time(); ?>"></script>
            <script src="assets/js/users.js?v=<?php echo time(); ?>"></script>
            <script type="text/javascript" src="assets/js/hashtag.js"></script>
          <script type="text/javascript" src="assets/js/like.js"></script>
          <script type="text/javascript" src="assets/js/comment.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/retweet.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
      <script src="assets/js/jquery-3.5.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
</body>


</html>
