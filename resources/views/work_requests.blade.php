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
        th, td {
            min-width: 150px; /* または任意の幅 */
        }
    </style>

    <div class="flex bg-gray-100">
        <h1>Request Form</h1>
        <!-- 右側エリア[START] -->
        <div class="flex-1 text-gray-700 text-left px-4 py-2 m-2">
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto" style="height: 600px; overflow-y: auto;">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                
                                <table>
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
                                                    <button class="text-blue-500 hover:text-blue-700" onclick="approveForester({{ $request->work_id }})">承認</button>
                                                </td>
                                                <td>
                                                    <button class="text-blue-500 hover:text-blue-700" onclick="approveOwner({{ $request->work_id }})">承認</button>
                                                </td>
                                                <td>
                                                    @if($request->forester_approved && $request->owner_approved && !$request->completion_date)
                                                        <button class="btn btn-success" onclick="completeWork({{ $request->id }})">作業完了</button>
                                                    @endif
                                                </td>
                                                <td>{{ $request->approval_date }}</td>
                                                <td>{{ $request->completion_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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
function completeWork(workId) {
    // CSRFトークンの取得
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // POSTリクエストの設定
    let requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ id: workId })
    };

    // 作業完了のエンドポイントにリクエストを送信
    fetch(`/work-requests/${workId}/complete`, requestOptions)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('作業が完了しました。');
                location.reload(); // ページをリロード
            } else {
                alert('エラーが発生しました。再度お試しください。');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('エラーが発生しました。再度お試しください。');
        });
}
</script>