<?php
        include 'core/init.php';

        $user_id = $_SESSION['user_id'];
        $user = User::getData($user_id);
        $who_users = Follow::whoToFollow($user_id);

        // update notification count
        User::updateNotifications($user_id);

        $notify_count = User::CountNotification($user_id);
        $notofication = User::notification($user_id);
        // var_dump($notofication);
        // die();
            if (User::checkLogIn() === false)
            header('location: index.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications |  slizz</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/profile_style.css?v=<?php echo time(); ?>">





</head>
<body>

<script src="assets/js/jquery-3.5.1.min.js"></script>


   <div id="mine">
     <nav>
           <div class="container"style="position: relative;">
               <h2 class="log">
                   <a style=" text-decoration: none;color:black" href="javascript: history.go(-1);" style="font-size:20px; " top:100px""="" class="fas fa-arrow-left arrow-style" aria-hidden="true"></a>
               </h2>
  </div>







     <div class="grid-posts">
       <div class="border-right">
         <div class="grid-toolbar-center">
      </div>




                      <div class="col-xs-10">
                          <p class="home-name"> Notifications</p>

                <div class="container mt-5">

                    <?php foreach($notofication as $notify) {
                        $user = User::getData($notify->notify_from);
                        $timeAgo = Tweet::getTimeAgo($notify->time);
                        ?>
                    <?php if ($notify->type == 'like') {
                       $icon = "<i style='color: red;font-size:30px;' class='fa-heart  fas ml-2'></i>";
                       $msg = "Liked Your Tweet";
                       } else if ($notify->type == 'retweet') {
                           $icon = "<i style='font-size:30px;color: rgb(22, 207, 22);'  class='fas fa-retweet ml-2'></i>";
                           $msg = "Retweeted Your Tweet";
                       } else if ($notify->type == 'qoute') {
                           $icon = "<i style='font-size:30px;color: rgb(22, 207, 22);'  class='fas fa-retweet ml-2'></i>";
                           $msg = "Quoted Your Tweet";
                       } else if ($notify->type == 'comment') {
                           $icon = "<i style='font-size:30px;' class='far fa-comment ml-2'></i>";
                           $msg = "Comment to your Tweet";
                       } else if ($notify->type == 'reply') {
                           $icon = "<i style='font-size:30px;' class='far fa-comment ml-2'></i>";
                           $msg = "Reply to your Comment";
                       } else if ($notify->type == 'follow') {
                           $icon = "<i style='font-size:30px;' class='fas fa-user ml-2'></i>";
                           $msg = "Followed You";
                       } else if ($notify->type == 'mention') {
                         $icon = "<i style='font-size:30px;' class='fas fa-user ml-2'></i>";
                         $msg = "Mention you in Tweet";
                       }?>

                    <div class="box-tweet py-3 ">
                       <a href="
                       <?php if ($notify->type == 'follow'){
                           echo $user->username;
                       } else { ?>
                           status/<?php echo $notify->target; ?>
                       <?php } ?>  ">
                       <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                       </a>

                               <div class="notify-user">
                                   <p>
                                   <a style="position: relative; z-index:1000;" href="<?php echo $user->username;  ?>">
                                       <img class="img-user" src="assets/images/users/<?php echo $user->img ?>" alt="">
                                   </a>

                                   </p>
                                   <p> <a style="font-weight: 700;
                                   font-size:18px;
                                   position: relative; z-index:1000;" href="<?php echo $user->username; ?>">
                                   <?php echo $user->name; ?> </a> <?php echo $msg; ?>
                                   <span style="font-weight: 500;" class="ml-3">
                                     <?php echo $timeAgo; ?>
                                   </span>
                                 </p>
                               </div>
                           </div>

                    <?php  } ?>
                </div>














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
