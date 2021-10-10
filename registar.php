<?php
session_start();
if (isset($_SESSION["id_user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>Registar | LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Registar
include "components/cp_registar_user.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
<script src="js/registar.js"></script>
</body>
</html>
