<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>LP</title>
</head>
<body>
<?php include_once "components/cp_navigation.php"; ?>
<main class="mainpi">
    <!-- Video -->
    <section class="seccao">
       <img src="img/studio.jpg" class="img-capa">
        <div class="overlayvideo text-white">
            <h1 id="responsive_headline" class="text-uppercase">LONG PLAY</h1>
        </div>
    </section>
</main>
<?php
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
</html>
