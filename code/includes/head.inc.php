<!DOCTYPE html>
<html>
   <head>
      <title>Admin Dashboard</title>

      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://code.getmdl.io/1.1.1/material.css">
      <link rel="stylesheet" href="css/styles.css">
      <script defer src="https://code.getmdl.io/1.1.1/material.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   </head>

   <body>
      <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">

         <header class="mdl-layout__header mdl-color--grey-100">
            <div class="mdl-layout__header-row">
               <span class="mdl-layout-title mdl-color-text--black"><?php echo $headertext; ?></span>
            </div>
         </header>

         <div class="mdl-layout__drawer mdl-color--blue-grey-900">
            <span class="mdl-layout-title mdl-color-text--white">Admin Dashboard</span>
            <nav class="mdl-navigation mdl-color--blue-grey-800">
               <a class="mdl-navigation__link mdl-color-text--white" href="index.php">Home - PHP</a>
               <a class="mdl-navigation__link mdl-color-text--white" href="js.php">Home - JS</a>
               <a class="mdl-navigation__link mdl-color-text--white" href="about.php">About</a>
               <a class="mdl-navigation__link mdl-color-text--white" href="browsers.php">Visit Browser</a>
               <a class="mdl-navigation__link mdl-color-text--white" href="charts.php">Charts</a>
            </nav>
         </div>
			
			<main class="mdl-layout__content mdl-color--grey-100">