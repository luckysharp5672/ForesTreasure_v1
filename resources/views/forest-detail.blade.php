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
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    森林の立木データをCSVファイルで、森林の3Dウォークスルーを動画ファイルでアップロードしてください。
                </div>

            </div>


            <!-- 森林のタイトル -->
            <!--<form action="{{ url('forests') }}" method="POST" class="w-full max-w-lg">-->
                <!--@csrf-->
                  <div class="flex flex-col px-2 py-2">
                    
                    <!-- マップを表示するためのdivを追加 -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0"><br>
                        <label class="block uppercase tracking-wide text-gray-700 font-bold mb-2">
                            森林の位置
                        </label>
                        <div id="myMap" style="position:relative;width:400px;height:400px;"></div>
                    </div>
                    
                    <!-- 森林CSVファイルアップロード -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0"><br>
                      <label class="block uppercase tracking-wide text-gray-700 font-bold mb-2">
                       森林CSVファイルアップロード
                      </label>
                        <form action="{{ route('forestinformation.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="forest_id" value="{{ $forest->id }}">
                            <input type="file" name="csv_file" required>
                            <button class="text-blue-500 hover:text-blue-700" type="submit">アップロード</button>
                        </form>
                    </div>
                    
                    <!-- 立木配置マップアップロード -->
                     <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0"><br>
                        <label class="block uppercase tracking-wide text-gray-700 font-bold mb-2">
                            立木配置画像アップロード
                        </label>
                        <form action="{{ route('treeLayout.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="forest_id" value="{{ $forest->id }}">
                            <input type="file" name="tree_layout_image" required>
                            <button class="text-blue-500 hover:text-blue-700" type="submit">アップロード</button>
                        </form>
                    </div>
                    @php
                    $image = $forest->treeLayoutImages()->latest()->first();
                    @endphp
                    
                    @if($image)
                    <img src="{{ asset('storage/tree_layout_images/' . $image->filename) }}" alt="立木配置の画像" width="448" height="336">
                    @endif

                    
                    <!-- 森林3Dアップロード -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0"><br>
                      <label class="block uppercase tracking-wide text-gray-700 font-bold mb-2">
                       森林3Dアップロード
                      </label>
                        <form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="forest_id" value="{{ $forest->id }}">
                            <input type="file" name="video" required>
                            <button class="text-blue-500 hover:text-blue-700" type="submit">アップロード</button>
                        </form>
                    </div>
                    @php
                    $video = $forest->videos()->latest()->first();
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
              <div class="-m-1.5 overflow-x-auto" style="height: 600px; overflow-y: auto;">
                <div class="p-1.5 min-w-full inline-block align-middle">
                  <div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                      <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0">
                        <tr>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">森林ID</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">立木ID</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">胸高直径[cm]</th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">樹高[m]</th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">矢高[cm]</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">立木材積[m3]</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">立木バイオマス[kg]</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">樹種</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">緯度</th>
                        　<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">経度</th>
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($forestInformation as $info)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->forest_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->tree_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->diameter }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->height }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->arrow_height }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->volume }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->biomass }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->species }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->longitude }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $info->latitude }}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <a class="text-blue-500 hover:text-blue-700" href="{{ route('work_requests.create', ['forestId' => $forest->id]) }}">作業依頼フォーム</a>
        </div>
        <!--右側エリア[[END]-->  

</div>
 <!--全エリア[END]-->

</x-app-layout>

<!-- Bing Mapsのスクリプトを追加 -->
<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=loadMapScenario&key=ApUslpO8ghJ6mpe35ApW427eo72OmGGHg9ETniAK37AnLv7g6GzjaiEkrMB1cowL' async defer></script>
<script type="text/javascript">
    function loadMapScenario() {
        var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
            /* No need to set credentials if already passed in URL */
            center: new Microsoft.Maps.Location({{ $forest->latitude }}, {{ $forest->longitude }}),
            zoom: 10
        });
        var center = map.getCenter();
        var pin = new Microsoft.Maps.Pushpin(center, {
            title: '{{ $forest->forest_name }}',
            subTitle: '座標: {{ $forest->latitude }}, {{ $forest->longitude }}',
            text: '!'
        });
        map.entities.push(pin);
    }
</script>
