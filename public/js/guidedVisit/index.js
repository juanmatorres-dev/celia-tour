$(function() {

    function closeModal(){
        $("#modalWindow").css('display', 'none');
        $("#newGuidedVisit").css('display', 'none');
        $("#updateGuidedVisit").css('display', 'none');
    }
    $(".closeModal").click(closeModal);

    // Boton que elimina una fila
    function remove(){
        var isDelte = confirm("¿Desea eliminar esta visita guiada?");
        if(isDelte){
            var domElement = $(this).parent().parent();
            var id = $(domElement).attr("id");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){ 
                    if (xhttp.responseText == 1) {
                            $(domElement).remove();
                    } else {
                        alert("Algo fallo!");
                    }
                }
            }
            var direccion = "http://celia-tour.test/guidedVisit/delete/"+id;
            xhttp.open("GET", direccion, true);
            xhttp.send();
        }
    }

    // Abre la modal y prepara la ventana
    function openUpdate(){
        $('#modalWindow').css('display', 'block');
        $('#updateGuidedVisit').css('display', 'block');
        $('#nameValueUpdate').val('');
        $('#descriptionValueUpdate').val('');
        $('#fileValueUpdate').val('');

        // Se coloca el action con la ruta correctamente
        var domElement = $(this).parent().parent();
        var id = $(domElement).attr("id");
        var url = 'http://celia-tour.test/guidedVisit/'+id;
        $('#formUpdate').attr('action', url);
    }

    // Eventos iniciales ------------------------------------
    // Boton delete
    $(".btn-delete").click(remove);

    // Boton update
    $('.btn-update').click(openUpdate)


    // Muestra la ventana modal y el formulario para insertar una visita guiada
    $('#btn-add').click(function(){
        $('#modalWindow').css('display', 'block');
        $('#newGuidedVisit').css('display', 'block');
    })

    $('#btn-saveNew').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formadd input[name="_token"]').val());
        dataForm.append('name', $('#nameValue').val());
        dataForm.append('description', $('#descriptionValue').val());
        dataForm.append('file_preview', $('#fileValue')[0].files[0]);

        $.ajax({
            url: $("#formadd").attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){

        var element = `<div id="${data.guidedVisit.id}" style="clear: both;">
                <div class="col5">${data.guidedVisit.id}</div>
                <div class="col15">${data.guidedVisit.name}</div>
                <div class="col30">${data.guidedVisit.description}</div>
                <div class="col20"><img src="/img/guidedVisit/miniatures/${data.guidedVisit.file_preview}"></div>
                <div class="col10"><button onclick="window.location.href='${data.route})'">Escenas</button></div>
                <div class="col10"><button class="btn-update">Modificar</button></div>
                <div class="col10"><button class="btn-delete">Eliminar</button></div>
            </div>`;

            $("#tableContent").append(element);
            $('#modalWindow').css('display', 'none'); 
            $('#newGuidedVisit').css('display', 'none');
            $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            $('.btn-update').click(openUpdate);
            $('.btn-delete').click(remove);
        })

    }); // Fin boton acept

    $('#btn-saveUpdate').click(function(){

        dataForm = new FormData();
        dataForm.append('_token', $('#formUpdate input[name="_token"]').val());
        dataForm.append('name', $('#nameValueUpdate').val());
        dataForm.append('description', $('#descriptionValueUpdate').val());
        dataForm.append('file_preview', $('#fileValueUpdate')[0].files[0]);

        $.ajax({
            url: $("#formUpdate").attr('action'),
            type: 'post',
            data: dataForm,
            contentType: false,
            processData: false,
        }).done(function(data){
            // Modifica los valores de la tabla
            var children = $(`#${data.guidedVisit.id}`).children();
            $(children[0]).html(data.guidedVisit.id);
            $(children[1]).html(data.guidedVisit.name);
            $(children[2]).html(data.guidedVisit.description);
            $(`#${data.guidedVisit.id} img`).attr('src', `/img/guidedVisit/miniatures/${data.guidedVisit.file_preview}`);
            $(`#${data.guidedVisit.id} button[onclick]`).attr('onclick', `window.location.href='${data.route}`)

            $('#modalWindow').css('display', 'none'); 
            $('#updateGuidedVisit').css('display', 'none');
            $('.btn-update').unbind('click');
            $('.btn-delete').unbind('click');
            $('.btn-update').click(openUpdate);
            $('.btn-delete').click(remove);
        })

    });

}); // Fin metodo ejecutado despues de cargar html