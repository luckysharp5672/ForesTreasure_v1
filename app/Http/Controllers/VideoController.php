<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forest;
use App\Models\Video;

class VideoController extends Controller
{
    public function upload(Request $request)
{
    if($request->hasFile('video')) {
        $videoFile = $request->file('video');
        
        // 元のファイル名を取得
        $originalFilename = $videoFile->getClientOriginalName();
        
        // タイムスタンプを付加した保存名を生成
        $filename = time() . '_' . $originalFilename;
        
        // その保存名でファイルを保存
        $videoFile->storeAs('videos', $filename, 'public');
        
        // データベースには元のファイル名とタイムスタンプ付きの保存名を保持
        Video::create([
            'filename' => $filename,
            'forest_id' => $request->input('forest_id')
        ]);

        return back()->with('message', '動画をアップロードしました');
    }
}
}
