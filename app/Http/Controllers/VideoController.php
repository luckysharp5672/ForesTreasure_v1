<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function upload(Request $request)
{
    if($request->hasFile('video')) {
        $video = $request->file('video');
        $filename = time() . '.' . $video->getClientOriginalExtension();
        $video->storeAs('videos', $filename, 'public');

        // データベースにファイル名を保存する等の処理をここに追加

        return back()->with('message', '動画をアップロードしました');
    }
}
}
