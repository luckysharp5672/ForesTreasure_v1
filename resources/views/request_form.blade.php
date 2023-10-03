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

    <!--フォーム[START]-->
    <div class="text-gray-700 text-left px-4 py-4 m-2">
        <div class="container">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-500 font-bold">
                    <h1>作業依頼フォーム</h1>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    選択している森林の作業依頼を提出できます。
                </div>

            </div>
            <p>選択されている森林: {{ $forest->forest_name }}</p>
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
                
    
                <x-button class="bg-blue-500 rounded-lg" type="submit">作業依頼</x-button>
                
                <!-- フラッシュメッセージの表示 -->
                @if(session('success'))
                    <script>
                        alert('{{ session('success') }}');
                    </script>
                @endif
                
                @if(session('error'))
                    <script>
                        alert('{{ session('error') }}');
                    </script>
                @endif
                
                <!-- バリデーションエラーメッセージの表示 -->
                @if($errors->any())
                    <script>
                        alert('依頼できませんでした。入力データを確認ください');
                    </script>
                @endif
                
            </form>
        </div>
        <a class="text-blue-500 hover:text-blue-700" href="{{ route('work_requests') }}">{{ __('作業一覧') }}</a>
    </div>
    <!--フォーム[END]-->
    
</x-app-layout>