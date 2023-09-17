<!-- resources/views/books.blade.php -->
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
            
        <!-- バリデーションエラーの表示に使用-->
       <x-errors id="errors" class="bg-blue-500 rounded-lg">{{$errors}}</x-errors>
        <!-- バリデーションエラーの表示に使用-->
    
    <!--全エリア[START]-->
    <div class="flex bg-gray-100">

        <!--左エリア[START]--> 
        <div class="text-gray-700 text-left px-4 py-4 m-2">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-500 font-bold">
                    森林名：{{ $forest->forest_name}}
                </div>
            </div>


            <!-- 森林のタイトル -->
            <!--<form action="{{ url('forests') }}" method="POST" class="w-full max-w-lg">-->
                <!--@csrf-->
                  <div class="flex flex-col px-2 py-2">
                    <!-- 森林CSVファイルアップロード -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                       森林CSVファイルアップロード
                      </label>
                        <form action="{{ route('forestinformation.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="forest_id" value="{{ $forest->id }}">
                            <input type="file" name="csv_file" required>
                            <button type="submit">アップロード</button>
                        </form>
                    </div>
                    <!-- 森林3Dアップロード -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                       森林3Dアップロード
                      </label>
                        <form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="forest_id" value="{{ $forest->id }}">
                            <input type="file" name="video" required>
                            <button type="submit">アップロード</button>
                        </form>
                    </div>
                    @php
                    $video = $forest->videos->first();
                    @endphp
                    
                    @if($video)
                    <video width="448" height="336" controls>
                        <source src="{{ asset('storage/videos/' . $video->filename) }}" type="video/mp4">
                        ご使用のブラウザは動画の再生に対応していません。
                    </video>
                    @endif
                  </div>
            <!--</form>-->
        </div>
        <!--左エリア[END]--> 
    
        <!--右側エリア[START]-->
        <div class="flex-1 text-gray-700 text-left px-4 py-2 m-2">
             <!-- 立木の一覧 -->
            <div class="flex flex-col">
              <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                  <div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                      <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">森林ID</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">立木ID</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">胸高直径[cm]</th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">樹高[m]</th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">矢高[cm]</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">材積[m3]</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">バイオマス[kg]</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">樹種</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">緯度</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">経度</th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($forestInformation as $info)
                            <tr>
                                <td>{{ $info->forest_id }}</td>
                                <td>{{ $info->tree_number }}</td>
                                <td>{{ $info->diameter }}</td>
                                <td>{{ $info->height }}</td>
                                <td>{{ $info->arrow_height }}</td>
                                <td>{{ $info->volume }}</td>
                                <td>{{ $info->biomass }}</td>
                                <td>{{ $info->species }}</td>
                                <td>{{ $info->longitude }}</td>
                                <td>{{ $info->latitude }}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!--右側エリア[[END]-->  

</div>
 <!--全エリア[END]-->

</x-app-layout>
