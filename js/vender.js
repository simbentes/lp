var selectInter = document.getElementById("interprete");
selectInter.addEventListener("change", ativarInput);

var selectAlbum = document.getElementById("txtAlbum");


var selectEditora = document.getElementById("editora");


function ativarInput() {
    document.getElementById("sectionAlbum").style.display = "block";
    var opcao = selectInter.value
    if (opcao == "novoartista") {
        document.getElementById("novoInterprete").style.display = "block";
        document.getElementById("outrointerprete").value = "";
        document.getElementById("outrointerprete").disabled = false;
        document.getElementById("outrointerprete").focus()
        selectAlbum.style.display = "none";
        document.getElementById("novoAlbum").style.display = "block";
    } else {
        document.getElementById("novoInterprete").style.display = "none";
        document.getElementById("outrointerprete").disabled = true;
        selectAlbum.style.display = "block";
        document.getElementById("novoAlbum").style.display = "none";
    }

}


selectAlbum.addEventListener("change", function () {
    var opcaoAlbum = selectAlbum.value

    if (opcaoAlbum == "novoalbum") {
        document.getElementById("novoAlbum").style.display = "block";
        document.getElementById("tituloalbum").value = "";
        document.getElementById("tituloalbum").focus()
    } else {
        document.getElementById("novoAlbum").style.display = "none";
    }
});


selectEditora.addEventListener("change", function () {
    var opcaoAlbum = selectEditora.value

    if (opcaoAlbum == "Selecionar") {
        document.getElementById("outraeditora").disabled = false;
    } else {
        document.getElementById("outraeditora").disabled = true;
    }
});

document.getElementById("outraeditora").addEventListener("keyup", function () {
    if (document.getElementById("outraeditora").value != "") {
        document.getElementById("editora").disabled = true;
    } else {
        document.getElementById("editora").disabled = false;

    }
});




