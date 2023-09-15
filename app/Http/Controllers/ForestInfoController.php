<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForestInformation;

class ForestInfoController extends Controller
{
    public function import(Request $request){
        // ファイルのバリデーション
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);
    
        $file = $request->file('csv_file');
        $filename = $file->getClientOriginalName();
        $location = 'uploads';
        $file->move($location, $filename);
    
        $filepath = public_path($location . "/" . $filename);
        $data = array_map('str_getcsv', file($filepath));
    
        // ヘッダー行を削除
        array_shift($data);
        
        $forestID = forests()->id();
    
        foreach ($data as $row) {
            Forest::create([
                'forest_id' => $forestID,
                'tree_number' => $row[22],
                'diameter' => $row[3],
                'height' => $row[4],
                'arrow_height' => $row[5],
                'volume' => $row[7],
                'biomass' => $row[9],
                'species' => $row[10],
                'longitude' => $row[27],
                'latitude' => $row[28],
            ]);
        }
    
        return redirect()->back()->with('success', 'CSVデータをインポートしました！');
    }
      
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
