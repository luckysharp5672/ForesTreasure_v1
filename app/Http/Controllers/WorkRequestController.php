<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkRequest; // WorkRequest モデルをインポート
use App\Models\Forest;      // Forest モデルをインポート
use App\Models\User;        // User モデルをインポート
// use App\Notifications\WorkRequested; // 通知クラスをインポート（存在する場合）

class WorkRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'forester_id' => 'required|exists:users,id',
            'forest_id' => 'required|exists:forests,id',
            'work_type' => 'required|string',
            'desired_completion_date' => 'required|date',
        ]);
    
        $data['request_date'] = now();
        
        $data['requester_id'] = auth()->id();
        
        WorkRequest::create($data);
        
        // 通知を送信
        $forester = User::find($data['forester_id']);
        // $forester->notify(new WorkRequested());
    
        return redirect()->back()->with('success', '依頼が送信されました。');
    }
    
    public function create(Request $request, $forestId)
    {
        $forest = Forest::find($forestId);
        $foresters = User::getForestersNearby($forest->latitude, $forest->longitude);
    
        return view('request_form', ['foresters' => $foresters, 'forest' => $forest]);
    }
    
    public function index()
    {
        $workRequests = WorkRequest::all(); // すべてのwork_requestsを取得
        return view('work_requests', ['workRequests' => $workRequests]); // work_requestsのビューにデータを渡して表示
    }

}
