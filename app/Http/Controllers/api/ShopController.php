<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Shop;
use App\Product;

class ShopController extends Controller
{
   
    public function __construct(){
        $this->middleware('auth:sanctum',
        ['except'=>['show','index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops=Shop::all();
        return response()->json(['shops' => $shops], 200);
    }

    /** 
     * Crea una nueva Shop, en el request va el parametro de id_categoria
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params=$request->all();
        $validate=\Validator::make($params,[
            'name'=>'required',
            'category_id'=>'required|numeric',
            'image'=>'required|mimes:svg,png,PNG|required|max:5000000'
        ]);
        if(!$validate->fails()){
            if($request->has('image'))
            $params['image'] = $this->uploadFile($request->image);
            // La creación se puede abreviar asi
            Shop::create($params);
            return response()->json([
                'res' => true,
                'message' => 'Creado correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors()
            ], 400);
        } 
    }

    /**
     * Consulta una tienda y todos los productos que tenga esta.
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $id = $shop->id;
        $shop=Shop::findOrFail($id);
        $products = $shop->products();
        return response()->json(['shop' => $shop, 'products' => $products], 200);
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        $shop = Shop::findOrFail($shop->id);
       
        $input = $request->all();
        $validate=\Validator::make($input,[
            'name'=>'required',
            'category_id'=>'required|numeric',
            'image'=>'required|mimes:svg,png,PNG|required|max:5000000'
        ]);
        if(!$validate->fails()){
            if($request->has('image'))
            $input['image'] = $this->uploadFile($request->image);
            // La creación se puede abreviar asi
            $shop->fill($input)->save();
            return response()->json([
                'res' => true,
                'message' => 'Acutlizado correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors()
            ], 400);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        Shop::destroy($shop->id);
        return response()->json([
            'res' => true,
            'message' => 'Tienda eliminada correctamente'
        ], 200);
    }

    /**
     * Sube una imagen a un folder 
     */
    private function uploadFile($file)
    {
        $nombreArchivo = time(). '.'. $file->getClientOriginalExtension();
        $file->move(public_path('shops'), $nombreArchivo);
        return $nombreArchivo;
    }
}
