for (let i = 0; i < 10; i++) {
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51IochkEXIHZvd72G9U75xhT3z7JNaSUIuWYydsMic22sQiM4dpneEhE8GFs7HKxZO8239ct7ihaQ2VbY4yZQ752700k8y2T4qR");
    var checkoutButton = document.getElementById("pagar" + i);

    checkoutButton.addEventListener("click", function () {
        fetch("sc_pagamento_stripe.php?id=ola", {
            method: "POST",
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
    });


}
