<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

if (isset($_POST["login"])) {
  $username = $_POST['UserName'];
  $password = $_POST['Password'];

  $usernameAdmin = "Admin321";

  if (!empty($username) && !empty($password)) {

    if ($username == $usernameAdmin) {
      $sql = "SELECT * FROM `USER` WHERE `UserName` = '$username'";
      $rs = mysqli_query($con, $sql);
      $result = mysqli_fetch_assoc($rs);
      if ($test = password_verify($password, $result['Password'])) {

        session_start();
        $_SESSION['UserName'] = $result['UserName'];
        setcookie('UserName',$username, time()+3600);

        header("Location: adminHome.php?&login=success&lang=" . $lang);
        exit();
      } else {
        header("Location: login.php?error=incorrect&username=" . $username . "&lang=" . $lang);
        exit();
      }
    } else {
      $sql = "SELECT * FROM `USER` WHERE `UserName` = '$username'";
      $rs = mysqli_query($con, $sql);
      $result = mysqli_fetch_assoc($rs);
      $count = mysqli_num_rows($rs);

      if ($count > 0) {

        if ($test = password_verify($password, $result['Password'])) {

          session_start();
          $_SESSION['UserName'] = $result['UserName'];
          setcookie('UserName',$username, time()+3600);

          header("Location: announcements.php?&login=success&lang=" . $lang);
          exit();
        } else {
          header("Location: login.php?error=incorrect&username=" . $username . "&lang=" . $lang);
          exit();
        }
      } else {
        header("Location: login.php?error=signedup&lang=" . $lang);
        exit();
      }
    }
  } else {
    header("Location: login.php?error=emptyfields&username=" . $username . "&lang=" . $lang);
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $translations[$lang]['log']; ?></title>
  <link rel="stylesheet" href="output.css">
</head>

<body class="w-full h-screen bg-BrownLight text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
  <div class="flex justify-center items-center h-full shadow-2xl shadow-BrownDark">
    <div class="mx-auto p-5 lg:w-5/12 shadow-2xl shadow-BrownDark2 px-10 py-10">
      <div class="flex justify-center">
        <img src="img/logo.png" class="w-14 h-10 my-auto" />
        <h1 class="ml-1 text-center font-extrabold font-TitleFont text-3xl my-auto text-BrownDark">
        <?php echo $translations[$lang]['logo']; ?>
        </h1>
        <div class="my-auto flex">
        <a href="?lang=en" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/usa.png" alt="ethio"></a>
        <a href="?lang=am" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/ethio.png" alt="usa"></a>
      </div>
      </div>
      <h1 class="md:text-6xl text-lg font-extrabold font-TitleFont text-center">
      <?php echo $translations[$lang]['welcome']; ?>
      </h1>
      <p class="text-center">
      <?php echo $translations[$lang]['login']; ?>
      </p>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?lang=<?php echo $_GET['lang']; ?>" method="post" class="py-6 h-1/3 md:px-12">
        <div class="col-span-2 mb-4">
          <label htmlFor="username"><?php echo $translations[$lang]['username']; ?>*</label>
          <input id="username" type="text" name="UserName" placeholder="<?php echo $translations[$lang]['enteru']; ?>" value="<?php
                                                                                                if (isset($_GET['username'])) {
                                                                                                  echo $_GET['username'];
                                                                                                } ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
        </div>
        <div class="col-span-2 mb-4">
          <label htmlFor="password"><?php echo $translations[$lang]['pass']; ?>*</label>
          <input id="password" type="password" name="Password" minlength="8" placeholder="<?php echo $translations[$lang]['min']; ?>" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
        </div>
        <div class="col-span-2">
          <?php

          if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyfields") {
          ?>
              <div class="error text-red"><?php echo $translations[$lang]['1']; ?></div>
            <?php
            } elseif ($_GET['error'] == "incorrect") {
            ?>
              <div class="error text-red"><?php echo $translations[$lang]['8']; ?></div>
            <?php
            } elseif ($_GET['error'] == "signedup") {
            ?>
              <div class="error text-red"><?php echo $translations[$lang]['9']; ?></div>
            <?php
            } elseif ($_GET['login'] == "success") {
            ?>
              <div class="error text-red"><?php echo $translations[$lang]['10']; ?></div>
          <?php
            }
          }
          ?>
        </div>
        <div class="my-auto col-span-4 mt-2 mb-1">
          <input type="submit" name="login" value="<?php echo $translations[$lang]['log']; ?>" class="w-full rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
        </div>
        <div class="col-span-4">
          <p class="inline"><?php echo $translations[$lang]['dont']; ?> </p>
          <a href="signup.php?lang=<?php echo $_GET['lang']; ?>" class="font-extrabold font-sans font-italic inline underline">
          <?php echo $translations[$lang]['sign']; ?>
          </a>
        </div>
      </form>
    </div>
  </div>
  <div class="bottom-0 absolute ml-5">
    <img src="img/BookOffer.png" class="lg:h-auto lg:w-auto h-44" />
  </div>
</body>

</html>