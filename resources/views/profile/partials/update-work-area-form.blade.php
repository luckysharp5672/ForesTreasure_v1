<form action="{{ route('profile.updateWorkArea') }}" method="POST" class="w-full max-w-lg">
    @csrf
    <div class="flex flex-col px-2 py-2">
        <!-- BingMapを表示するためのdiv -->
        <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                活動範囲を示してください（マップ上でクリック）
            </label>
            <div id="workAreaMap" style="width: 448px; height: 336px;"></div>
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

        <!-- 半径距離 -->
        <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                半径距離 (km)
            </label>
            <input name="radius" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
        </div>
    </div>
    
    <!-- 活動範囲を更新 -->
    <div class="flex flex-col">
        <div class="text-gray-700 text-center px-4 py-2 m-2">
            <x-button class="bg-blue-500 rounded-lg">活動範囲を更新</x-button>
        </div>
    </div>
</form>

<!-- Bing Maps APIのスクリプト -->
<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=loadWorkAreaMap&key=ApUslpO8ghJ6mpe35ApW427eo72OmGGHg9ETniAK37AnLv7g6GzjaiEkrMB1cowL' async defer></script>


<script type="text/javascript">
    function loadWorkAreaMap() {
        var map = new Microsoft.Maps.Map(document.getElementById('workAreaMap'), {
            // ここでマップの初期設定を行うことができます
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
