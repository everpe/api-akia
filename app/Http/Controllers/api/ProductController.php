<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $products=Product::all();
        return response()->json(['products' => $products], 200);
    }

    /**
     * Que mande a crear un producto dentro de cada tienda para la relacion de pivot mas facil
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validate=\Validator::make($input,[
            'name'=>'required',
            'image'=>'required|mimes:svg,png,PNG|required|max:5000000',
            'shop_id'=>'required'
        ]);

        if(!$validate->fails()){
            if($request->has('image'))
            $input['image'] = $this->uploadFile($request->image);

            // La creación se puede abreviar asi
            $product=new Product();
            $product->name=$input['name'];
            $product->image=$input['image'];
            $product->save();
            $product->shops()->attach($input['shop_id']);
            // $product->name=$input['name'];
            
            return response()->json([
                'res' => true,
                'message' => 'Producto creado correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors()
            ], 400);
        }
    }

    public function show(Product $product)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        $product = Product::findOrFail($product->id);
       
        $input = $request->all();
        $validate=\Validator::make($input,[
            'name'=>'required',
            'image'=>'required|mimes:svg,png,PNG|required|max:5000000'
            // 'shop_id'=>'required'
        ]);
        if(!$validate->fails()){
            if($request->has('image'))
            $input['image'] = $this->uploadFile($request->image);
            // La creación se puede abreviar asi
            // $product->shops()->updateExistingPivot(1,$input['shop_id']);
            $product->fill($input)->save();
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Sube una imagen a un folder 
     */
    private function uploadFile($file)
    {
        $nombreArchivo = time(). '.'. $file->getClientOriginalExtension();
        $file->move(public_path('products'), $nombreArchivo);
        return $nombreArchivo;
    }
}
