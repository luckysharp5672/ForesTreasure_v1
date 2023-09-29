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
    
    <!--左側エリア[START]-->
    <div class="container">
        <h1>Timber Search Results</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Diameter</th>
                        <th>Height</th>
                        <th>Arrow Height</th>
                        <th>Volume</th>
                        <th>Biomass</th>
                        <th>Species</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td>{{ $result->diameter }}</td>
                        <td>{{ $result->height }}</td>
                        <td>{{ $result->arrow_height }}</td>
                        <td>{{ $result->volume }}</td>
                        <td>{{ $result->biomass }}</td>
                        <td>{{ $result->species }}</td>
                        <td>{{ $result->longitude }}</td>
                        <td>{{ $result->latitude }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div id="bingMap" style="position:relative;width:600px;height:400px;"></div>
    </div>
    <!--左側エリア[END]-->
    
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
    
    <!-- Bing Maps APIのスクリプト -->
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=loadMapScenario&key=ApUslpO8ghJ6mpe35ApW427eo72OmGGHg9ETniAK37AnLv7g6GzjaiEkrMB1cowL' async defer></script>
    
    <script type="text/javascript">
        function loadMapScenario() {
            var map = new Microsoft.Maps.Map(document.getElementById('bingMap'), {
                /* ここにマップの初期設定を追加 */
            });
        
            // 検索結果から取得した森林の座標を使用してピンを追加
            var location = new Microsoft.Maps.Location(latitude, longitude); // ここで正しい緯度と経度を設定
            var pin = new Microsoft.Maps.Pushpin(location);
            map.entities.push(pin);
            
            var pinInfoBox = new Microsoft.Maps.Infobox(location, {
                title: '森林名',  // ここで正しい森林名を設定
                description: 'forest_information',  // ここで正しいforest_informationを設定
                visible: false
            });
            pinInfoBox.setMap(map);
            
            Microsoft.Maps.Events.addHandler(pin, 'mouseover', function () {
                pinInfoBox.setOptions({ visible: true });
            });
            
            Microsoft.Maps.Events.addHandler(pin, 'mouseout', function () {
                pinInfoBox.setOptions({ visible: false });
            });
        }
    </script>
    
</x-app-layout>