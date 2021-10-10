<main class="bg-light">
    <section class="container pt-5 pb-3">
        <a class="text-desativo" href="conta.php">Conta</a>
        <i class="fas fa-chevron-right px-2 iconedestivo"></i>
        <span>Guardados</span>
    </section>
    <section class="container pb-4">
        <h3 id="guardados" class="pb-3">Guardados</h3>
    </section>
    <section class="container">
        <div class="row">
            <section class="container pb-3">
                <div class="row">
                    <?php
                    // We need the function!
                    require_once("connections/connection.php");

                    // Create a new DB connection
                    $link = new_db_connection();

                    /* create a prepared statement */
                    $stmt = mysqli_stmt_init($link);

                    $query = "SELECT artistas.nome, albuns.titulo, produtos.preco, produtos.img_capa, produtos.id_produtos, guardado, ref_id_utilizadores_vendedores, utilizadores.nome, utilizadores.apelido, fotoperfil FROM artistas
INNER JOIN albuns
ON artistas.id_artistas = albuns.ref_id_artistas
INNER JOIN produtos
ON albuns.id_albuns = produtos.ref_id_albuns
INNER JOIN guardados
ON produtos.id_produtos = guardados.ref_id_produtos
LEFT JOIN utilizadores
ON utilizadores.id_utilizadores = ref_id_utilizadores_vendedores

WHERE guardados.ref_id_utilizadores = " . $_SESSION["id_user"] . " AND guardados.guardado = 1 AND ativo = 1 AND produtos.ref_id_encomendas IS NULL ORDER BY albuns.titulo";

                    if (mysqli_stmt_prepare($stmt, $query)) {

                        /* execute the prepared statement */
                        mysqli_stmt_execute($stmt);

                        /* bind result variables */
                        mysqli_stmt_bind_result($stmt, $artista, $titulo, $preco, $capa, $id, $guardado, $vendedor, $nome, $apelido, $fperfil);

                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) == 0) {
                            echo "<div class='col-12 py-5 mb-5'><h1>Não tens álbuns guardados.</h1></div>";
                        } else {
                            /* fetch values */
                            while (mysqli_stmt_fetch($stmt)) {
                                include "components/cp_guardados_album.php";
                            }
                        }




                        /* close statement */
                        mysqli_stmt_close($stmt);

                        /* close connection */
                        mysqli_close($link);
                    } else {
                        echo "Error: " . mysqli_error($link);
                    }

                    ?>
                </div>
            </section>
        </div>
    </section>
</main>
