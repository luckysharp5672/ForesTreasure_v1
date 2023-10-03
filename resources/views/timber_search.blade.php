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
    
    <!--全エリア[START]-->
    <div class="flex bg-gray-100">
        <div class="w-full text-gray-700 text-left px-4 py-4 m-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-500 font-bold">
                    木材検索
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        所有している森林内での検索か、座標（緯度/経度）とそこからの半径距離での検索ができます。
                    </div>
                    <div>
                        森林範囲を指定後は立木形状と樹種で検索できます。
                    </div>
                </div>

            </div>
            
                <!-- 検索フォームの開始 -->
                <form action="{{ route('timber.search.results') }}" method="post" class="bg-white p-6 rounded shadow">
                    @csrf
                    
                    <!-- 検索方法の選択 -->
                    <div class="mb-4">
                        <div>
                            <input type="radio" id="searchByOwnedForest" name="searchType" value="ownedForest" checked>
                            <label for="searchByOwnedForest">所有している森林での検索</label>
                        
                            <input type="radio" id="searchByCoordinates" name="searchType" value="coordinates">
                            <label for="searchByCoordinates">緯度/経度/半径での検索</label>
                        </div>
                    </div>
                    <!-- 所有している森林の選択 -->
                    <div id="ownedForestsSection" class="mb-4">
                        <label for="owned_forests" class="block text-sm font-medium text-gray-700">所有している森林:</label>
                        <div class="text-gray-900 dark:text-gray-100">
                            森林はShift もしくは Ctrlを押しながら選択することで複数選択できます。
                        </div>
                        <select name="owned_forests[]" multiple class="mt-1 block w-full rounded-md shadow-sm border-gray-300 overflow-y-auto" style="max-height: 65px;">
                            @foreach($ownedForests as $forest)
                                <option value="{{ $forest->id }}">{{ $forest->forest_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- 緯度・経度・半径での検索 -->
                    <div id="coordinatesSection" style="display: none;" class="mb-4">
                        <label for="owned_forests" class="block text-sm font-medium text-gray-700">緯度/経度/検索範囲の半径:</label>
                        <div class="text-gray-900 dark:text-gray-100">
                            検索したいエリアの中心をマップ上でクリックして指定して下さい。その後検索範囲の半径を入力してください。
                        </div>
                        <div id="myMap" style="position:relative;width:600px;height:400px;"></div>
                        
                        <!-- 緯度 -->
                        <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                          <label class="block uppercase tracking-wide text-gray-700 font-bold mb-2">
                           緯度
                          </label>
                          <input name="latitude" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                        </div>
                        <!-- 経度 -->
                        <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                          <label class="block uppercase tracking-wide text-gray-700 font-bold mb-2">
                           経度
                          </label>
                          <input name="longitude" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                        </div>
                        
                        <!-- 検索範囲の半径 -->
                        <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                            <label for="radius">検索範囲の半径 (km)</label>
                            <input type="number" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="radius" id="radius">
                        </div>
                    </div>
                    
                    <label for="timber_selection" class="block text-sm font-medium text-gray-700">立木形状:</label>
                    <div class="flex mb-4 items-stretch justify-between">    
                        @foreach(['胸高直径[cm]', '樹高[m]', '矢高[cm]', '立木体積[m3]', '立木バイオマス[kg]'] as $field)
                            <div class="mb-4">
                            <label for="{{ $field }}">{{ ucfirst($field) }}</label>
                                <div class="mb-4">
                                    <div class="w-1/2 pr-2">
                                        <select name="{{ $field }}_operator1" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                            <option value="=">=</option>
                                            <option value="<"><</option>
                                            <option value=">">></option>
                                            <option value="<="><=</option>
                                            <option value=">=">>=</option>
                                        </select>
                                    </div>
                                    <div class="w-1/2 pl-2">
                                        <input type="text" name="{{ $field }}_value1" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <select name="{{ $field }}_connector" class="appearance-none block w-144 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                        <option value="and">AND</option>
                                        <option value="or">OR</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="w-1/2 pr-2">
                                        <select name="{{ $field }}_operator2" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                            <option value="=">=</option>
                                            <option value="<"><</option>
                                            <option value=">">></option>
                                            <option value="<="><=</option>
                                            <option value=">=">>=</option>
                                        </select>
                                    </div>
                                    <div class="w-1/2 pl-2">
                                        <input type="text" name="{{ $field }}_value2" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
        
                    <div class="mb-4">
                        <label for="species" class="block text-sm font-medium text-gray-700">樹種:</label>
                        <select name="species[]" multiple class="mt-1 block w-full rounded-md shadow-sm border-gray-300 overflow-y-auto" style="max-height: 65px;">
                            @foreach($speciesList as $species)
                                <option value="{{ $species }}">{{ $species }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <!-- 検索条件名の入力フィールド -->
                    <!--<div class="form-group">-->
                    <!--    <label for="condition_name">検索条件名:</label>-->
                    <!--    <input type="text" name="condition_name" class="form-control" required>-->
                    <!--</div>-->
                
                    <x-button type="submit" name="action" value="search" class="bg-blue-500 rounded-lg">立木検索</x-button>
                    <!--<button type="submit" name="action" value="save" class="btn btn-secondary">検索条件を記録</button>-->
                </form>
                <!-- 検索フォームの終了 -->
            </div>
        </div>
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