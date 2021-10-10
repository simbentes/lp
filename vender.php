<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<script>
    function showUser(str) {
        if (str == "") {
            document.getElementById("txtAlbum").innerHTML = "hello";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtAlbum").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "scripts/sc_artista_album.php?q=" + str, true);
            xmlhttp.send();
        }
    }
</script>
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <title>Conta | SecondHand</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Vender
include "components/cp_vender_album.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
<script src="js/vender.js"></script>
</body>
</html>

