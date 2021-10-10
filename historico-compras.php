<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>Histórico de Compras | LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Guardados
include "components/cp_historico_compras.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
</html>
