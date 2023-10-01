<!-- resources/views/forests.blade.php -->
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
                    森林登録
                </div>
            </div>


            <!-- 森林のタイトル -->
            <form action="{{ url('forests') }}" method="POST" class="w-full max-w-lg">
                @csrf
                  <div class="flex flex-col px-2 py-2">
                   <!-- 森林名 -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                       森林名
                      </label>
                      <input name="forest_name" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                    </div>
                    
                    <!-- BingMapを表示するためのdiv -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                           マップ上に森林の場所を示してください（マップ上でクリック）
                        </label>
                        <div id="myMap" style="width: 448px; height: 336px;"></div>
                    </div>
                    
                    <!-- 緯度 -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                       緯度
                      </label>
                      <input name="latitude" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                    </div>
                    <!-- 経度 -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                       経度
                      </label>
                      <input name="longitude" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                    </div>
                  </div>
                  
                  <!-- 森林登録 -->
                    <div class="flex flex-col">
                      <div class="text-gray-700 text-center px-4 py-2 m-2">
                             <x-button class="bg-blue-500 rounded-lg">森林登録</x-button>
                      </div>
                    </div>
            </form>
            
    <!-- ... その他のコード ... -->
            
        </div>
        <!--左エリア[END]--> 
    
        <!--右側エリア[START]-->
        <div class="flex-1 text-gray-700 text-left px-4 py-2 m-2">
             <!-- チームの一覧 -->
            <div class="flex flex-col">
              <div class="-m-1.5 overflow-x-auto" style="height: 600px; overflow-y: auto;">
                <div class="p-1.5 min-w-full inline-block align-middle">
                  <div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                      <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0">
                        <tr>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">森林名</th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">オーナー</th>
                          <!--<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">参加人数</th>-->
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">詳細</th>
                          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">作業依頼</th>
                        　<!--<th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase dark:text-gray-400">編集</th>-->
                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @if (count($forests) > 0)
                            @foreach ($forests as $forest)
                          <x-collection :forest="$forest"></x-collection>
                          @endforeach
                        @endif
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

    <!-- Bing Maps APIのスクリプト -->
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=loadMapScenario&key=ApUslpO8ghJ6mpe35ApW427eo72OmGGHg9ETniAK37AnLv7g6GzjaiEkrMB1cowL' async defer></script>
    
    <script type="text/javascript">
        function loadMapScenario() {
            var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
                /* ここでマップの初期設定を行うことができます */
            });
    
            // シングルクリックイベントを追加
            Microsoft.Maps.Events.addHandler(map, 'click', function(e) {
                // ピンを立てる
                var pin = new Microsoft.Maps.Pushpin(e.location);
                map.entities.push(pin);
    
                // 緯度と経度を取得して入力フィールドにセット
                document.querySelector('input[name="latitude"]').value = e.location.latitude;
                document.querySelector('input[name="longitude"]').value = e.location.longitude;
            });
            
            // ダブルクリックイベントを追加してズーム
            Microsoft.Maps.Events.addHandler(map, 'dblclick', function(e) {
                map.setView({ zoom: map.getZoom() + 1 });  // 現在のズームレベルに+1してズームイン
            });

        }
    </script>

</x-app-layout>