<?php
ob_start();
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
    <title>LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Vender
include "components/cp_editar_album_info.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
<script type="text/javascript">

    document.getElementById("outraeditora").disabled = true;
    document.getElementById("editora").disabled = false;


    var selectEditora = document.getElementById("editora");

    selectEditora.addEventListener("change", function () {
        var opcaoAlbum = selectEditora.value

        if (opcaoAlbum == "Selecionar") {
            document.getElementById("outraeditora").disabled = false;
        } else {
            document.getElementById("outraeditora").disabled = true;
        }
    });

    document.getElementById("outraeditora").addEventListener("keyup", function () {
        if (document.getElementById("outraeditora").value != "") {
            document.getElementById("editora").disabled = true;
        } else {
            document.getElementById("editora").disabled = false;

        }
    });


    document.getElementById("outraeditora").addEventListener("keyup", function () {
        if (document.getElementById("outraeditora").value != "") {
            document.getElementById("editora").disabled = true;
        } else {
            document.getElementById("editora").disabled = false;

        }
    });
</script>
</body>
</html>