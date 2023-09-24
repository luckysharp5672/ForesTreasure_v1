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
        <h1>作業依頼フォーム</h1>
    
        <form action="{{ route('work_requests.store') }}" method="post">
            @csrf
            <select name="forester_id">
                @foreach($foresters as $forester)
                    <option value="{{ $forester->id }}">{{ $forester->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="forest_id" value="{{ $forest->id }}">
            <select name="work_type">
                <option value="皆伐">皆伐</option>
                <option value="間伐">間伐</option>
                <option value="択伐">択伐</option>
            </select>
            <input type="date" name="desired_completion_date">
            <button type="submit">依頼する</button>
        </form>
    </div>
    
</x-app-layout>