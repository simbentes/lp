<?php
session_start();
if (!isset($_SESSION["id_user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>Conta | LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Conta
include "components/cp_conta.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
</html>
