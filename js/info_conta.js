var on = false


//verifica se a password está correta

document.getElementById("password2").addEventListener("keyup", verificarPass)

function verificarPass() {
    //Store the password field objects into variables ...
    var pass1 = document.getElementById("password")
    var pass2 = document.getElementById("password2")

    //Store the Confimation Message Object ...
    var mensagem = document.getElementById("msg_erro")
    //Set the colors we will be using ...
    //Compare the values in the password field
    //and the confirmation field
    if (pass2.value != "") {
        if (pass1.value == pass2.value) {
            console.log("iguais")
            mensagem.innerHTML = "Passwords correspondem";
            pass2.style.border = "solid 2px green"
        } else {
            pass2.style.border = "solid 2px red"
            mensagem.innerHTML = "Passwords não correspondem"
        }
    } else {
        pass2.style.border = "none"
        mensagem.innerHTML = ""
    }

}

document.getElementById("btnPassword").addEventListener("click", abrirMorada)

function abrirMorada() {
    if (on) {
        document.getElementById("passwordGrupo").style.display = "none";
        document.getElementById("btnPassword").innerHTML = "Alterar"
        document.getElementById("password").value = "";
        document.getElementById("password2").value = "";
        on = false
    } else {
        document.getElementById("btnPassword").innerHTML = "Cancelar"
        document.getElementById("passwordGrupo").style.display = "block";
        on = true

    }

}