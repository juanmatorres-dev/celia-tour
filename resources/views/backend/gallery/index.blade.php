@extends('layouts.backend')
@section('headExtension')
<!--SCRIPT PARA CERRAR LAS MODALES-->
<script src="{{url('js/closeModals/close.js')}}"></script>    
@endsection
@section('modal')
    <!-- VENTANA MODAL PARA AÑADIR GALERIA -->
    <div class="window" id="galeria" style="display: none;">
        <span class="titleModal col100">Insertar Galeria</span>
        <button id="closeModalWindowButton" class="closeModal" >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
               <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="addVideoContent col100 xlMarginTop">
            <form action="/gallery" method="post" class="col60" enctype="multipart/form-data">
                @csrf
                <label class="col100">Titulo<span class="req">*<span></label>
                <input type='text' name='titleadd' class="col100">
                <label class="col100 sMarginTop">Descripción<span class="req">*<span></label>
                <textarea name="descriptionadd" class="col100" style="height:170px"></textarea>
                <input type="submit" value="Añadir Galeria" class="col100 xlMarginTop">
            </form>
        </div>
    </div>

    <!-- VENTANA MODAL PARA MODIFICAR LAS GALERIAS -->
    <div class="window"  id="editG" style="display: none;">
        <span class="titleModal col100">Editar Galeria</span>
        <button id="closeModalWindowButton" class="closeModal">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
           </svg>
        </button>
        <div class="galleryContent col100 xlMarginTop">
            <div class="col100">
                <label class="col100">Titulo<span class="req">*<span></label>
                <input type='text' name='title' class="col100">
                <label class="col100 sMarginTop">Descripción<span class="req">*<span></label>
                <textarea name="description" class="col100" style="height:170px"></textarea>
            </div>    
            <div class="xlMarginTop col100">
                <input type="submit" form="updateResource" name="edit" value="Guardar Cambios" id="btnUpdate">
            </div>   
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR ESCENAS -->
    <div class="window" id="confirmDelete" style="display: none;">
    <span class="titleModal col100">¿Eliminar galeria?</span>
    <button id="closeModalWindowButton" class="closeModal" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
           <polygon points="28,22.398 19.594,14 28,5.602 22.398,0 14,8.402 5.598,0 0,5.602 8.398,14 0,22.398 5.598,28 14,19.598 22.398,28"/>
       </svg>
    </button>
    <div class="confirmDeleteScene col100 xlMarginTop" style="margin-left: 3.8%">
        <button id="aceptDelete" class="delete">Aceptar</button>
        <button id="cancelDelete" >Cancelar</button>
    </div>
    
</div>
@endsection
@section('content')
@if($errors->any())
<div class="alert alert-warning" role="alert">
    <p style="color: red;">No se pudo crear la galeria por los siguientes motivos:</p>
   @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
  @endforeach
</div>
@endif

<!-- TITULO -->
<div id="title" class="col80 xlMarginBottom">
    <span>GALERIAS</span>
</div>

<!-- BOTON AGREGAR -->   
<div id="contentbutton" class="col20 xlMarginBottom">   
    <button class="right round col45" id="btngaleria">
        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 25.021 25.021" >
            <polygon points="25.021,16.159 16.34,16.159 16.34,25.021 8.787,25.021 8.787,16.159 0,16.159 0,8.605 
                    8.787,8.605 8.787,0 16.34,0 16.34,8.605 25.021,8.605" fill="#fff"/>
        </svg>                                        
    </button>
</div>

<div id="content" class="col100 centerH">
    <div class="col90">
        <div class="col100 mPaddingLeft mPaddingRight mPaddingBottom">
            <div class="col20"><strong>Titulo</strong></div>
            <div class="col20"><strong>Descripción</strong></div>
        </div>

        @foreach ($gallery as $g )
            <div class="col100 mPaddingLeft mPaddingRight sPaddingTop">
                <div class="col20">{{$g->title}}</div>
                <div class="col50">{{$g->description}}</div>
                <div class="col10"><button class="btnModificarG"id="{{$g->id}}">Editar</button></div> 
                <div class="col10"><button onclick="window.location.href='gallery/{{$g->id}}/edit_resources'">Recursos</button></div> 
                <div class="col10"><button id="{{$g->id}}" class="delete">Eliminar</button></div>
            </div>
        @endforeach
    </div>
</div>


<script>

//FUNCIÓN PARA ELIMINAR A TRAVÉS DE AJAX
//.delete es el nombre de la clase
//peticion_http es el objeto que creamos de Ajax
 $(".delete").click(function(){
    id = $(this).attr("id");
    elementoD = $(this);
        $("#modalWindow").css("display", "block");
        $("#confirmDelete").css("display", "block");
        $("#aceptDelete").click(function(){
            $("#confirmDelete").css("display", "none");
            $("#modalWindow").css("display", "none");
            console.log(elementoD)
            $.get('http://celia-tour.test/gallery/delete/'+id, function(respuesta){
            $(elementoD).parent().parent().remove();
            $('.previewResource').empty();
            });
        });
        $("#cancelDelete").click(function(){
            $("#confirmDelete").css("display", "none");
            $("#modalWindow").css("display", "none");
        });
    });

//FUNCIÓN PARA ABRIR LA VENTANA MODAL DE AÑADIR GALERIA
$("#btngaleria").click(function(){
    $("#modalWindow").css("display", "block");
    $("#galeria").css("display", "block");
});

//FUNCIÓN PARA RECUPERAR TODOS LOS DATOS EN OBJEROS:
$(document).ready(function(){
    var data = @JSON($gallery);
    console.log(data);
 //ACCIÓN PARA CERRAR LA MODAL 
 $('.closeModal').click(function(){
            $('.previewResource').empty();
            $("#modalWindow").css("display", "none");
            $("#editG").css("display", "none");
            $("#galeria").css("display", "none");
        });
//FUNCIÓN PARA ABRIR LA VENTANA MODAL DE MOFICIAR GALERIA
$(".btnModificarG").click(function(){
    for(var i=0; i<data.length; i++){
    if(data[i].id==$(this).attr("id")){
        //alert(data[i].id)
        id = data[i].id;
        $('.galleryContent input[name="title"]').val(data[i].title);
        $('textarea[name="description"]').val(data[i].description);
        $("#modalWindow").css("display", "block");
        $("#editG").css("display", "block");
    }
    }
//FUNCIÓN PARA ACTUALIZAR
$("#btnUpdate").click(function(){
    var route = "{{ route('gallery.update', 'req_id') }}".replace('req_id', id);
    $.ajax({
       url: route,
       type: 'patch',
       data: {
        "_token": "{{ csrf_token() }}",
        "title":$('.galleryContent input[name="title"]').val(),
        "description":$('textarea[name="description"]').val(),
       },
       success:function(result){
         if(result.status == true){
            window.location.href="{{route('gallery.index')}}";
         }else{
            alert("ERROR")
         }
       }
    });
});
});
});
</script>
@endsection