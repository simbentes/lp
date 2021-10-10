<main class="bg-light">
    <section class="container py-5 mt-5">
        <!-- FORM VENDER-->
        <section class="m-auto text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="auto" fill="currentColor"
                 viewBox="0 0 1024 445.8">
                <g>
                    <path d="M458.5,349.6v96.2H0V0h114.6v349.6H458.5z"/>
                    <path d="M1024,163.7c0,99.3-69.4,163-170.7,163H617.7v119.1H503.1V0h350.2C954.6,0,1024,64.3,1024,163.7z M909.4,163.7
		c0-67.5-53.5-67.5-87.9-67.5H617.7v134.4h203.8C855.9,230.5,909.4,230.5,909.4,163.7z"/>
                </g>
            </svg>
            <h5 class="mt-4">Repor a tua palavra-passe</h5>
        </section>
        <form action="scripts/sc_nova_pass.php" method="post">
            <div class="row justify-content-center py-5">
                <div class="col-6">
                    <div>
                        <?php
                        if (isset($_GET["msg"])) {
                            $msg_show = true;
                            switch ($_GET["msg"]) {
                                case 0:
                                    $message = "Passwords são diferentes";
                                    $class = "alert-warning";
                                    break;
                                case 1:
                                    $message = "Ocorreu um erro.";
                                    $class = "alert-warning";
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


                        if (isset($_GET["selector"]) && isset($_GET["token"])) {

                            $_SESSION["selector"] = $_GET["selector"];
                            $_SESSION["token"] = $_GET["token"];
                        } else {
                            header("Location: index.php");
                        }


                        ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="password">Nova Password</label>
                            <input type="password" name="password" class="form-control forminfo" id="password"
                                   minlength="6" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password2">Confirmar Password<span id="msg_erro"
                                                                           class="pl-3 small"></span></label>
                            <input type="password" name="password2" class="form-control forminfo" id="password2"
                                   minlength="6" required>
                        </div>
                    </div>
                    <div class="form-group pt-4">
                        <input class="btn btn-inform btn-block text-uppercase" type="submit" name="submit"
                               value="repor password">
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>