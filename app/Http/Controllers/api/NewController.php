<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class NewController extends Controller
{
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

        echo($input['category_id']);

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
                'res' => true,
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
    public function show(News $new)
    {
        $id = $new->id;
        $new=News::findOrFail($id);
        return response()->json(['new' => $new], 200);
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
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
