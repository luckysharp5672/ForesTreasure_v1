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
                                                    @if($request->forester_approved)
                                                        <span class="text-red-500">承認済</span>
                                                    @else
                                                        <button class="text-blue-500 hover:text-blue-700" onclick="approveForester({{ $request->work_id }})">承認</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($request->owner_approved)
                                                        <span class="text-red-500">承認済</span>
                                                    @else
                                                        <button class="text-blue-500 hover:text-blue-700" onclick="approveOwner({{ $request->work_id }})">承認</button>
                                                    @endif 
                                                </td>
                                                <td>{{ $request->approval_date }}</td>
                                                <td>
                                                    @if($request->work_completed)
                                                        <span class="text-red-500">作業済</span>
                                                    @else
                                                        <button class="text-blue-500 hover:text-blue-700" onclick="completeWork({{ $request->work_id }})">作業中</button>
                                                    @endif
                                                </td>
                                                
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