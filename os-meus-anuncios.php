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
    <title>Conta | SecondHand</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Guardados
include "components/cp_anuncios.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
<script>
    function guardarAlbum(estado, produto) {
        //vamos enviar por ajax o produto e estado do botao(checkbox), para saber se o user "guardou" ou "removeu dos guardados"
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                location.reload();
            }
        };
        xmlhttp.open("GET", "scripts/sc_guardar_album.php?guardado=" + estado + "&produto=" + produto, true)
        ;
        xmlhttp.send();


    }
</script>
</html>
