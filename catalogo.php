<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>Catálogo | LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Catálogo
include "components/cp_catalogo.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
<script src="js/catalogo.js">
</script>
</html>
