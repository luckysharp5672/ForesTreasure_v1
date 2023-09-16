<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;
use App\Models\ForestInformation;
use App\Models\Forest;

class ForestInfoController extends Controller
{
    public function detail($id)
    {
        $forest = Forest::find($id);
        return view('forest-detail', ['forest' => $forest]);
    }

    public function import(Request $request)
    {
        // ファイルのバリデーション
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);
    
        $file = $request->file('csv_file');
        $filename = $file->getClientOriginalName();
        $location = 'uploads';
        $file->move($location, $filename);
    
        $filepath = public_path($location . "/" . $filename);
        
        // CSVファイルを開く
        $csv = Reader::createFromPath($filepath, 'r');
        
        // ヘッダー行を削除
        // array_shift($data);
        
        // 森林ID変数の設定
        $forestID = forests()->id();
        
        // 各行をループしてデータをインポート
        foreach ($csv as $record) {
            ForestInformation::create([
                'forest_id' => $forestID,
                'tree_number' => $record[22],
                'diameter' => $record[3],
                'height' => $record[4],
                'arrow_height' => $record[5],
                'volume' => $record[7],
                'biomass' => $record[9],
                'species' => $record[10],
                'longitude' => $record[27],
                'latitude' => $record[28],
            ]);
        }

        // 成功メッセージを表示（オプション）
        return redirect()->back()->with('success', 'データが正常にインポートされました');
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
