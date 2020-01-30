$().ready(function(){
    $('#addScene').click(function(e){
        //Compruebo que no haya ya un icono puesto
        var iconoDisplay = $('#zoneicon').css('display');
        //Si no hay un icono, lo 'coloco'
        if(iconoDisplay == 'none'){
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var top = mousey - posicion.top -12;
            var left = mousex - posicion.left -12;
            $('#zoneicon').css('top' , top);
            $('#zoneicon').css('left', left);
            $('#zoneicon').css('display', 'block');
            $('#top').attr('value', top);
            $('#left').attr('value', left);
            $('#menuModalAddScene').css('display', 'block');
        }else{
            //Si ya hay un icono, lo muevo
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var top = mousey - posicion.top -12;
            var left = mousex - posicion.left -12;
            $('#zoneicon').css('top' , top);
            $('#zoneicon').css('left', left);
            $('#top').attr('value', top);
            $('#left').attr('value', left);
        }
    });
    $(".scenepoint").hover(function(){
        $(this).attr('src', $('#urlhover').val());
    }, function(){
        $(this).attr('src', $('#url').val());
    });



    /*$('#saveScene').click(function(){
        var formData = new FormData($('#formAddScene'));
        var rute = "{{ route('scene.store') }}";
        $.ajax({
            url: rute,
            type: 'POST',
            data: formData,
            /*data: {
                "_token": "{{ csrf_token() }}",
                "name": $('#name').val(),
                "image360":$('#sceneImage'),
                "top": $('#top').val(),
                "left": $('#left').val(),
                "id_zone": $('#id_zone').val(),
            },
            success:function(result){                   
                //Obtener el resultado de la accion
                if(result['status']){                        
                    alert("Escena guardada correctamente");
                }else{
                    alert("Error al guardar");
                }
            }
        });
    });*/

    /*$('#formAddScene').on('submit',(function(e) {
        e.preventDefault();
        var rute = "{{ route('scene.store') }}";
        $.ajax({
            url: rute,
            type: "POST",
            data: new FormData(this),
            success:function(result){                   
                //Obtener el resultado de la accion
                if(result['status']){                        
                    alert("Escena guardada correctamente");
                }else{
                    alert("Error al guardar");
                }
            }
        });
    }));*/

});