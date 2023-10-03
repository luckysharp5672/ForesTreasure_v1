<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forest;
use App\Models\TreeLayoutImage;

class TreeLayoutImageController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('tree_layout_image')) {
            $imageFile = $request->file('tree_layout_image');
            
            // 元のファイル名を取得
            $originalFilename = $imageFile->getClientOriginalName();
            
            // タイムスタンプを付加した保存名を生成
            $filename = time() . '_' . $originalFilename;
            
            // その保存名でファイルを保存
            $imageFile->storeAs('tree_layout_images', $filename, 'public');
            
            // データベースには元のファイル名とタイムスタンプ付きの保存名を保持
            TreeLayoutImage::create([
                'filename' => $filename,
                'forest_id' => $request->input('forest_id')
            ]);
    
            return back()->with('message', '画像をアップロードしました');
        }
    }
}
