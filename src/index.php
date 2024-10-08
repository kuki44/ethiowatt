<?php

require 'translation.php';

$lang = 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'am'])) {
  $lang = $_GET['lang'];
}

?>

<html lang="<?php echo $lang; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $translations[$lang]['gli']; ?></title>
  <link href="output.css" rel="stylesheet">
</head>

<body class="bg-BrownLight w-full text-BrownDark font-TextFont overflow-y-scroll custom-scrollbar">
  <div class="md:w-3/4 w-full font-sans fixed top-0 z-50 md:bg-transparent bg-BrownLight">
    <div class="flex justify-between w-full md:py-6 md:px-10 py-2 px-4 mt-3 md:mt-0">
      <div class="flex my-auto md:mr-0 mr-1">
        <img src="img/logo.png" alt="" class="w-14 h-10 my-auto" />
        <h1 class="ml-1 font-extrabold font-TitleFont md:text-3xl text-base my-auto">
          <?php echo $translations[$lang]['logo']; ?>
        </h1>
      </div>

      <div class="my-auto flex">
        <a href="?lang=en" class="w-8 h-8 md:w-10 md:h-10">
          <img src="img/usa.png" alt="ethio"></a>
        <a href="?lang=am" class="w-8 h-8 md:w-10 md:h-10 ml-2">
          <img src="img/ethio.png" alt="usa"></a>
      </div>

      <div class="my-auto flex">
        <a href="signup.php?lang=<?php echo $_GET['lang']; ?>" class="rounded-lg md:mr-4 md:text-base text-sm mr-3 ml-1 md:ml-0 bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 md:px-5 py-2 px-3 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-110">
          <?php echo $translations[$lang]['sign']; ?></a>
        <a href="login.php?lang=<?php echo $_GET['lang']; ?>" class="rounded-lg md:mr-4 md:text-base text-sm bg-BrownDark font-TextFont text-BrownLight hover:font-extrabold font-bold md:py-3 md:px-5 py-2 px-3 shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-110">
          <?php echo $translations[$lang]['log']; ?></a>
      </div>
    </div>
  </div>

  <div class="md:grid grid-cols-2 my-auto w-full md:mt-0 mt-28">
    <div class="my-auto md:ml-14 ml-6 px-3 md:mb-auto mb-14">
      <p class="font-extrabold md:text-6xl text-4xl leading-normal hover:leading-snug ease-in-out transition-all duration-500">
        <?php echo $translations[$lang]['landing']; ?>
      </p>
      <p class="mt-1"><?php echo $translations[$lang]['sub']; ?></p>
    </div>
    <div class="relative w-full">
      <div class="absolute inset-0 z-0 flex">
        <div class="w-1/2 bg-brown-500"></div>
        <div class="w-1/2 bg-BrownDark"></div>
      </div>
      <div class="relative z-10 md:h-screen w-full">
        <img src="img/book8.png" alt="Your Image" class="md:h-full md:w-full object-cover" />
      </div>
    </div>
  </div>
  <div class="bottom-0 absolute ml-3 mb-3 md:block hidden">
    <img src="img/bottomleft.png" alt="" class="w-48 h-72" />
  </div>
</body>

</html>