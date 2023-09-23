<x-app-layout>

    <!--ヘッダー[START]-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <form action="" method="GET" class="w-full max-w-lg">
                <x-button class="bg-gray-100 text-gray-900">{{ __('Dashboard') }}</x-button>
            </form>
        </h2>
    </x-slot>
    <!--ヘッダー[END]-->

    <div class="container">
        <h1>Request Form</h1>
    
        <table>
            <thead>
                <tr>
                    <th>作業ID</th>
                    <th>森林名</th>
                    <th>作業種別</th>
                    <th>依頼元</th>
                    <th>依頼受</th>
                    <th>作業完了希望日</th>
                    <th>作業依頼日</th>
                    <th>作業承認日</th>
                    <th>作業完了日</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workRequests as $request)
                    <tr>
                        <td>{{ $request->work_id }}</td>
                        <td>{{ $request->forest->name }}</td>
                        <td>{{ $request->work_type }}</td>
                        <td>{{ $request->requester->name }}</td>
                        <td>{{ $request->forester->name }}</td>
                        <td>{{ $request->desired_completion_date }}</td>
                        <td>{{ $request->request_date }}</td>
                        <td>{{ $request->approval_date }}</td>
                        <td>{{ $request->completion_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    
</x-app-layout>