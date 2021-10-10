<?php
// We need the function!
require_once("connections/connection.php");

// Create a new DB connection
$link = new_db_connection();

/* create a prepared statement */
$stmt = mysqli_stmt_init($link);

//posso concatenar, visto que o parametro não foi colocado pelo user
$query = "SELECT nome, apelido, data_nascimento,telemovel,nif, rua, codigo_postal, cidade, ref_id_paises
FROM `utilizadores`
LEFT JOIN moradas
ON utilizadores.ref_id_moradas = moradas.id_moradas
WHERE id_utilizadores = " . $_SESSION["id_user"];

if (mysqli_stmt_prepare($stmt, $query)) {

    /* execute the prepared statement */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $nome, $apelido, $nascimento, $tel, $nif, $rua, $postal, $cidade, $refidpais);


    if (mysqli_stmt_fetch($stmt)) {
        ?>
        <main class="bg-light pb-4">
            <section class="container pt-5 pb-3 text-pequeno">
                <a class="text-desativo" href="conta.php">Conta</a>
                <i class="fas fa-chevron-right px-2 iconedestivo"></i>
                <span>Informações Pessoais</span>
            </section>
            <section class="container mb-5">
                <h3 class="pb-4">Informações Pessoais</h3>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div>
                            <?php
                            if (isset($_GET["msg"])) {
                                $msg_show = true;
                                switch ($_GET["msg"]) {
                                    case 0:
                                        $message = "Password errada";
                                        $class = "alert-danger";
                                        break;
                                    case 1:
                                        $message = "Alterações efetuadas.";
                                        $class = "alert-success";
                                        break;
                                    case 2:
                                        $message = "Morada mal preenchida.";
                                        $class = "alert-danger";
                                        break;
                                    case 3:
                                        $message = "Informações mal preenchidas.";
                                        $class = "alert-danger";
                                        break;
                                    case 4:
                                        $message = "Passwords não coincidem.";
                                        $class = "alert-danger";
                                        break;
                                    case 5:
                                        $message = "Informações e password alteradas.";
                                        $class = "alert-success";
                                        break;
                                    case 6:
                                        $message = "Nova password igual à antiga.";
                                        $class = "alert-danger";
                                        break;
                                    default:
                                        $msg_show = false;
                                }

                                echo "<div class=\"alert $class alert-dismissible fade show\" role=\"alert\">
" . $message . "
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
                                if ($msg_show) {
                                    echo '<script>window.onload=function (){$(\'.alert\').alert();}</script>';
                                }
                            }
                            ?>
                        </div>

                        <form action="scripts/sc_alterar_info_conta.php" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-center pb-4 align-items-center">
                                <div class="col-auto">
                                    <div class="fotoperfil rounded-circle"><img class="imagemtamanho rounded-circle"
                                                                                src="img/users/<?= $_SESSION["fperfil"] ?>"
                                                                                alt="" id="output">
                                        <div class="overlayinfo rounded-circle">
                                            <label for="imgInp" class="botaoupload">
                                                <i class="fas fa-camera fa-1emeio"></i>
                                            </label>
                                            <input type="file"
                                                   id="imgInp" name="foto"
                                                   accept="image/png, image/jpeg" onchange="loadFile(event)">
                                        </div>
                                    </div>
                                    <script>
                                        var loadFile = function (event) {
                                            var output = document.getElementById('output');
                                            output.src = URL.createObjectURL(event.target.files[0]);
                                            output.onload = function () {
                                                URL.revokeObjectURL(output.src) // free memory
                                            }
                                            document.getElementById('maquina').classList.add("d-none");
                                            document.getElementById('output').classList.remove("d-none");
                                        };
                                    </script>
                                </div>
                                <a class="col-auto">
                                    <h4 class="mb-1"><?= $_SESSION["nome"] ?></h4>
                                    <div class="h4"><span
                                                class="badge badge-primary text-white mr-3"><img
                                                    src="img/lp.svg" class="pb-1" height="16"></span></div>
                                </a>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="titulo">Nome</label>
                                    <input type="text" name="nome" class="form-control forminfo" id="nome"
                                           value="<?= $nome ?>"
                                           required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="titulo">Apelido</label>
                                    <input type="text" name="apelido" class="form-control forminfo" id="apelido"
                                           value="<?= $apelido ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control forminfo" id="nome"
                                       value="<?= $_SESSION["email"] ?>" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="birthday">Data de Nascimento</label>
                                    <input type="date" name="nascimento" class="form-control forminfo" id="birthday"
                                           max="2008-12-31" value="<?= $nascimento ?>" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="telemovel">Telemóvel</label>
                                    <input type="tel" name="tel" id="telemovel" value="<?= $tel ?>"
                                           class="form-control forminfo" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="nif">NIF</label>
                                    <input type="text" name="nif" id="nif" value="<?= $nif ?>"
                                           class="form-control forminfo"
                                           required>
                                </div>
                            </div>
                            <hr class="my-3">
                            <h5>Morada</h5>
                            <div id="moradaGrupo">
                                <div class="form-group">
                                    <label for="email">Rua</label>
                                    <input type="text" name="rua" class="form-control forminfo" id="rua"
                                           value="<?= $rua ?>">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label for="codigopostal">Código Postal</label>
                                        <input type="text" name="codigopostal" class="form-control forminfo"
                                               id="codigopostal"
                                               value="<?= $postal ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="cidade">Localidade</label>
                                        <input type="text" name="cidade" class="form-control forminfo" id="cidade"
                                               value="<?= $cidade ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="pais">País</label>
                                        <select name="pais">
                                            <option value="">Selecionar</option>
                                            <?php

                                            $query = "SELECT id_paises, nome FROM paises";

                                            if (mysqli_stmt_prepare($stmt, $query)) {

                                                /* execute the prepared statement */
                                                mysqli_stmt_execute($stmt);

                                                /* bind result variables */
                                                mysqli_stmt_bind_result($stmt, $id_pais, $pais);


                                                /* fetch values */
                                                while (mysqli_stmt_fetch($stmt)) {
                                                    $selected = "";
                                                    if ($id_pais == $refidpais) {
                                                        $selected = "selected";
                                                    }
                                                    echo "<option value='$id_pais' $selected >$pais</option>";
                                                }

                                            } else {
                                                echo "Error: " . mysqli_error($link);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                            <h5>Alterar Password
                                <div class="btn btn-outline-light" id="btnPassword">Alterar</div>
                            </h5>
                            <div id="passwordGrupo" style="display: none">
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label for="password">Password</label>
                                        <input type="password" name="novapassword" class="form-control forminfo"
                                               id="password"
                                               minlength="6">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="password2">Confirmar Password<span id="msg_erro"
                                                                                       class="pl-3 small"></span></label>
                                        <input type="password" name="passwordrepete" class="form-control forminfo"
                                               id="password2"
                                               minlength="6">
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-inform mt-3 py-3 px-5" data-toggle="modal"
                                        data-target="#exampleModal">
                                    GUARDAR
                                </button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content p-0">
                                        <div class="modal-body text-center text-dark">
                                            <h5 class="my-4">Digita a tua palavra-passe.</h5>
                                            <input type="password" name="password" class="form-control forminfo"
                                                   id="nome"
                                                   required>
                                            <p class="py-3 m-0">Não partilhes a tua palavra-passe com ninguém.</p>
                                        </div>
                                        <div class="modal-footer p-0">
                                            <input type="submit" name="submit" class="btn botaomodal py-3 m-0 btn-block"
                                                   value="CONFIRMAR">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
        <?php
    } else {
        header("Location: index.php");
    }

    /* close statement */
    mysqli_stmt_close($stmt);

    /* close connection */
    mysqli_close($link);
} else {
    echo "Error: " . mysqli_error($link);
}
?>
