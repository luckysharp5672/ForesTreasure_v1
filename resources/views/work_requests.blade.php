<x-app-layout>

    <!--ヘッダー[START]-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-button onclick="goBack()" class="bg-gray-100 text-gray-900">{{ __('戻る') }}</x-button>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </h2>
    </x-slot>
    <!--ヘッダー[END]-->
    
    <style>
        table {
            min-width: 1000px; /* 必要に応じてこの値を調整してください */
        }
        
        th, td {
            min-width: 100px; /* または任意の幅 */
        }
    </style>

    <div class="flex bg-gray-100">
        <!-- 右側エリア[START] -->
        <div class="flex-1 text-gray-700 text-left px-4 py-2 m-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-500 font-bold">
                    作業一覧
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    あなたに関連した作業の一覧が表示されています。青字の状況を確認して、ステータスをアップデートする場合は青字をクリックしてください。
                </div>
            </div>
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto" style="height: 600px; overflow-y: auto;">
                    <div class="p-1.5 w-full inline-block align-middle overflow-x-auto">
                        <div class="border rounded-lg shadow w-full dark:border-gray-700 dark:shadow-gray-900">
                            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th>作業ID</th>
                                        <th>森林名</th>
                                        <th>作業種別</th>
                                        <th>依頼元</th>
                                        <th>依頼先</th>
                                        <th>作業完了希望日</th>
                                        <th>作業依頼日</th>
                                        <th>林業家承認</th>
                                        <th>森林所有者承認</th>
                                        <th>作業承認日</th>
                                        <th>作業状況</th>
                                        <th>作業完了日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workRequests as $request)
                                        <tr>
                                            <td>{{ $request->work_id }}</td>
                                            <td>{{ $request->forest->forest_name }}</td>
                                            <td>{{ $request->work_type }}</td>
                                            <td>{{ $request->requester->name }}</td>
                                            <td>{{ $request->forester->name }}</td>
                                            <td>{{ $request->desired_completion_date }}</td>
                                            <td>{{ $request->request_date }}</td>
                                            <td>
                                                @if(!$request->forester_approved && auth()->user()->id == $request->forester->id)
                                                    <button class="text-blue-500 hover:text-blue-700" onclick="approveForester({{ $request->work_id }})">承認</button>
                                                @elseif($request->forester_approved)
                                                    <span class="text-red-500">承認済</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$request->owner_approved && auth()->user()->id == $request->forest->owner_id)
                                                    <button class="text-blue-500 hover:text-blue-700" onclick="approveOwner({{ $request->work_id }})">承認</button>
                                                @elseif($request->owner_approved)
                                                    <span class="text-red-500">承認済</span>
                                                @endif
                                            </td>
                                            <td>{{ $request->approval_date }}</td>
                                            <td>
                                                @if($request->approval_date && !$request->work_completed && auth()->user()->id == $request->forester->id)
                                                    <button class="text-blue-500 hover:text-blue-700" onclick="completeWork({{ $request->work_id }})">作業中</button>
                                                @elseif($request->work_completed)
                                                    <span class="text-red-500">作業済</span>
                                                @endif
                                            </td>
                                            
                                            <td>{{ $request->completion_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 右側エリア[END] -->
    </div>
    
</x-app-layout>

<script>
function approveForester(workId) {
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/work-requests/${workId}/approve-forester`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => location.reload())
    .catch(error => alert('エラーが発生しました。'));
}

function approveOwner(workId) {
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/work-requests/${workId}/approve-owner`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => location.reload())
    .catch(error => alert('エラーが発生しました。'));
}
</script>

<script>
function completeWork(workId) {
    fetch(`/work-requests/${workId}/complete`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('エラーが発生しました。');
        }
    });
}
</script>