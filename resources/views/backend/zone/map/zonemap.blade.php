<!--
Vista a la que se llega a través de la función 'map' del ZoneController.
zone/{id}/zonemap
Muestra el mapa de la zona con las escenas que esta tenga.
El id de la escena se encuenta en el id de cada punto del mapa el cual
está formado de la siguiente forma: scene{id_scene}.
-->

@isset($zones)
    
<div class="closeModalButton">
   <img src="{{ url('img/icons/close.png') }}" alt="close" width="100%">
</div>
   <div id="changeZone" style="position: absolute">
    <div id="buttonsFloorCont" class="col100 xlMarginBottom">
        <div id="floorUp">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32">
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#fff"/>
            </svg>                          
        </div>
        <div id="floorDown">
            <svg class="col100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 553.52 399.32" style="transform: rotate(180deg)">
                <path d="M705.16,556.36,828.1,679.31,1104.48,402.9,827.4,125.79c-.19.17-81.773,82.534-122.24,123.047-.025.071,153.006,154.095,153.022,154.063Z" transform="translate(-125.79 1104.48) rotate(-90)" fill="#fff"/>
            </svg>                          
        </div>
    </div>
   </div>
   <input id="totalZones" type="hidden" name="totalZones" value="{{ count($zones) }}">
   <input id="actualZone" type="hidden" value="{{ $firstZoneId }}">
   @php
       $i = 1;
   @endphp
   @foreach ($zones as $z)
       @if ($z->id == $firstZoneId)
       <div id="zone{{ $i }}" class="addScene" style="display: block">
       @else
       <div id="zone{{ $i }}" class="addScene" style="display: none">
       @endif
           <div id="zoneicon" class="icon zoneicon" style="display: none">
               <img class="." src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
           </div>
           @php
               $scenes = $z->scenes()->get();
           @endphp
           @if ($scenes != null)
               @foreach ($scenes as $scene)
                   <div class="icon" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%;">
                       <img id="scene{{ $scene->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
                   </div>
               @endforeach
           @endif
           <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
           <input id="urlhover" type="hidden" value="{{ url('img/zones/icon-zone-hover.png') }}">
           <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$z->file_image) }}" alt="">
       </div>
       @php
           $i++;
       @endphp
   @endforeach
@endisset

@isset($zone)
<div class="closeModalButton">
    <img src="{{ url('img/icons/close.png') }}" alt="close" width="100%">
</div>
<div id="addScene" class="addScene">
    <div id="zoneicon" class="icon zoneicon" style="display: none">
        <img class="." src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
    </div>
    @foreach ($scenes as $scene)
        <div class="icon" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%;">
            <img id="scene{{ $scene->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
        </div>
    @endforeach
    <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
    <input id="urlhover" type="hidden" value="{{ url('img/zones/icon-zone-hover.png') }}">
    <input id="actualZone{{ $zone->id}}" type="hidden">
    <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}" alt="">
</div>
    
@endisset

