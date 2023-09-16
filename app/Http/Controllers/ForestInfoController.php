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
        $csvContent = file_get_contents($filepath);
        $csvContentUTF8 = iconv('Shift_JIS', 'UTF-8', $csvContent);
        $csv = Reader::createFromString($csvContentUTF8);

        
        
        // ヘッダー行をスキップ
        $csv->setHeaderOffset(0);
        
        // 森林ID変数の設定
        $forestID = $request->input('forest_id');
        
        // 各行をループしてデータをインポート
        foreach ($csv->getRecords() as $record) {
            ForestInformation::create([
                'forest_id' => $forestID,
                'tree_number' => $record['ID'],
                'diameter' => $record['胸高直径[cm]'],
                'height' => $record['樹高[m]'],
                'arrow_height' => $record['矢高[cm]'],
                'volume' => $record['材積[m3]'],
                'biomass' => $record['バイオマス[kg]'],
                'species' => $record['樹種'],
                'longitude' => $record['経度（日本測地系）'],
                'latitude' => $record['緯度（日本測地系）'],
            ]);
        }

        // 成功メッセージを表示（オプション）
        // return redirect()->back()->with('success', 'データが正常にインポートされました');
        return redirect('/')->with('success', 'データが正常にインポートされました');
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
