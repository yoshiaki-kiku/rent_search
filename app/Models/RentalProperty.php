<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DB;

class RentalProperty extends Model
{
    public function rentalPropertyOptions()
    {
        return $this->belongsToMany('App\Models\RentalPropertyOption', "property_option");
    }


    /**
     * 地域ごとの物件数を取得する
     * 地域IDがkey、valueが物件数の配列を返す
     *
     * @return array
     */
    public function getAreaPropertyCount()
    {
        $areaPropertyCountArr = [];
        $rentalProperty = RentalProperty::all();
        foreach ($rentalProperty as $value) {
            if (!empty($areaPropertyCountArr[$value->area])) {
                $areaPropertyCountArr[$value->area] += 1;
            } else {
                $areaPropertyCountArr[$value->area] = 1;
            }
        }

        return collect($areaPropertyCountArr);
    }

    /**
     * @param PropertyCount $request
     * @return void
     */
    /**
     * 全条件を指定して物件検索をかけるクエリを作成
     *
     * @return void
     */
    public function getPropertyQueryBuild($request)
    {
        Log::debug($request);

        $query = RentalProperty::query();

        // サブクエリとして利用する中間テーブルの変形、
        // 賃貸IDをベースとして
        // group_concatを利用してコンマ区切りでオプションIDを束ねる
        $subQuery = PropertyOption::query()->select(
            "rental_property_id",
            DB::raw("group_concat(rental_property_option_id) as option_list")
        )->groupBy("rental_property_id");

        // サブクエリと連結して、オプションIDで検索できるようにする
        $query = $query->leftJoinSub($subQuery, "option_table", function ($join) {
            $join->on('rental_properties.id', '=', 'option_table.rental_property_id');
        });

        // ------------------------------------
        // 地域
        // ------------------------------------
        if (!empty($request->area)) {
            $query = $query
                ->whereIN("area", $request->area);
        }

        // ------------------------------------
        // 条件
        // ------------------------------------
        // 賃料
        // どちらも設定されている場合
        if (!empty($request->rent_upper_limit) && !empty($request->rent_lower_limit)) {

            // 同じ場合はその同価格のみ検索
            if ($request->rent_upper_limit === $request->rent_lower_limit) {
                $query = $query->where("rent",  $request->rent_upper_limit);
            }
            // 2つ価格が違う場合範囲で検索
            else {
                // 価格の上下が逆もありえるのでソートして低い価格が先にくるように
                $rentArr = [$request->rent_lower_limit, $request->rent_upper_limit];
                asort($rentArr);
                $query = $query->whereBetween("rent", $rentArr);
            }
        }
        // rent_upper_limitのみ存在は、その価格以上の賃料
        elseif (!empty($request->rent_upper_limit) && empty($request->rent_lower_limit)) {
            $query = $query
                ->where("rent", "<=", $request->rent_upper_limit);
        }
        // rent_lower_limitのみ存在は、その価格以下の賃料
        elseif (empty($request->rent_upper_limit) && !empty($request->rent_lower_limit)) {
            $query = $query
                ->where("rent", ">=", $request->rent_lower_limit);
        }

        // 間取り
        if (!empty($request->floor_plan)) {
            $query = $query
                ->whereIN("floor_plan", $request->floor_plan);
        }

        // 築年数
        if (isset($request->age)) {
            // 新築は0年を指定
            if ($request->age == 0) {
                $query = $query->where("age", $request->age);
            }
            // 築年数指定はその築年数以内を探す
            else {
                $query = $query->where("age", "<=", $request->age);
            }
        }

        // オプション
        if (!empty($request->option)) {
            // 中間テーブルでgroup_concatしたコンマ区切りのoption_listを検索
            foreach ($request->option as $option) {
                $query = $query->whereRaw("find_in_set(?, option_list)", [$option]);
            }
        }

        return $query;
    }

    /**
     * 各種条件で取得した結果をサブクエリとして
     * オプションIDに該当する賃貸物件の数を取得する
     *
     * @param $subQuery
     * @return void
     */
    public function getOptionCount($subQuery)
    {
        $query = DB::table(DB::raw('(' . $subQuery->toSql() . ') as sub'))
            ->mergeBindings($subQuery->getQuery());

        $RentalPropertyOptions = RentalPropertyOption::get("id");
        foreach ($RentalPropertyOptions as $option) {
            $name = "id_" .  $option->id;
            $query->selectRaw(
                "COUNT(find_in_set(? ,option_list) or null) as {$name}",
                [$option->id]
            );
        }

        // 利用しやすいようにキーを調整して配列を整える
        $counts = [];
        $gets = $query->first();
        $gets = json_decode(json_encode($gets), true);
        foreach ($gets as  $key => $value) {
            $key = str_replace("id_", "", $key);
            $counts[$key] = $value;
        }

        return $counts;
    }
}
