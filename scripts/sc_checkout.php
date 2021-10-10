<?php
session_start();
require "../connections/connection.php";
require "../stripe-php/init.php";

if (isset($_POST["id"])) {

    unset($_SESSION["produto_vendido"]);

    $post_id_produtos = $_POST["id"];


    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    //recolher info produto
    $query = "SELECT produtos.preco, produtos.img_capa, produtos.ref_id_utilizadores_vendedores, albuns.titulo, albuns.descricao, artistas.nome FROM `produtos` INNER JOIN albuns ON produtos.ref_id_albuns = albuns.id_albuns INNER JOIN artistas ON albuns.ref_id_artistas = id_artistas WHERE id_produtos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {

        // Bind variables by type to each parameter
        mysqli_stmt_bind_param($stmt, 'i', $post_id_produtos);
        /* execute the prepare statement */
        mysqli_stmt_execute($stmt);
        /* bind result variables */
        mysqli_stmt_bind_result($stmt, $preco, $capa, $vendedor, $titulo, $descricao, $artista);


        if (!mysqli_stmt_fetch($stmt)) {
            echo "Error: " . mysqli_stmt_error($link);
            die;
        }
        //impedir que o utilizador compre um album a si próprio
        if ($_SESSION["id_user"] ==  $vendedor) {
            echo "Não podemos comprar os nossos produtos!";
            die;
        }


    } else {
        echo "Error: " . mysqli_error($link);
    }


    $precofinal = str_replace(".", "", $preco);
    $precoproduto = intval($precofinal);


    mysqli_stmt_close($stmt);
    mysqli_close($link);


    \Stripe\Stripe::setApiKey('sk_test_51IochkEXIHZvd72GNuUdenqbpucExsrEjRkjmS2EYbizGWBJ9qZqIQ16rHUe2qcdRGD9GIbNYDVDyFhnkf9Ntkxh00Ul37Rcs6');

    header('Content-Type: application/json');

    $YOUR_DOMAIN = 'https://labmm.clients.ua.pt/deca_20L4/deca_20L4_03/MP';


    $checkout_session = \Stripe\Checkout\Session::create([
        'customer_email' => $_SESSION["email"],
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $precoproduto,
                'product_data' => [
                    'name' => $artista . " — " . $titulo,
                    'description' => $descricao,
                ],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/scripts/sc_pagamento_realizado.php',
        'cancel_url' => $YOUR_DOMAIN . '/album_info.php?item=' . $post_id_produtos,
    ]);

    if (isset($checkout_session)) {
        $_SESSION["produto_vendido"] = $post_id_produtos;
    }


    echo json_encode(['id' => $checkout_session->id]);


}