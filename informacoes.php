<?php
session_start();
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
include_once "components/cp_navigation.php";
include_once "components/cp_info_conta.php";
include_once "components/cp_footer.php";
include_once "helpers/help_js.php";
?>
<script src="js/info_conta.js"></script>
</body>
</html>
