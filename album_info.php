<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include_once "helpers/help_meta.php" ?>
    <?php include_once "helpers/help_estilos.php" ?>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <title>LP</title>
</head>
<body>
<?php
// Navbar
include_once "components/cp_navigation.php";
// Detalhes do Álbum
include_once "components/cp_album_details.php";
// Footer
include_once "components/cp_footer.php";
// Javascript
include_once "helpers/help_js.php";
?>
</body>
<script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51IochkEXIHZvd72G9U75xhT3z7JNaSUIuWYydsMic22sQiM4dpneEhE8GFs7HKxZO8239ct7ihaQ2VbY4yZQ752700k8y2T4qR");
    var checkoutButton = document.getElementById("checkout-button");

    function comprar(id_produto) {
        document.getElementById("loading").innerHTML = "<div class='spinner-border cor mt-3 mr-2' role='status'><span class='sr-only'>Loading...</span></div>"


        fetch("scripts/sc_checkout.php", {
            method: "POST",
            body: 'id=' + id_produto,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (session) {
                return stripe.redirectToCheckout({sessionId: session.id});
            })
            .then(function (result) {
                // If redirectToCheckout fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using error.message.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error("Error:", error);
            });
    };
</script>
</html>