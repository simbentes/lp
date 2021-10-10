<main class="bg-light">
    <section class="container container-lg-fluid meucontainer">
        <div class="row no-gutters justify-content-between">
            <div class="col-12 pt-5 mt-5 mt-md-0 pt-md-4 mt-1">
                <div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6 col-lg-5 mt-2 mt-md-0 pb-3">
                            <input type="text" id="search-bar" name="pesquisa"
                                   class="form-control forminfo barrapesquisa pr-3"
                                   placeholder="Pesquisar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                 class="search-icon" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </div>
                        <div class="col-12 mt-2 mt-md-0 text-center">
                            Género
                            <select id="estilos">
                                <option value="">Todos</option>
                                <?php
                                require_once "connections/connection.php";
                                // Create a new DB connection
                                $link = new_db_connection();

                                /* create a prepared statement */
                                $stmt = mysqli_stmt_init($link);
                                // só quero os estilos que tenham albuns...
                                $query = "SELECT id_estilos, tipo, COUNT(id_estilos)
FROM `estilos`
INNER JOIN estilos_has_albuns
ON id_estilos = estilos_has_albuns.ref_id_estilos
INNER JOIN albuns
ON estilos_has_albuns.ref_id_albuns = id_albuns
INNER JOIN produtos
ON albuns.id_albuns = produtos.ref_id_albuns
INNER JOIN utilizadores
ON produtos.ref_id_utilizadores_vendedores = utilizadores.id_utilizadores
WHERE estilos_has_albuns.ref_id_estilos IS NOT NULL AND ativo = 1 AND produtos.ref_id_encomendas IS NULL
GROUP BY id_estilos
ORDER BY tipo";

                                if (mysqli_stmt_prepare($stmt, $query)) {

                                    /* execute the prepared statement */
                                    mysqli_stmt_execute($stmt);

                                    /* bind result variables */
                                    mysqli_stmt_bind_result($stmt, $id_estilos, $estilos, $num);

                                    /* fetch values */
                                    while (mysqli_stmt_fetch($stmt)) {
                                        echo "<option value='$id_estilos'>$estilos <small>(" . $num . ")</small></option>";
                                    }

                                } else {
                                    echo "Error: " . mysqli_error($link);
                                }

                                mysqli_stmt_close($stmt);
                                mysqli_close($link);
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <!-- GRID COM CARDS DO PRODUTOS -->
                <div id="albuns" class="row">

                </div>
            </div>
        </div>
    </section>
</main>
