
    <option selected disabled>Selecionar</option>
    <?php
    // We need the function!
    require_once("../connections/connection.php");


    $q = $_GET["q"];

    // Create a new DB connection
    $link = new_db_connection();

    /* create a prepared statement */
    $stmt = mysqli_stmt_init($link);

    $query = "SELECT id_albuns, titulo FROM albuns INNER JOIN artistas ON albuns.ref_id_artistas = artistas.id_artistas WHERE artistas.id_artistas = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {

        // Bind variables by type to each parameter
        mysqli_stmt_bind_param($stmt, 's', $q);

        /* execute the prepared statement */
        mysqli_stmt_execute($stmt);

        /* bind result variables */
        mysqli_stmt_bind_result($stmt, $id_albuns, $titulo);

        /* store result */
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            /* fetch values */
            while (mysqli_stmt_fetch($stmt)) {
                echo "<option value='$id_albuns'>$titulo</option>";
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

    <option id="novoalbum" value="novoalbum" class="font-weight-bolder">Novo Álbum</option>
