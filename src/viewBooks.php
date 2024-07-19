<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "header.php";

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

if (isset($_SESSION['UserName']) && isset($_COOKIE['UserName'])) {


?>

  <head>
    <title><?php echo $translations[$lang]['vbooks']; ?></title>
  </head>

  <body class="bg-BrownLight w-full h-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">

    <div class="w-full grid md:grid-cols-5 grid-cols-3 bg-BrownDark3 md:mt-20 mt-16">
      <div class="w-full md:col-span-2">
        <img src="img/imgbook.jpg" alt="" class="w-full">
      </div>

      <div class="w-full my-auto md:col-span-3 col-span-2">
        <h1 class="hero lg:text-5xl md:text-2xl font-TitleText font-bold text-center text-BrownLight bg-BrownDark md:py-6 py-3 md:mb-4"><?php echo $translations[$lang]['vbooks']; ?></h1>
        <p class="text-center lg:text-xl md:text-sm text-xs"><?php echo $translations[$lang]['explore']; ?></p>
        <div class="text-center md:text-base text-xs">
          <p class="inline"><?php echo $translations[$lang]['issue']; ?></p>
          <a class="inline font-extrabold underline" href="https://t.me/Ikam43"><?php echo $translations[$lang]['report']; ?></a>
        </div>
      </div>
    </div>

    <div class="w-full flex justify-center my-4">
      <input type="text" id="searchInput" class="shadow-lg w-[45%] block appearance-none border bg-transparent rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline placeholder-BrownDark2" placeholder="<?php echo $translations[$lang]['searchb']; ?>...">
    </div>

    <div class="pt-10" id="searchResults">
      <?php


      function truncateText($text, $maxLength)
      {
        if (strlen($text) > $maxLength) {
          $text = substr($text, 0, $maxLength) . '...';
        }
        return $text;
      }


      $select = "select * from BOOK ORDER BY Title ASC";
      $rs = mysqli_query($con, $select);
      $count = mysqli_num_rows($rs);
      if ($count > 0) {
      ?>
        <div class="flex justify-center">
          <div style="width: 85%">

            <div class="grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 gap-4">
              <?php
              while ($result = mysqli_fetch_assoc($rs)) {
                $truncatedDesc = truncateText($result['Book_Desc'], 49);
                $truncatedTitle = truncateText($result['Title'], 39);
              ?>
                <div class="mb-14">
                  <div class="mt-4">
                    <div>
                      <a href="bookdetail.php?id=<?= $result['Book_ID'] ?>&lang=<?php echo $_GET['lang']; ?>">
                        <img style="margin: 20px; margin-left: auto; margin-right: auto; margin-bottom: 6px; width: 150px; height: 200px; object-fit: cover; object-position: center;" src="<?= $result['Photo'] ?>" alt="whats new" class="mx-auto">
                        <h2 class="font-bold font-TitleFont text-center text-xs pb-1 underline">
                          <?php echo $truncatedTitle ?>
                        </h2>
                      </a>

                      <h3 class="pt-1 text-xs text-center"><?php echo $truncatedDesc ?></h3>
                      <p class="text-xs text-center"><?php echo $result['Add_Date'] ?></p>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>

          </div>
        </div>
      <?php
      } else {
        echo "<h2 class='text-center text-3xl font-bold mb-5'>No records found</h2>";
      }
      ?>
    </div>

    <script>
      var vibo = document.getElementById("vibo");
      vibo.setAttribute("style", "border-bottom-width: 2px;");

      window.addEventListener('scroll', function() {
        const header = document.querySelector('nav');
        if (window.pageYOffset > 0) {
          header.classList.add('shadow-2xl');
        } else {
          header.classList.remove('shadow-2xl');
        }
      });
    </script>

  </body>

  </html>

<?php
} else {
  header("Location: index.php");
}
?>