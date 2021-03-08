<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;

class NewController extends Controller
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
        $news=News::all();
        return response()->json(['news' => $news], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validate=\Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
            'image'=>'required|mimes:svg|required|max:5000000'
        ]);

        if(!$validate->fails()){
            if($request->has('image'))
            $input['image'] = $this->uploadFile($request->image);

            // La creación se puede abreviar asi
            News::create($input);
            return response()->json([
                'res' => true,
                'message' => 'Noticia creada correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        $id = $news->id;
        $new=News::findOrFail($id);
        return response()->json(['new' => $new], 200);
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news, el parametro tiene q ser plural para que traiga el id.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $input = $request->all();
        $new = News::findOrFail($news->id);
        $validate=\Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
            'image'=>'required|mimes:svg|required|max:5000000'
        ]);

        if(!$validate->fails()){
            if($request->has('image'))
            $input['image'] = $this->uploadFile($request->image);
        
            //se puede abreviar asi
            $new->fill($input)->save();
            return response()->json([
                'res' => true,
                'message' => 'Acutlizado correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors(),
                'ff'=>$input 
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        News::destroy($news->id);
        return response()->json([
            'res' => true,
            'message' => 'Eliminado correctamente'
        ], 200);
    }


    /**
     * Sube una imagen a un folder 
     */
    private function uploadFile($file)
    {
        $nombreArchivo = time(). '.'. $file->getClientOriginalExtension();
        $file->move(public_path('news'), $nombreArchivo);
        return $nombreArchivo;
    }
}
