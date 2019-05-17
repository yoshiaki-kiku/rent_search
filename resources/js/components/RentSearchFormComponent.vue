<template>
    <div>
        <div class="container mb-3 p-2 text-center sticky-top bg-success my-min-width">
            <span class="text-white">
                該当物件
                <span class="count-num">{{ propertyCount }}</span>
                件
            </span>
        </div>
        <div class="container mt-2 mb-4 p-4 bg-white border shadow my-min-width">
            <form>
                <h2>地域の選択</h2>
                <ul class="row">
                    <li
                        class="col-3 form-group form-check"
                        v-for="(rentalArea, index) in rentalAreas"
                        :key="index"
                    >
                        <input
                            type="checkbox"
                            name="rental_area"
                            :value="rentalArea.id"
                            class="form-check-input"
                            v-model="searchValues.area"
                            :id="'rentalArea' + rentalArea.id"
                        >
                        <label
                            class="form-check-label"
                            :for="'rentalArea' + rentalArea.id"
                        >
                            {{ rentalArea.name }} ({{ areaPropertyCount[rentalArea.id] }})
                        </label>
                    </li>
                </ul>
                <h2>条件の選択</h2>
                <table class="table table-bordered my-border">
                    <tbody>
                        <tr>
                            <th class="table-head my-bg-secondary">賃料</th>
                            <td class="py-0 pt-3">
                                <div class="form-group row mx-3">
                                    <select
                                        name="rent_lower_limit"
                                        v-model="searchValues.rent_lower_limit"
                                        class="form-control col-4"
                                    >
                                        <option
                                            v-for="(rent, key, index) in rentArr"
                                            :value="rent"
                                            :key="index"
                                        >
                                            {{ key }}
                                        </option>
                                    </select>
                                    <div class="col-2 text-center">
                                        ～
                                    </div>
                                    <select
                                        name="rent_upper_limit"
                                        v-model="searchValues.rent_upper_limit"
                                        class="form-control col-4"
                                    >
                                        <option
                                            v-for="(rent, key, index) in rentArr"
                                            :value="rent"
                                            :key="index"
                                        >
                                            {{ key }}
                                        </option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="my-bg-secondary">間取り</th>
                            <td class="py-0 pt-3">
                                <ul class="row my-0 py-0">
                                    <li
                                        class="col-4 form-group form-check"
                                        v-for="(rentalFloorPlan, index) in rentalFloorPlans"
                                        :key="index"
                                    >
                                        <input
                                            type="checkbox"
                                            name="floor_plan"
                                            :value="rentalFloorPlan.id"
                                            v-model="searchValues.floor_plan"
                                            class="form-check-input"
                                            :id="'rentalFloorPlan' + rentalFloorPlan.id"
                                        >
                                        <label
                                            class="form-check-label"
                                            :for="'rentalFloorPlan' + rentalFloorPlan.id"
                                        >
                                            {{ rentalFloorPlan.name }}
                                        </label>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th class="my-bg-secondary">築年数</th>
                            <td class="py-0 pt-3">
                                <ul class="row my-0 py-0">
                                    <li
                                        class="col-4 form-group form-check"
                                        v-for="(age, key, index) in ages"
                                        :key="index"
                                    >
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="age"
                                            :id="'age' + index"
                                            :value="age"
                                            v-model="searchValues.age"
                                        >
                                        <label
                                            class="form-check-label"
                                            :for="'age' + index"
                                        >
                                            {{ key }}
                                        </label>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th class="my-bg-secondary">オプション</th>
                            <td class="py-0 pt-3">
                                <ul class="row my-0 py-0">
                                    <li
                                        class="col-4 form-group form-check"
                                        v-for="(option, key, index) in rentalPropertyOptions"
                                        :key="index"
                                    >
                                        <input
                                            type="checkbox"
                                            name="option"
                                            :value="option.id"
                                            class="form-check-input"
                                            :id="'option' + option.id"
                                            v-model="searchValues.option"
                                        >
                                        <label
                                            class="form-check-label"
                                            :for="'option' + option.id"
                                        >
                                            {{ option.name }} ({{ optionCounts[option.id] ? optionCounts[option.id] : '--'}})
                                        </label>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <button class="btn btn-primary btn-result">検索結果を見る</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.table-head {
    width: 120px;
}

.btn-result {
    font-size: 1.4em;
    padding: 15px 30px;
}
.my-min-width {
    min-width: 768px;
}
.count-num {
    padding: 0px 6px;
    font-size: 1.6em;
    font-family: "Roboto Mono", monospace;
}
</style>

<script>
import axios from "axios";
import { log } from "util";

export default {
    props: {
        initAreaPropertyCount: Object,
        initRentalAreas: Array,
        initRentalFloorPlans: Array,
        initRentalPropertyOptions: Array
    },
    data: function() {
        return {
            // 地域ごとの物件数
            areaPropertyCount: this.initAreaPropertyCount,
            // 地域
            rentalAreas: this.initRentalAreas,
            // 間取り
            rentalFloorPlans: this.initRentalFloorPlans,
            // 物件の細かい条件
            rentalPropertyOptions: this.initRentalPropertyOptions,
            // 賃料の上限下限
            rentUpperLimit: 50,
            rentLowerLimit: 3,
            // 築年数
            ages: {
                指定なし: null,
                新築: 0,
                "3年以内": 3,
                "5年以内": 5,
                "10年以内": 10,
                "15年以内": 15,
                "20年以内": 20,
                "25年以内": 25,
                "30年以内": 30
            },
            // formのnameと同じ命名にするため
            // ケバブケースを利用
            searchValues: {
                area: [],
                rent_lower_limit: null,
                rent_upper_limit: null,
                floor_plan: [],
                age: null,
                option: []
            },
            // 該当物件数
            propertyCount: "--",
            // オプションの該当件数
            optionCounts: []
        };
    },
    computed: {
        // 賃料選択の配列を作成
        rentArr: function() {
            let rent = {};
            let showIndex;

            // 3～10万までは0.5刻みで増加
            // 10～20万までは1万刻みで増加
            // 20～50万までは10万刻みで増加
            rent[`指定なし`] = null;
            for (
                let index = this.rentLowerLimit - 0.5;
                index <= this.rentUpperLimit;

            ) {
                if (index < 10) {
                    index += 0.5;
                } else if (index < 20) {
                    index += 1;
                } else {
                    index += 10;
                }

                // 10万以下の小数点処理
                showIndex = index < 10 ? index.toFixed(1) : index;
                // 万単位を数値に変更して格納
                rent[`${showIndex}万`] = index * 10000;
            }

            return rent;
        }
    },
    watch: {
        searchValues: {
            handler: async function() {
                const response = await axios.post(
                    "/property_count",
                    this.searchValues
                );

                let _propertyCount = response.data.propertyCount;
                let _optionCounts = response.data.optionCounts;

                if (this.propertyCount == "--") {
                    this.propertyCount = 0;
                }

                // 該当物件のカウントを上下させる
                this.countUpDown(this.propertyCount, _propertyCount);

                Object.keys(_optionCounts).forEach(key => {
                    this.optionCounts[key] = _optionCounts[key];
                });
            },
            deep: true
        }
    },

    methods: {
        // 該当検討のカウントアップダウンのアニメーション
        countUpDown: function(fromNum, toNum) {
            // どのくらい時間をかけてカウントするか
            let count_duration;
            const startTime = Date.now();
            const rangeChange = Math.abs(toNum - fromNum);

            // 変動幅が小さい数値ではカウント期間を短くする
            if (rangeChange < 10) {
                count_duration = 100;
            } else if (rangeChange < 100) {
                count_duration = 500;
            } else if (rangeChange < 500) {
                count_duration = 1000;
            } else {
                count_duration = 2000;
            }

            const timer = setInterval(() => {
                // 現在の経過時間
                const elapsedTime = Date.now() - startTime;
                // 処理
                const progress = elapsedTime / count_duration;

                // 指定期間以下は処理を続ける
                if (progress < 1) {
                    this.propertyCount = Math.floor(
                        fromNum + progress * (toNum - fromNum)
                    );
                } else {
                    this.propertyCount = toNum;
                    clearInterval(timer);
                }
                // intervalの数値を大きくすれば緩やかな見え方になる
            }, 16);
        }
    },

    mounted() {
        console.log(this.areaPropertyCount[1]);
        console.log(this.rentalAreas);
    }
};
</script>
