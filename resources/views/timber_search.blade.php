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

    <div class="container">
        <h1>木材探し</h1>
    
        <!-- 検索フォームの開始 -->
        <form action="{{ route('timber.search.results') }}" method="post">
            @csrf
            
            <!-- 検索方法の選択 -->
            <div>
                <input type="radio" id="searchByOwnedForest" name="searchType" value="ownedForest" checked>
                <label for="searchByOwnedForest">所有している森林での検索</label>
            
                <input type="radio" id="searchByCoordinates" name="searchType" value="coordinates">
                <label for="searchByCoordinates">緯度・経度・半径での検索</label>
            </div>
            
            <!-- 所有している森林の選択 -->
            <div id="ownedForestsSection">
                <label for="owned_forests">所有している森林:</label>
                <select name="owned_forests[]" multiple>
                    @foreach($ownedForests as $forest)
                        <option value="{{ $forest->id }}">{{ $forest->forest_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- 緯度・経度・半径での検索 -->
            <div id="coordinatesSection" style="display: none;">
                <div id="myMap" style="position:relative;width:600px;height:400px;"></div>
                
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
                
                <label for="radius">検索範囲の半径 (km)</label>
                <input type="number" name="radius" id="radius">
            </div>
            
            @foreach(['diameter', 'height', 'arrow_height', 'volume', 'biomass'] as $field)
            <div class="filter-section">
                <label for="{{ $field }}">{{ ucfirst($field) }}</label>
                <select name="{{ $field }}_operator1">
                    <option value="=">=</option>
                    <option value="<"><</option>
                    <option value=">">></option>
                    <option value="<="><=</option>
                    <option value=">=">>=</option>
                </select>
                <input type="text" name="{{ $field }}_value1">
            
                <select name="{{ $field }}_connector">
                    <option value="and">AND</option>
                    <option value="or">OR</option>
                </select>
            
                <select name="{{ $field }}_operator2">
                    <option value="=">=</option>
                    <option value="<"><</option>
                    <option value=">">></option>
                    <option value="<="><=</option>
                    <option value=">=">>=</option>
                </select>
                <input type="text" name="{{ $field }}_value2">
            </div>
            @endforeach

            <label for="species">樹種</label>
            <select name="species[]" multiple>
                @foreach($speciesList as $species)
                    <option value="{{ $species }}">{{ $species }}</option>
                @endforeach
            </select>
            
            <!-- 検索条件名の入力フィールド -->
            <div class="form-group">
                <label for="condition_name">検索条件名:</label>
                <input type="text" name="condition_name" class="form-control" required>
            </div>
        
            <button type="submit" name="action" value="search" class="btn btn-primary">立木検索</button>
            <button type="submit" name="action" value="save" class="btn btn-secondary">検索条件を記録</button>
        </form>
        <!-- 検索フォームの終了 -->
    </div>
    
    <script>
    // ラジオボタンの変更を監視
        document.querySelectorAll('input[name="searchType"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'ownedForest') {
                    document.getElementById('ownedForestsSection').style.display = 'block';
                    document.getElementById('coordinatesSection').style.display = 'none';
                } else {
                    document.getElementById('ownedForestsSection').style.display = 'none';
                    document.getElementById('coordinatesSection').style.display = 'block';
                }
            });
        });
    </script>

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