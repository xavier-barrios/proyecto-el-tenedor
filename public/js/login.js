$(function() {

    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });

});

function validarPass() {
    //Recogemos los inputs y sus valores.
    passStr = document.getElementById('passwordRegister').value;
    valPassStr = document.getElementById('confirm-password').value;
    pass = document.getElementById('passwordRegister');
    valPass = document.getElementById('confirm-password');
    msg = document.getElementById('msg');
    msgLogin = document.getElementById('msgLogin');

    //Comprobamos que el valor de los dos inputs sean iguales y que no esten vacios.
    if (passStr == valPassStr && passStr != "" && valPassStr != "") {
        pass.style.borderColor = "transparent";
        pass.style.borderColor = "transparent";
        msgLogin.innerHTML = "Usuario creado satisfactoriamente.";
        return true;
    } else if (passStr == "" || valPassStr == "") {
        //Entrará en este if en el caso de que los campos estén vacíos.
        msg.innerHTML = "Campos vacios.";
        msg.style.color = "red";
        pass.style.borderColor = "red";
        valPass.style.borderColor = "red";
        return false;
    } else {
        //Entrará en este if como recurso final.
        msg.innerHTML = "Les contrasenyes no coincideixen.";
        msg.style.color = "red";
        pass.style.borderColor = "red";
        valPass.style.borderColor = "red";
        return false;
    }
}