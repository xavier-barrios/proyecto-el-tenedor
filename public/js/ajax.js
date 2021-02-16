window.onload = function() {
    mostrar();
    var IDs = [];
}

function objetoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}


function mostrar() {
    var restaurantes = document.getElementById('restaurantes');
    var rol = document.getElementById('rol').value;
    var id_usuario = document.getElementById('id_usuario').value;
    var buscador = document.getElementById('searchCocina').value;
    var buscador2 = document.getElementById('searchPrecio').value;
    var ajax = new objetoAjax();
    var token = document.getElementById('token').getAttribute('content');
    // Busca la ruta read y que sea asyncrono
    ajax.open('POST', 'mostrar', true);
    var datasend = new FormData();
    datasend.append('filtro', buscador);
    datasend.append('filtro2', buscador2);
    datasend.append('_token', token);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(ajax.responseText);
            var tabla = '';
            tabla += '<div class="row contenidoCartas">';

            if (rol == 'admin') {
                tabla += '<div class="col-sm-12 col-md-6 col-lg-3 p-2">';
                tabla += '<div class="card d-flex text-black h-100 bg-cards">';
                tabla += '<div class="card-body">';
                tabla += '<form class="px-5 d-flex justify-content-center h-100" method="get" action="crear">'
                tabla += '<button class="btn" type="submit"><img class="card-img-top img-fluid mx-auto imgCard" src="img/add.png" alt="Card image cap"></img></button>';
                tabla += '</form>'
                tabla += '</div>';
                tabla += '</div>';
                tabla += '</div>';
            }
            for (let i = 0; i < respuesta.length; i++) {
                tabla += '<div class="col-sm-12 col-md-6 col-lg-3 p-2">';
                tabla += '<div class="card d-flex text-black bg-cards">';
                tabla += '<img class="card-img-top img-fluid mx-auto imgCard" style="width: 100%; height: 280px;" src="data:image/png;base64,' + respuesta[i].foto + '" alt="Card image cap"></img>';
                tabla += '<div class="card-body">';
                if (respuesta[i].id_restauranteMg != null && respuesta[i].id_usuarioMg != null && id_usuario == respuesta[i].id_usuarioMg) {
                    tabla += '<form class="w-auto m-2" method="POST" action="deleteMg/' + respuesta[i].id_restaurante + '"><input type="hidden" value="' + id_usuario + '" id="id_usuario" name="id_usuario"><span class="mg" type="submit"><button class="btn btn-success" type="sumbit" name="Enviar"><i class="fa fa-thumbs-up"></i></button></span></form>';
                } else {
                    tabla += '<form class="w-auto m-2 formMg" method="POST" action="mg/' + respuesta[i].id_restaurante + '"><input type="hidden" value="' + id_usuario + '" id="id_usuario" name="id_usuario"><span class="mg" type="submit"><button class="btn btn-primary" type="sumbit" name="Enviar"><i class="fa fa-thumbs-up"></i></button></span></form>';
                }
                tabla += '<h2 class="card-title text-truncate">' + respuesta[i].nombre + '</h2>';
                tabla += '<p class="card-text text-truncate"><b>Dirección:</b> ' + respuesta[i].ciudad + ', ' + respuesta[i].calle + ', ' + respuesta[i].cp + '</p>';
                tabla += '<p class="card-text text-truncate"><b>Tipo cocina:</b> ' + respuesta[i].tipo_cocina + '</p>';
                tabla += '<p class="card-text text-truncate"><b>Precio:</b> ' + respuesta[i].precio_medio + '€</p>';
                tabla += '</div>';

                if (rol == 'admin') {
                    tabla += '<div class="d-flex justify-content-center">';
                    tabla += '<form class="w-auto m-2" method="GET" action="modificar/' + respuesta[i].id_restaurante + '"><button class="btn btn-success" type="sumbit">Modificar</button></form>';
                    tabla += '<form class="w-auto m-2" method="GET" action="baja/' + respuesta[i].id_restaurante + '"> <button class="btn btn-danger" type="sumbit">Baja</button></form>';
                    tabla += '</div>';
                }

                tabla += '</div>';
                tabla += '</div>';
            }
            tabla += '</div>';
        }
        restaurantes.innerHTML = tabla;
    }
    ajax.send(datasend);
}