<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>Sobre | LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Sobre
include "components/cp_sobre.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
</html>
