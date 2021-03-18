<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


/**
 * Controlador para el documento de requisitos y los banners se hará por DB para facilidad 
 */
class ConfigController extends Controller
{
    /**
     * Lista todas los banners por seccion
     */
    function indexBanners($section){
        $images_banners=DB::table('banners')->where([
            ['state','=',true],
            ['section','=',$section]])->get();
        return response()->json(['banners' => $images_banners], 200);
    }
    /**
     * Representa la imagen de un banner esots se diferencias por la section a la que perteneces
     */
    function createBanner(Request $request){
        $input = $request->all();
        $validate=\Validator::make($input,[
            'path_image'=>'required|mimes:svg,png,PNG,jpg|required|max:5000000',
            'section'=>'required'
        ]);
        if(!$validate->fails()){
            if($request->has('path_image'))
            $input['path_image'] = $this->uploadFile($request->path_image);

            // La creación se puede abreviar asi
            // News::create($input);
            // GetId
            $id = DB::table('banners')->insert(
                ['path_image' => $input['path_image'], 
                'section' => $input['section'] ]
            );
            return response()->json([
                'res' => true,
                'message' => 'Image Banner creada correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors()
            ], 400);
        }
    }


    /**
     * Coloca false el estado de una image Banner 
     */
    public function desactiveImageBanner($id_banner){
        $banner = DB::table('banners')
              ->where('id', $id_banner)
              ->update(['state' => false]);
        return response()->json([
            'res' => true,
            'banner' => $banner
        ], 200);
    }



    /**
     * Crea el documento de Requisito será siempre uno
     */
    function createRequired(Request $request){
        $input = $request->all();
        // mimes:svg,png,PNG,jpg|required| sin validar tipo documento
        $validate=\Validator::make($input,[
            'path_requisitos'=>'required|max:5000000'
        ]);
        if(!$validate->fails()){
            // Vacia la tabla y agrega ya q solo puede haber Uno
            DB::table('requisitos')->delete();
            if($request->has('path_requisitos'))
            $input['path_requisitos'] = $this->uploadRequired($request->path_requisitos);
            $id = DB::table('requisitos')->insert(
                ['path_requisitos' => $input['path_requisitos'] ]
            );
            return response()->json([
                'res' => true,
                'message' => 'Requisito creado correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors()
            ], 400);
        }
    }


    
    private function uploadRequired($file)
    {
        $nombreArchivo = time(). '.'. $file->getClientOriginalExtension();
        $file->move(public_path('requireds'), $nombreArchivo);
        return $nombreArchivo;
    }
    private function uploadFile($file)
    {
        $nombreArchivo = time(). '.'. $file->getClientOriginalExtension();
        $file->move(public_path('banners'), $nombreArchivo);
        return $nombreArchivo;
    }


    public function getRequired(){
        $required = DB::table('requisitos')->first();
        return response()->json([
            'res' => true,
            'required' => $required
        ], 200);
    }

}
