<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkRequest; // WorkRequest モデルをインポート
use App\Models\Forest;      // Forest モデルをインポート
use App\Models\User;        // User モデルをインポート
// use App\Notifications\WorkRequested; // 通知クラスをインポート（存在する場合）
use App\Notifications\WorkRequestApproved;

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
        
        $result = WorkRequest::create($data);
        
        if ($result) {
            // 通知を送信
            $forester = User::find($data['forester_id']);
            // $forester->notify(new WorkRequested());
        
            return redirect()->back()->with('success', '依頼が送信されました。');
        } else {
            return redirect()->back()->with('error', '依頼できませんでした。入力データを確認ください。');
        }
    }
    
    public function create(Request $request, $forestId)
    {
        $forest = Forest::find($forestId);
        $foresters = User::getForestersNearby($forest->latitude, $forest->longitude);
    
        return view('request_form', ['foresters' => $foresters, 'forest' => $forest]);
    }
    
    public function index()
    {
        $workRequestAll = WorkRequest::all(); // すべてのwork_requestsを取得
    
        $workRequests = WorkRequest::where('requester_id', auth()->id())
                                   ->orWhere('forester_id', auth()->id())
                                   ->get(); // ログインしているユーザーが依頼元または依頼先になっているリクエストのみを取得
    
        return view('work_requests', [
            'workRequests' => $workRequests, 
            'workRequestAll' => $workRequestAll
        ]); // work_requestsのビューにデータを渡して表示
    }
    
    public function approveForester($id) {
        \Log::info('approveForester method called.');
        $workRequest = WorkRequest::find($id);
        $workRequest->forester_approved = true;
        
        // 両者の承認が完了した場合
        if ($workRequest->owner_approved) {
            $workRequest->approval_date = now();
            $workRequest->save();
        } else {
            $workRequest->save();
        }
    
        // $workRequest->save();
        // $workRequest->requester->notify(new WorkRequestApproved($workRequest));
    
        return redirect()->back()->with('message', '林業家の承認が完了しました。');
    }
    
    public function approveOwner($id) {
        \Log::info('approveForester method called.');
        $workRequest = WorkRequest::find($id);
        $workRequest->owner_approved = true;
    
        // 両者の承認が完了した場合
        if ($workRequest->forester_approved) {
            $workRequest->approval_date = now();
            $workRequest->save();
        } else {
            $workRequest->save();
        }
    
        // $workRequest->save();
        // $workRequest->requester->notify(new WorkRequestApproved($workRequest));
    
        return redirect()->back()->with('message', '所有者の承認が完了しました。');
    }
    
    public function completeWork($id) {
        $workRequest = WorkRequest::find($id);
        $workRequest->work_completed = true;
        $workRequest->completion_date = now();
        $workRequest->save();
    
        return redirect()->back()->with('message', '作業が完了しました。');
    }

}
