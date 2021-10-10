<main class="bg-light">
    <section class="container pb-5">
        <div class="py-5">
            <h3>Conta</h3>
            <p><strong><?= $_SESSION["nome"] . ", </strong>" . $_SESSION["email"] ?></p>
        </div>
        <!--CARDS PARA PAGINAS-->
        <div class="row">
            <div class="col-6 col-md-4 px-2">
                <a class="defcard text-center text-md-left d-flex align-items-center justify-content-center justify-content-md-start"
                   href="informacoes.php">
                    <div>
                        <i class="far fa-user fa-2x mb-3 iconedegrade"></i>
                        <h6>Informações pessoais<i class="fas fa-chevron-right pl-1 d-none d-md-inline"></i></h6>
                        <p class="d-none d-md-block">Forneça informações pessoais e como podemos entrar em contacto
                            consigo</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 px-2">
                <a class="defcard text-center text-md-left d-flex align-items-center justify-content-center justify-content-md-start"
                   href="guardados.php">
                    <div>
                        <i class="far fa-heart fa-2x mb-3 iconedegrade"></i>
                        <h6>Guardados<i class="fas fa-chevron-right pl-1 d-none d-md-inline"></i></h6>
                        <p class="d-none d-md-block">Veja e altere os produtos que guardou e seja rápido, o produto pode
                            sair</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 px-2">
                <a class="defcard text-center text-md-left d-flex align-items-center justify-content-center justify-content-md-start"
                   href="os-meus-anuncios.php">
                    <div>
                        <i class="fas fa-store fa-2x mb-3 iconedegrade"></i>
                        <h6>Os meus anúncios<i class="fas fa-chevron-right pl-1 d-none d-md-inline"></i></h6>
                        <p class="d-none d-md-block">Verifique os seus anúncios e vendas. Edite as informações ou
                            remova-o.</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 px-2">
                <a class="defcard text-center text-md-left d-flex align-items-center justify-content-center justify-content-md-start"
                   href="historico-compras.php">
                    <div>
                        <i class="far fa-money-bill-alt fa-2x mb-3 iconedegrade"></i>
                        <h6>Histórico de compras<i class="fas fa-chevron-right pl-1 d-none d-md-inline"></i></h6>
                        <p class="d-none d-md-block">Verifique as compras que já efetuou no nosso website. Esparamos por
                            mais</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 px-2">
                <a class="defcard text-center text-md-left d-flex align-items-center justify-content-center justify-content-md-start"
                   href="scripts/sc_logout.php">
                    <div>
                        <i class="fas fa-sign-out-alt fa-2x mb-3 iconedegrade"></i>
                        <h6>Terminar sessão<i class="fas fa-chevron-right pl-1 d-none d-md-inline"></i></h6>
                        <p class="d-none d-md-block">Esperemos que volte brevemente. A um regresso rápido.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>
