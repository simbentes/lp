<div id="album<?= $id ?>" class="col-sm-6 col-lg-4 col-xl-3 mb-5">
    <div class="card h-100">
        <div class="position-relative">
            <a href="album_info.php?item=<?= $id ?>">
                <div class="quadrado">
                    <div style="background-image: url('img/capas/<?= $capa ?>')"
                         class="card-img-top">
                    </div>
                </div>
            </a>
        </div>
        <div class="card-body">
            <div class="row no-gutters px-2 justify-content-between align-items-center mt-1">
                <div class="col-auto">
                    <div class="text-pequeno"><?= $artista ?></div>
                    <p class="mb-0 h4 titulocard">
                        <strong>
                            <?= $titulo ?>
                        </strong>
                    </p>
                </div>
            </div>
            <div class="row justify-content-between align-items-center no-gutters">
                <div class="col-auto">
                    <p class="h5 mb-2 ml-2"><?= $preco . "€" ?></p>
                </div>
            </div>
                <div class="d-flex justify-content-between">
                    <a href="editar-album-info.php?item=<?= $id ?>"
                       class="btn btn-editar btn-block h-100 text-uppercase py-2">
                        Editar
                        <i class="fa fa-angle-right pl-1"></i>
                    </a>
                </div>


        </div>
    </div>
</div>