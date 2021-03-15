<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    /**
     * Todas las rentas que tenga activas
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rents=Rent::all()->where('state',true);
        return response()->json(['rents' => $rents], 200);
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
            'name'=>'required',
            'cellphone'=>'required',
            'email'=>'required|email',
            'type'=>'required'
        ]);
        if(!$validate->fails()){
            // La creación se puede abreviar asi
            Rent::create($input);
            return response()->json([
                'res' => true,
                'message' => 'Renta creada correctamente'
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
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Solo puede modificarle el estado a las solicitudes de Renta que tiene
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        $rent = Rent::findOrFail($rent->id);
        $input = $request->all();
        $validate=\Validator::make($input,[
            'state'=>'required'
            // 'category_id'=>'required|numeric',
            // 'image'=>'required|mimes:svg|required|max:5000000'
        ]);
        if(!$validate->fails()){
            // La creación se puede abreviar asi
            $rent->fill($input)->save();
            return response()->json([
                'res' => true,
                'message' => 'Renta Acutlizada correctamente'
            ], 200);
        }else{
            return response()->json([
                'res' => false,
                'message' => $validate->errors()
            ], 400);
        } 
    }

    public function changeState( $rent)
    {
        $rent = Rent::find($rent);
        $rent->state=false;
        $rent->save();
        return response()->json([
            'res' => true,
            'message' => "Actulizado correctamente"
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
