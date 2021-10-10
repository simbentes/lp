<?php
if (!isset($_SESSION["id_user"])) {
    header("Location: index.php");
} else {
    ?>

    <main class="bg-light">
        <section class="container pt-5 pb-3">
            <a class="text-desativo" href="conta.php">Conta</a>
            <i class="fas fa-chevron-right px-2 iconedestivo"></i>
            <span>Histórico de Compras</span>
        </section>
        <section class="container pb-4">
            <h3 id="guardados" class="pb-3">Histórico de Compras</h3>
        </section>
        <section class="container">
            <div class="row">
                <section class="container pb-3">
                    <div class="row">
                        <?php

                        require_once("connections/connection.php");

                        $link = new_db_connection();
                        $stmt = mysqli_stmt_init($link);

                        $query = "SELECT produtos.img_capa, artistas.nome, albuns.titulo, utilizadores.nome, utilizadores.apelido, utilizadores.fotoperfil, produtos.preco, encomendas.data, id_encomendas
                    FROM `produtos`
                    INNER JOIN albuns
                    ON produtos.ref_id_albuns = albuns.id_albuns
                    INNER JOIN artistas
                    ON albuns.ref_id_artistas = id_artistas
                    INNER JOIN utilizadores
                    ON produtos.ref_id_utilizadores_vendedores = utilizadores.id_utilizadores
                    INNER JOIN encomendas ON produtos.ref_id_encomendas = encomendas.id_encomendas
                    WHERE encomendas.ref_id_utilizadores = " . $_SESSION["id_user"];

                        if (mysqli_stmt_prepare($stmt, $query)) {

                            /* execute the prepared statement */
                            mysqli_stmt_execute($stmt);

                            /* bind result variables */
                            mysqli_stmt_bind_result($stmt, $capa, $artista, $titulo, $nome, $apelido, $fperfil, $preco, $data, $id_encomenda);

                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) == 0) {
                                echo "<div class='col-12 py-5 mb-5'><h1>Ainda não efetuaste compras.</h1></div>";
                            } else {
                                ?>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Imagem</th>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Vendido por</th>
                                        <th scope="col">Preço</th>
                                        <th scope="col">Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while (mysqli_stmt_fetch($stmt)) {
                                        $phpdate = strtotime($data);
                                        $data = date('m-d-Y', $phpdate);
                                        ?>
                                        <tr>
                                            <th scope="row"><?= $id_encomenda ?></th>
                                            <td><img src="img/capas/<?= $capa ?>" class="miniatura"></td>
                                            <td><?= $artista . " — " . $titulo ?></td>
                                            <td><img class="img-fluid rounded-circle fotoperfilalbuns mr-2"
                                                     src='img/users/<?= $fperfil ?>'><?= $nome . " " . $apelido ?>
                                            </td>
                                            <td><?= $preco ?></td>
                                            <td><?= $data ?></td>
                                        </tr>
                                        <?php
                                    } ?>

                                    </tbody>
                                </table>
                                <?php
                            }


                        } else {
                            echo "Error: " . mysqli_error($link);
                        }

                        mysqli_stmt_close($stmt);
                        mysqli_close($link);

                        ?>


                    </div>
                </section>
            </div>
        </section>
    </main>
<?php } ?>