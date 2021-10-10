<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>Repor Password | LP</title>
</head>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Login
include "components/cp_nova_password.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
</html>