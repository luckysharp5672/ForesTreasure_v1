<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ForestInformation;
use App\Models\SearchCondition;


class TimberSearchController extends Controller
{
    public function index()
    {
        $speciesList = ForestInformation::distinct()->pluck('species');
        return view('timber_search', ['speciesList' => $speciesList]);
    }
    
    public function searchResults(Request $request)
    {   
        $action = $request->input('action');
    
        if ($action === 'save') {
            $this->saveSearchConditions($request);
            return back()->with('success', '検索条件を保存しました。');
        }
        
        $query = ForestInformation::query();
        
        // 数値フィールドの条件を処理
        $fields = ['diameter', 'height', 'arrow_height', 'volume', 'biomass'];
        foreach ($fields as $field) {
            if ($request->input("{$field}_value1")) {
                $operator1 = $request->input("{$field}_operator1");
                $value1 = $request->input("{$field}_value1");
                $query->where($field, $operator1, $value1);
            }
            
            if ($request->input("{$field}_value2")) {
                $operator2 = $request->input("{$field}_operator2");
                $value2 = $request->input("{$field}_value2");
                $connector = $request->input("{$field}_connector");
    
                if ($connector === 'and') {
                    $query->where($field, $operator2, $value2);
                } else {
                    $query->orWhere($field, $operator2, $value2);
                }
            }
        }
        
        // 種類の条件を処理
        if ($request->filled('species')) {
            $species = $request->input('species');
            $query->whereIn('species', $species);
        }

        // 経度と緯度の条件を処理（簡易的な距離計算の例）
        if ($request->filled('longitude') && $request->filled('latitude') && $request->filled('radius')) {
            $longitude = $request->input('longitude');
            $latitude = $request->input('latitude');
            $radius = $request->input('radius');
            // 簡易的な距離計算を使用して、指定された半径内のデータをフィルタリング
            $query->whereRaw("
                (6371 * acos(cos(radians(?)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians(latitude)))) < ?
            ", [$latitude, $longitude, $latitude, $radius]);
        }
    
        $results = $query->get();
    
        return view('timber_search_results', ['results' => $results]);
    }
    
    protected function saveSearchConditions(Request $request)
    {
        $condition = new SearchCondition();
        $condition->user_id = auth()->id();
        $condition->condition_name = $request->input('condition_name');
        
        // 数値フィールドの条件をJSON形式で保存
        $numericFields = ['diameter', 'height', 'arrow_height', 'volume', 'biomass'];
        $numericConditions = [];
        foreach ($numericFields as $field) {
            $numericConditions[$field] = [
                'operator1' => $request->input("{$field}_operator1"),
                'value1' => $request->input("{$field}_value1"),
                'connector' => $request->input("{$field}_connector"),
                'operator2' => $request->input("{$field}_operator2"),
                'value2' => $request->input("{$field}_value2")
            ];
        }
        $condition->numeric_conditions = json_encode($numericConditions);

        // 種類の条件をJSON形式で保存
        if ($request->filled('species')) {
            $condition->species_conditions = json_encode($request->input('species'));
        }

        // 経度、緯度、および半径の条件を保存
        $condition->longitude = $request->input('longitude');
        $condition->latitude = $request->input('latitude');
        $condition->radius = $request->input('radius');
    
        $condition->save();
    }
}
