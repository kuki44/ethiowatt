<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("conn.php");
session_start();
// require "header.php";

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {

    $UserName = $_SESSION['UserName'];

    $sql = "SELECT * FROM `USER` WHERE `UserName` = '$UserName'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($rs);

    if (isset($_POST['update'])) {

        $fname = $_POST['Full_Name'];
        $email = $_POST['Email'];
        $Bio = $_POST['Bio'];
        $password = $_POST['Password'];

        if (!empty($fname) && !empty($email) && !empty($_POST['Gender']) && !empty($password)) {
            $gender = $_POST['Gender'];

            $sql = "SELECT * FROM `USER` WHERE `UserName` = '$UserName'";
            $rs = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($rs);
            if (password_verify($password, $result['Password'])) {
                $oldPhoto = $result['Photo'];

                if (file_exists($oldPhoto)) {
                    if (unlink($oldPhoto)) {
                        echo "File '$oldPhoto' has been deleted successfully.";
                    } else {
                        echo "Error: Could not delete the file '$oldPhoto'.";
                    }
                } else {
                    echo "Error: File '$oldPhoto' does not exist.";
                }

                if (!empty($_FILES['Photo']['name'])) {

                    $imagename = $_FILES['Photo']['name'];
                    $tmpname = $_FILES['Photo']['tmp_name'];
                    $error = $_FILES['Photo']['error'];

                    if ($error === 0) {
                        $imageex = pathinfo($imagename, PATHINFO_EXTENSION);

                        $imageexlc = strtolower($imageex);

                        $allowedex = array('jpg', 'jpeg', 'png');

                        if (in_array($imageexlc, $allowedex)) {
                            $newimgname = uniqid("IMG-", true) . '.' . $imageexlc;
                            $imguploadpath = 'uploads/user/' . $newimgname;
                            move_uploaded_file($tmpname, $imguploadpath);
                            $newimgname = 'uploads/user/' . $newimgname;
                        } else {
                            header("Location: editprofile.php?error=notsupported");
                            exit();
                        }
                    }
                } else {
                    $newimgname = "uploads/user/default.jpg";
                }


                $newimgname = mysqli_real_escape_string($con, $newimgname);
                $fname = mysqli_real_escape_string($con, $fname);
                $gender = mysqli_real_escape_string($con, $gender);
                $Bio = mysqli_real_escape_string($con, $Bio);
                $email = mysqli_real_escape_string($con, $email);


                $sql = "UPDATE USER SET Full_Name = '$fname', Email = '$email', Bio = '$Bio', Gender = '$gender', Photo = '$newimgname' WHERE UserName = '$UserName'";
                if ($con->query($sql) === TRUE) {
                    header("Location: ppuser.php?update=success&lang=" . $lang);
                    exit();
                } else {
                    header("Location: editprofile.php?update=notsuccess");
                    exit();
                }
            } else {
                header("Location: editprofile.php?error=incorrect");
                exit();
            }
        } else {
            header("Location: editprofile.php?error=emptyfields");
            exit();
        }

    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $translations[$lang]['eprofile']; ?></title>
        <link rel="stylesheet" href="output.css">
    </head>

    <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
    <div class="flex p-4 fixed top-0 mt-1">
        <img src="img/logo.png" class="w-14 h-10 my-auto" />
        <h1 class="ml-1 font-extrabold font-TitleFont text-3xl my-auto text-BrownDark">
        <?php echo $translations[$lang]['logo']; ?>
        </h1>
    </div>
        <div class="mt-14">
            <h3 class="text-center font-bold text-xl">Edit Your Profile</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?lang=<?php echo $_GET['lang']; ?>" class="ml-12 mr-12" style="width: 45%; margin-left:auto; margin-right:auto; margin-top:auto; margin-down:auto;" method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label htmlFor="full_name" class="">
                    <?php echo $translations[$lang]['full']; ?>*
                    </label>
                    <input id="Full_Name" name="Full_Name" type="text" placeholder="<?php echo $translations[$lang]['enter']; ?>" value="<?php echo $result['Full_Name'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="email" class="">
                    <?php echo $translations[$lang]['email']; ?>*
                    </label>
                    <input id="Email" name="Email" type="email" placeholder="name@example.com" value="<?php echo $result['Email'] ?>" class="block w-full shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="mb-2">
                    <label htmlFor="Bio" class="">
                    <?php echo $translations[$lang]['bio']; ?>
                    </label>
                    <input id="Bio" name="Bio" type="text" placeholder="Something about yourself" value="<?php echo $result['Bio'] ?>" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="gender" class="">
                    <?php echo $translations[$lang]['gender']; ?>*
                    </label>
                    <div class="border rounded-lg border-BrownDark flex py-2 px-4 mt-1">
                        <input type="radio" name="Gender" value="Male" />
                        <?php echo $translations[$lang]['male']; ?>
                        <input type="radio" name="Gender" value="Female" class="ml-2" />
                        <?php echo $translations[$lang]['female']; ?>
                    </div>
                </div>
                <div class="mb-2">
                    <label htmlFor="userName"><?php echo $translations[$lang]['username']; ?>*</label>
                    <input readonly id="UserName" name="UserName" type="text" placeholder="unique username" value="<?php echo $result['UserName'] ?>(<?php echo $translations[$lang]['noedit']; ?>)" class="shadow-lg w-full block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>
                <div class="mb-2">
                    <label htmlFor="pp" class="">
                    <?php echo $translations[$lang]['ucpp']; ?>
                    </label>
                    <input type="file" name="Photo" value="<?php echo $result['Photo'] ?>" class="block w-full bg-BrownLight border border-BrownDark border-dotted rounded-md px-3 py-2 text-BrownDark" />
                </div>
                <div class="mb-2">
                    <label htmlFor="password"><?php echo $translations[$lang]['cupass']; ?>*</label>
                    <input id="Password" name="Password" minLength={8} type="password" placeholder="<?php echo $translations[$lang]['min']; ?>" class="w-full block shadow-lg appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" />
                </div>

                <div class="mb-4">
                    <?php

                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyfields") {
                    ?>
                            <div class="error text-red">Fill in all the required Fields</div>
                        <?php
                        } elseif ($_GET['error'] == "incorrect") {
                        ?>
                            <div class="error text-red">Current password not correct</div>
                        <?php
                        } elseif ($_GET['error'] == "notsupported") {
                        ?>
                            <div class="error text-red">Image not supported</div>
                        <?php
                        } elseif ($_GET['update'] == "notsuccess") {
                        ?>
                            <div class="error text-red">Updating not successful</div>
                    <?php
                        } elseif ($_GET['update'] == "success") {
                            ?>
                                <div class="error text-red">Updated successfully</div>
                        <?php
                            }
                    }
                    ?>
                </div>
                <input type="submit" value="<?php echo $translations[$lang]['update']; ?>" name="update" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                <a href="ppuser.php?lang=<?php echo $_GET['lang']; ?>" class="rounded-lg mr-4 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold py-3 px-5 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105"><?php echo $translations[$lang]['cancel']; ?></a>
            </form>
        </div>


    </body>

    </html>

<?php

} else {
    header("Location: index.php");
}
?>