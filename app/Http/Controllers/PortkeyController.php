<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portkey;
use App\Scene;
use App\Zone;
use Illuminate\Support\Facades\DB;

class PortkeyController extends Controller
{

    /*public function __construct(){

        $this->middleware('admin');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['portkeyList'] = Portkey::all();
        $data['portkeySceneList'] = Scene::all();
        return view('backend.portkey.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $portkey = new Portkey($request->all());
        $portkey->save();

        return redirect()->route('portkey.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portkey = Portkey::all();
        return view('backend.portkey.index', array('portkey' => $portkey));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $prk = Portkey::find($id);
        $prk->name = $r->name;
        $prk->save();
        return redirect()->route('portkey.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portkey = Portkey::find($id);
        $portkey->delete();
        echo "1";
    }

    //esto es mio
    public function mostrarRelacion($id)
    {
        $data['zones'] = Zone::all();
        $data['firstZoneId'] = 1;

        $data['portkey'] = Portkey::find($id);
        $data['portkeySceneList'] = DB::table('portkeys')
            ->join('portkey_scene', 'portkeys.id', '=', 'portkey_scene.portkey_id')
            ->join('scenes', 'portkey_scene.scene_id', '=', 'scenes.id')
            ->join('zones', 'zones.id', '=', 'scenes.id_zone')
            ->where('portkeys.id', '=', $id)
            ->orderBy('zones.position', 'ASC')
            ->select('scenes.*')
            ->get();
        $data['zoneSceneList'] = $data['portkey']->scene()->get();
        return view('backend.portkey.portkeyScene', $data);
    }
    
    public function storeScene(request $r, $id){

        $portkey = Portkey::find($id);
        $scene = Scene::find($r->scene);
        $portkey->scene()->attach($r->scene);
        
        $data['portkey'] = $portkey;
        $data['scene'] = $scene;

        return response()->json($data);
    }

    public function deleteScene($id, $id2)
    {
        $portkey = Portkey::find($id);
        
        
        $portkey->scene()->detach($id2);
        echo "1";
        // $portkey = Portkey::find($id);
        // $scene = Scene::find($r->scene);
        // $scene->delete();
        // echo "1";
        //return redirect()->route('portkey.index');
    }

    public function openUpdate($id){
        
        $portkey = Portkey::find($id);

        return response()->json($portkey);
    }
    
    //----------------------------------------------------------

    /*
    * METODO PARA CONFECCIONAR EL HOTSPOT DE TIPO ASCENSOR PASANDOLE 
    * LOS NOMBRES DE CADA ESCENA Y SU POSICION
    */
    public function getScenes($id){
        $portkey = Portkey::find($id);
        $scenesRelated = $portkey->scene;

        for($i=0; $i<$scenesRelated->count(); $i++){
            $zone = Zone::find($scenesRelated[$i]->id_zone);
            $scenesRelated[$i]->zone = $zone->name;
            $scenesRelated[$i]->pos =  $zone->position; //La posicion del ascensor se realiza en funcion de la de la zona
        }
       
        return response()->json($scenesRelated);
    }
}
