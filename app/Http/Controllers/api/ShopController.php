<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Shop;
use App\Product;

class ShopController extends Controller
{
   
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
            'category_id'=>'required|numeric'
        ]);
        if(!$validate->fails()){
            // La creación se puede abreviar asi
            Shop::create($params);
            return response()->json([
                'res' => true,
                'message' => 'Creado correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => true,
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
            'category_id'=>'required|numeric'
        ]);
        if(!$validate->fails()){
            // La creación se puede abreviar asi
            $shop->fill($input)->save();
            return response()->json([
                'res' => true,
                'message' => 'Acutlizado correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => true,
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
        //
    }
}
