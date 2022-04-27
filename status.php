<?php
   include 'core/init.php';

   $user_id = $_SESSION['user_id'];

   $user = User::getData($user_id);

   if (User::checkLogIn() === false)
   header('location: index.php');


   $tweet_id =  $_GET['post_id'];
   $tweet = Tweet::getData($tweet_id);
   $who_users = Follow::whoToFollow($user_id);
   $notify_count = User::CountNotification($user_id);


?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status | SLIZ</title>
    <base href="<?php echo BASE_URL; ?>">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">


</head>
<body>
<script src="assets/js/jquery-3.5.1.min.js"></script>

    <div id="mine">
      <nav>
            <div class="container"style="position: relative;">
                <h2 class="log">
                    <a style=" text-decoration: none;color:black" href="home.php">SLIZ
                </h2>
                </a>


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









          <div class="grid-toolbar-center">
            <div class="center-input-search">


                <div class="container" style="border-bottom: 1px solid #E9ECEF;">

                  <div class="row">
                       <div class="col-xs-1">
                      <!-- history go to the perv page and specific section user come from -->
                 <a href="javascript: history.go(-1);"> <i style="font-size:20px;" class="fas fa-arrow-left arrow-style"></i> </a>
                       </div>





                  </div>
                  <div class="part-2">

                  </div>

                </div>



            </div>
            <!-- <div class="mt-icon-settings">
              <img src="https://i.ibb.co/W5T9ycN/settings.png" alt="" />
            </div> -->
          </div>



          <?php

                $retweet_sign = false;
                $retweet_comment =false;
                $qoq = false;

            if (Tweet::isTweet($tweet->id)) {

              $tweet_user = User::getData($tweet->user_id) ;
              $tweet_real = Tweet::getTweet($tweet->id);
              $timeAgo = Tweet::getTimeAgo($tweet->post_on) ;
              $likes_count = Tweet::countLikes($tweet->id) ;
              $user_like_it = Tweet::userLikeIt($user_id ,$tweet->id);
              $retweets_count = Tweet::countRetweets($tweet->id) ;
              $user_retweeted_it = Tweet::userRetweeetedIt($user_id ,$tweet->id);

            } else if (Tweet::isRetweet($tweet->id)) {

              $retweet = Tweet::getRetweet($tweet->id);

              if ($retweet->retweet_msg == null) {

                    if ($retweet->retweet_id == null) {

                      // if retweeted normal tweet
                      $retweeted_tweet = Tweet::getTweet($retweet->tweet_id);
                    $tweet_user = User::getData($retweeted_tweet->user_id) ;
                    $tweet_real = Tweet::getTweet($retweet->tweet_id);
                    $timeAgo = Tweet::getTimeAgo($tweet_real->post_on) ;
                    $likes_count = Tweet::countLikes($retweet->tweet_id) ;
                    $user_like_it = Tweet::userLikeIt($user_id ,$retweet->tweet_id);
                    $retweets_count = Tweet::countRetweets($retweet->tweet_id) ;
                    $user_retweeted_it = Tweet::userRetweeetedIt($user_id ,$retweet->tweet_id);
                    $retweeted_user = User::getData($tweet->user_id);
                    $retweet_sign = true;
                    } else {

                      // this condtion if user retweeted quoted tweet or quote of quote tweet


                    $retweeted_tweet = Tweet::getRetweet($retweet->retweet_id);

                        if($retweeted_tweet->tweet_id != null) {
                        // here it's retweeted quoted
                        // if($retweeted_tweet->)
                        $tweet_user = User::getData($retweeted_tweet->user_id) ;
                        $timeAgo = Tweet::getTimeAgo($retweeted_tweet->post_on) ;
                        $likes_count = Tweet::countLikes($retweeted_tweet->post_id) ;
                        $user_like_it = Tweet::userLikeIt($user_id ,$retweeted_tweet->post_id);
                        $retweets_count = Tweet::countRetweets($retweeted_tweet->post_id) ;
                        $user_retweeted_it = Tweet::userRetweeetedIt($user_id ,$retweeted_tweet->post_id);


                        $tweet_inner = Tweet::getTweet($retweeted_tweet->tweet_id);
                        $user_inner_tweet = User::getData($tweet_inner->user_id) ;
                        $timeAgo_inner = Tweet::getTimeAgo($tweet_inner->post_on);
                        $retweeted_user = User::getData($tweet->user_id);
                        $retweet_sign = true;

                        $qoute = $retweeted_tweet->retweet_msg;
                        $retweet_comment = true;
                        } else {
                            // here is retweeted quoted of quoted

                        $retweet_sign = true;
                        $tweet_user = User::getData($retweeted_tweet->user_id) ;

                         $timeAgo = Tweet::getTimeAgo($retweeted_tweet->post_on) ;
                        $likes_count = Tweet::countLikes($retweeted_tweet->post_id) ;
                        $user_like_it = Tweet::userLikeIt($user_id ,$retweeted_tweet->post_id);
                        $retweets_count = Tweet::countRetweets($retweeted_tweet->post_id) ;
                        $user_retweeted_it = Tweet::userRetweeetedIt($user_id ,$retweeted_tweet->post_id);

                        $qoq = true; // stand for quote of quote
                        $qoute = $retweeted_tweet->retweet_msg;
                        $tweet_inner = Tweet::getRetweet($retweeted_tweet->retweet_id);
                        $user_inner_tweet = User::getData($tweet_inner->user_id) ;
                        $timeAgo_inner = Tweet::getTimeAgo($tweet_inner->post_on);
                        $inner_qoute  = $tweet_inner->retweet_msg;



                        $retweeted_user = User::getData($tweet->user_id);

                        }
                    }

            } else {
              // quote tweet condtion
              if ($retweet->retweet_id == null) {
              $tweet_user = User::getData($tweet->user_id) ;
              $timeAgo = Tweet::getTimeAgo($tweet->post_on) ;
              $likes_count = Tweet::countLikes($tweet->id) ;
              $user_like_it = Tweet::userLikeIt($user_id ,$tweet->id);
              $retweets_count = Tweet::countRetweets($tweet->id) ;
              $user_retweeted_it = Tweet::userRetweeetedIt($user_id ,$tweet->id);
              $qoute = $retweet->retweet_msg;
              $retweet_comment = true;


              $tweet_inner = Tweet::getTweet($retweet->tweet_id);
              $user_inner_tweet = User::getData($tweet_inner->user_id) ;
              $timeAgo_inner = Tweet::getTimeAgo($tweet_inner->post_on);
            } else {

            // this condtion for quote of quote which retweet_id not null and retweet msg not null
            $tweet_user = User::getData($tweet->user_id) ;
            $timeAgo = Tweet::getTimeAgo($tweet->post_on) ;
            $likes_count = Tweet::countLikes($tweet->id) ;
            $user_like_it = Tweet::userLikeIt($user_id ,$tweet->id);
            $retweets_count = Tweet::countRetweets($tweet->id) ;
            $user_retweeted_it = Tweet::userRetweeetedIt($user_id ,$tweet->id);
            $qoute = $retweet->retweet_msg;
            $qoq = true; // stand for quote of quote

            $tweet_inner = Tweet::getRetweet($retweet->retweet_id);
            $user_inner_tweet = User::getData($tweet_inner->user_id) ;
            $timeAgo_inner = Tweet::getTimeAgo($tweet_inner->post_on);
            $inner_qoute = $tweet_inner->retweet_msg;
            if($inner_qoute == null) {

              $tweet_innerr = Tweet::getRetweet($tweet_inner->retweet_id);
              $inner_qoute = $tweet_innerr->retweet_msg;

              // $inner_quote = "qork";

            }

            }

            }

            }
             $tweet_link = $tweet->id;

            //  show real tweet comments if retweeted tweet
              if ($retweet_sign)
              $comments = Tweet::comments($retweeted_tweet->id);
              else  $comments = Tweet::comments($tweet_id);


            if($retweet_sign)
             $comment_count = Tweet::countComments($retweeted_tweet->id);
             else  $comment_count = Tweet::countComments($tweet->id);


            ?>


            <div class="middle">
                    <div class="feeds">
                      <div class="feed">
          <div class="box-tweet feed" >
                 <a href="status/<?php echo $tweet->id; ?>">

                 </a>
                 <div class="head">
            <?php if ($retweet_sign) { ?>

            <span class="retweed-name"> <i class="fa fa-retweet retweet-name-i" aria-hidden="true"></i>
            <a style="position: relative; z-index:100; color:rgb(102, 117, 130);" href="<?php echo $retweeted_user->name; ?> "> <?php  if($retweeted_user->id == $user_id) echo "You";
        else echo $retweeted_user->name; ?> </a>  retweeted</span>
             <?php } ?>
           </div>


            <div class="grid-tweet"style="position: relative;word-break: break-word;">
                <a style="position: relative; z-index:1000" href="<?php echo $tweet_user->username;  ?>">
                <img
                src="assets/images/users/<?php echo $tweet_user->img; ?>"
                alt=""
                class="img-user-tweet"
                />
                </a >

                <div>
                <p>
                <a style="position: relative; z-index:1000; color:black" href="<?php echo $tweet_user->username;  ?>">
                <strong> <?php echo $tweet_user->name ?> </strong>
                </a>
                  <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                  <span class="username-twitter"><?php echo $timeAgo ?></span>
                </p>
                <p>
                  <?php
                  // check if it's quote or normal tweet
                  if ($retweet_comment || $qoq)
                  echo  Tweet::getTweetLinks($qoute);
                  else echo  Tweet::getTweetLinks($tweet_real->status); ?>
                </p>
                  <?php if ($retweet_comment == false && $qoq == false) { ?>
                <?php if ($tweet_real->img != null) { ?>
                <p class="mt-post-tweet">
                  <img
                    src="assets/images/tweets/<?php echo $tweet_real->img; ?>"
                    alt=""
                    class="img-post-tweet"
                  />
                </p>
               <?php } } else { ?>
                   <!-- ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss -->

                  <div  class="mt-post-tweet comment-post">

                    <a href="status/<?php echo $tweet_inner->id; ?>">
                          <span class="" style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 2;"></span>
                       </a>
                  <div class="grid-tweet py-3 "  >

                  <a style="position: relative; z-index:1000" href="<?php echo $user_inner_tweet->username;  ?>">
                    <img
                    src="assets/images/users/<?php echo $user_inner_tweet->img; ?>"
                    alt=""
                    class="img-user-tweet"
                    />
                    </a >

                    <div>
                    <p>
                    <a style="position: relative; z-index:1000; color:black" href="<?php echo $user_inner_tweet->username;  ?>">
                    <strong> <?php echo $user_inner_tweet->name ?> </strong>
                    </a>
                  <span class="username-twitter">@<?php echo $user_inner_tweet->username ?> </span>
                  <span class="username-twitter"><?php echo $timeAgo_inner ?></span>
                </p>
                <p>
                  <?php
                    if ($qoq)
                    echo Tweet::getTweetLinks($inner_qoute);
                    else  echo  Tweet::getTweetLinks($tweet_inner->status); ?>
                </p>
                <?php   // don't show img if quote of quote
                if ($qoq == false) {
                if ($tweet_inner->img != null) { ?>
                <p class="mt-post-tweet">
                  <img
                    src="assets/images/tweets/<?php echo $tweet_inner->img; ?>"
                    alt=""
                    class="img-post-retweet"
                  />
                </p>
               <?php } } ?>

              </div>

            </div>


                </div>





                <?php } ?>

                <div class="row home-follow pt-3">

                        <?php if($retweets_count > 0)  { ?>
                            <div class="col-md-2 users-count" >
                            <i class="retweets-u"
                            data-tweet="<?php
                            if($retweet_sign)
                                echo $retweeted_tweet->id;
                            else  echo $tweet->id; ?>">
                     <span class="home-follow-count"> <?php echo $retweets_count ; ?> </span> Retweets</i>
                        </div>
                        <?php } ?>
                        <?php if($likes_count > 0)  { ?>
                        <div class="col-md-2 users-count">
                            <div class="likes-u"
                            data-tweet="<?php
                            if($retweet_sign)
                                echo $retweeted_tweet->id;
                            else  echo $tweet->id; ?>">
                             <span class="home-follow-count">  <?php echo $likes_count ; ?>  </span> Likes</div>
                        </div>
                        <?php } ?>
                  </div>

                <div class="grid-reactions">
                  <div class="grid-box-reaction">
                    <div class="hover-reaction hover-reaction-comment comment"
                    data-user = "<?php echo $user_id; ?>"
                    data-tweet = "<?php
                    if($retweet_sign)
                       echo $retweeted_tweet->id;
                   else  echo $tweet->id; ?>">

                      <i class="far fa-comment"></i>
                      <div class="mt-counter likes-count d-inline-block">
                        <p> <?php if($comment_count > 0) echo $comment_count; ?> </p>
                      </div>
                    </div>
                  </div>
                  <div class="grid-box-reaction">

                    <div  class="hover-reaction hover-reaction-retweet
                    <?= $user_retweeted_it ? 'retweeted' : 'retweet' ?> option"
                    data-tweet="<?php
                    // send the tweet you wanna undo retweet to undo function
                    // if the user retweeted it and it's the real tweet
                    // to send the id of retweeted tweet
                    // if($user_retweeted_it && !$retweet_sign)
                    // echo Tweet::retweetRealId($tweet->id);
                    // else
                     echo $tweet->id ;
                     ?>"
                    data-user="<?php echo $user_id; ?>
                    "
                    data-retweeted = "<?php echo $user_retweeted_it; ?>"
                    data-sign = "<?php echo $retweet_sign; ?>"
                    data-tmp="<?php echo $retweet_comment; ?>"
                    data-qoq="<?php echo $qoq; ?>"
                    data-status="<?php echo true; ?>">



                      <i class="fas fa-retweet"></i>
                      <div class="mt-counter likes-count d-inline-block">
                        <p><?php if($retweets_count > 0)  echo $retweets_count ; ?></p>
                      </div>



                    </div>

                    <div class="options">


                      </div>

                  </div>
                  <div  class="grid-box-reaction"  >
                    <a class="hover-reaction hover-reaction-like
                    <?= $user_like_it ? 'unlike-btn' : 'like-btn' ?> "
                    data-tweet="<?php
                     if($retweet_sign) {
                              if($retweet->tweet_id != null) {
                                echo $retweet->tweet_id;
                              } echo $retweet->retweet_id;
                     }  else echo $tweet->id ;
                    //  echo Tweet::likedTweetRealId($tweet->id);

                     ?>"
                    data-user="<?php echo $user_id; ?>">


                      <i class="fa-heart <?= $user_like_it ? 'fas' : 'far mt-icon-reaction' ?>"></i>
                      <!-- <i class="fas fa-heart liked"></i> -->

                      <div class="mt-counter likes-count d-inline-block">
                      <p> <?php if($likes_count > 0)  echo $likes_count ; ?> </p>
                      </div>
                </a>


                </div>

                  <div class="grid-box-reaction">
                    <div class="hover-reaction hover-reaction-comment">



                    </div>
                    <div class="mt-counter">
                      <p></p>
                    </div>
                  </div>
                </div>
              </div>

            </div>




          </div>

              <div class="comments">


          <!-- comments place -->
          <?php foreach($comments as $comment) {
                     $tweet_user = User::getData($comment->user_id) ;
                     $timeAgo = Tweet::getTimeAgo($comment->time);
                     $replies = Tweet::replies($comment->id);
                     $reply_count = Tweet::countReplies($comment->id);
              ?>

          <div class="box-comment feed py-2"  >


            <div class="user">
              <div>
                <img
                  src="assets/images/users/<?php echo $tweet_user->img; ?>"
                  alt=""
                  class="img-user-tweet"
                />
              </div>

              <div>
                <p>
                  <strong> <?php echo $tweet_user->name ?> </strong>
                  <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                  <span class="username-twitter"><?php echo $timeAgo ?></span>
                </p>
                <p>
                  <?php
                 echo  Tweet::getTweetLinks($comment->comment); ?>
                </p>

                <div class="grid-reactions">
                  <div class="grid-box-reaction-rep">
                    <div class="hover-reaction-rep hover-reaction-comment reply"
                    data-user = "<?php echo $user_id; ?>"
                    data-tweet = "<?php
                    echo $comment->id; ?>">

                      <i class="far fa-comment"></i>
                      <div class="mt-counter likes-count d-inline-block">
                        <p > <?php if($reply_count > 0) echo $reply_count; ?> </p>
                      </div>
                    </div>
                  </div>



                  </div>

              </div>


            </div>

        </div>


                        <!-- replies -->
                <?php foreach ($replies as $reply) {
                       $tweet_user = User::getData($reply->user_id) ;
                       $timeAgo = Tweet::getTimeAgo($reply->time);

                    ?>
                        <div class="box-reply feed"  >


                                <div class="grid-tweet">
                                <div>
                                    <img
                                    src="assets/images/users/<?php echo $tweet_user->img; ?>"
                                    alt=""
                                    class="img-user-tweet"
                                    />
                                </div>

                                <div>
                                    <p>
                                    <strong> <?php echo $tweet_user->name ?> </strong>
                                    <span class="username-twitter">@<?php echo $tweet_user->username ?> </span>
                                    <span class="username-twitter"><?php echo $timeAgo ?></span>
                                    </p>
                                    <p>
                                    <?php
                                    echo  Tweet::getTweetLinks($reply->reply); ?>
                                    </p>


                                </div>


                                </div>

                            </div>

                            <?php } ?>
            <?php } ?>

          <div class="popupTweet">

          </div>
          <div class="popupComment">

           </div>
           <div class="popupUsers">

           </div>

           </div>






        </div>


          </div>
          </div>





       <script src="assets/js/index.js"></script>
      <script src="assets/js/search.js"></script>
      <script type="text/javascript" src="assets/js/hashtag.js"></script>
      <script type="text/javascript" src="assets/js/like.js"></script>
      <script type="text/javascript" src="assets/js/users.js"></script>
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
