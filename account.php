<?php

include 'core/init.php';

$user_id = $_SESSION['user_id'];

$user = User::getData($user_id);
$who_users = Follow::whoToFollow($user_id);
$notify_count = User::CountNotification($user_id);

if (User::checkLogIn() === false)
header('location: index.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings |  sliz</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
      <link rel="shortcut icon" type="image/png" href="assets/images/noun-planet-746888 1.svg">

</head>
<body>

  <nav>
              <div class="container"style="position: relative;">
                  <h2 class="log">
                    <a href="home.php"><img src="http://localhost/slizz//assets/images/Group6.png" alt="" height="40px" width="40px">
                  </h2>
                  </a>


      <div class="search-bar2"style="position: relative;">
                <div class="uil uil-search">

        <!--======================== search bar ==========================-->
                <input type="search" class="form-control search-input" placeholder="Search Twitter">
                <div class="search-result">
                  </div>
                  </div>
                  </div>




                          <!-- menu button to show sidebar -->
                          <button id="menu-btn"><i class="uil uil-bars"></i></button>
                      </div>
                  </div>
              </nav>










                         <div class="middle">
                                           <div class="feeds2">
                                             <div class="feed2">


            </div>

          </div>

          <div class="box-fixed" id="box-fixed"></div>

          <div class="box-home feed">
               <div class="container">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a style="color:black !important;" class="nav-link active text-center" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Change Email or Username</a>
                  <a style="color:black !important;" class="nav-link text-center" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Change Password</a>

                </div>
                <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <!-- Change EMAIL and USAERNAME Form -->

                    <form method="POST" action="handle/handleAccountSetting.php" class="py-4" >

                    <?php  if (isset($_SESSION['errors_account'] )) {

                        ?>

                        <?php foreach ($_SESSION['errors_account'] as $error) { ?>

                            <div  class="alert alert-danger" role="alert">
                                <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </p>
                            </div>
                                    <?php }   ?>

                        <?php }  unset($_SESSION['errors_account'])  ?>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Username</label>
                        <input type="text" name="username" value="<?php echo $user->username; ?>" class="form-control" id="exampleInputPassword1" placeholder="Username">
                      </div>

                      <div class="text-center">

                        <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                      </div>

                    </form>

                  </div>
                  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">


                    <!-- Change Password Form -->

                    <form method="POST" action="handle/handleChangePassword.php" class="py-4" >
                    <script src="assets/js/jquery-3.5.1.min.js"></script>
                    <?php  if (isset($_SESSION['errors_password'] )) {

                        ?>


                         <script>
                                $(document).ready(function(){
                            // Open modal on page load
                            $("#v-pills-profile-tab").click();

                          });
                          </script>

                        <?php foreach ($_SESSION['errors_password'] as $error) { ?>

                            <div  class="alert alert-danger" role="alert">
                                <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </p>
                            </div>
                                    <?php }   ?>

                        <?php }  unset($_SESSION['errors_password'])  ?>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Old Password</label>
                        <input type="password" name="old_password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Old Password">

                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" name="new_password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">Verify Password</label>
                        <input type="password" name="ver_password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
                      </div>

                      <div class="text-center">

                        <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                      </div>

                    </form>

                  </div>

                </div>

               </div>

          </div>
        </div>
        <div>



      <script src="assets/js/search.js"></script>
       <script src="assets/js/follow.js"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
</body>

<style>

  .container {
    padding-left: 55px;
  }

</style>

</html>
