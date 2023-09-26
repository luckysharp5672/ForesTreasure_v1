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
            
            <label for="owned_forests">所有している森林:</label>
            <select name="owned_forests[]" multiple>
                @foreach($ownedForests as $forest)
                    <option value="{{ $forest->id }}">{{ $forest->forest_name }}</option>
                @endforeach
            </select>
            
            <div id="myMap" style="position:relative;width:600px;height:400px;"></div>
            <label for="radius">検索範囲の半径 (m)</label>
            <input type="number" name="radius" id="radius">

            
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

    <!-- Bing Maps APIのスクリプト -->
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=loadMapScenario&key=ApUslpO8ghJ6mpe35ApW427eo72OmGGHg9ETniAK37AnLv7g6GzjaiEkrMB1cowL' async defer></script>
    
    <script type="text/javascript">
        function loadMapScenario() {
            var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {});
            Microsoft.Maps.Events.addHandler(map, 'click', function (e) {
                var point = new Microsoft.Maps.Point(e.getX(), e.getY());
                var loc = e.target.tryPixelToLocation(point);
                var latitude = loc.latitude;
                var longitude = loc.longitude;
        
                // 座標を入力フィールドに反映
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
        
                // ピンを追加
                <!--var pin = new Microsoft.Maps.Pushpin(loc, null);-->
                <!--map.entities.push(pin);-->
                @foreach($ownedForests as $forest)
                    var loc = new Microsoft.Maps.Location({{ $forest->latitude }}, {{ $forest->longitude }});
                    var pin = new Microsoft.Maps.Pushpin(loc, {color: 'red'});
                    map.entities.push(pin);
                @endforeach
            });
        }
    </script>
    
</x-app-layout>