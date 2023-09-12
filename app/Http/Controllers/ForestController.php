<?php

namespace App\Http\Controllers;

use App\Models\Forest; //この行を上に追加
use App\Models\User;//この行を上に追加
use Auth;//この行を上に追加
use Validator;//この行を上に追加
use Illuminate\Http\Request;

class ForestController extends Controller
{
    public function index(){
        //チーム全件取得
        $forests = Forest::get();
    
        return view('forests',[
            'forests'=> $forests
            ]);
    }
    
     public function store(Request $request){
        //バリデーション 
        $validator = Validator::make($request->all(), [
            'forest_name' => 'required|max:255'
        ]);
        
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        
        //以下に登録処理を記述（Eloquentモデル）
        $forests = new Forest;
        $forests->owner_id = Auth::id();//ここでログインしているユーザidを登録しています
        $forests->forest_name = $request->forest_name;
        $forests->csv_file_path = $request->csv_file_path;
        $forests->digital_3d_display_file_path = $request->digital_3d_display_file_path;
        $forests->latitude = $request->latitude;
        $forests->longitude = $request->longitude;
        $forests->save();
        
        return redirect('/');
        
    }
}
