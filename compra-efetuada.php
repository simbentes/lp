<?php
session_start();
if (!isset($_SESSION["id_user"]) || !isset($_SESSION["compra"])) {
    header("Location: index.php");
} else {
//ninguem pode aceder a esta página sem ter efetuado uma compra
    unset($_SESSION["compra"]);
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Conta
include "components/cp_compra_efetuada.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
</html>
