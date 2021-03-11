<?php

namespace App\Http\Controllers\api;

use App\Category;
use App\Shop;
use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum',
        ['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params=$request->all();
        $validate=\Validator::make($params,[
            'name'=>'required']);
        if(!$validate->fails()){
            $category= new Category();
            $category->name=$params['name'];
            $category->save();
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
     * Busca todas las tiendas y noticias que pertenezcan a cierta categoria.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $id = $category->id;
        $category=Category::findOrFail($id);
        $shops = Shop::where('category_id', $id)->get();
        $news = News::where('category_id', $id)->get();
        return response()->json(['category' => $category, 'shops' => $shops,'news'=>$news], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input=$request->all();
        $category->update($input);
        return response()->json([
            'res' => true,
            'message' => 'Actualizado correctamente',
            'category'=>$category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'res' => true,
            'message' => 'Eliminado correctamente'
        ], 200);
    }
}
