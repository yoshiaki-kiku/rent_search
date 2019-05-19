<template>
    <div>
        <div class="property-count container mb-3 p-2 text-center sticky-top my-min-width">
            該当物件 <span class="count-num">{{ propertyCount }}</span> 件
        </div>
        <div class="container mt-2 mb-4 p-4 bg-white border shadow my-min-width">
            <form>
                <div class="d-flex align-items-center step-header">
                    <div class="step-header-active">ステップ1</div>
                    <h2>地域の選択 <span>(複数選択可)</span></h2>
                </div>
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
                            :id="'rental_area' + rentalArea.id"
                        >
                        <label
                            class="form-check-label"
                            :for="'rental_area' + rentalArea.id"
                        >
                            {{ rentalArea.name }} ({{ areaPropertyCount[rentalArea.id] }})
                        </label>
                    </li>
                </ul>
                <div class="d-flex align-items-center step-header">
                    <div :class="step2ActiveCheck">ステップ2</div>
                    <h2>条件の指定</h2>
                </div>
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
                                        :disabled="nextStep"
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
                                        :disabled="nextStep"
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
                                            :disabled="nextStep"
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
                                            :disabled="nextStep"
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
                                            :disabled="optionDisableCheck(nextStep, optionDisable[option.id])"
                                        >
                                        <label
                                            class="form-check-label"
                                            :for="'option' + option.id"
                                        >
                                            {{ option.name }} ({{ optionCounts[option.id] != null ? optionCounts[option.id] : '--'}})
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
.property-count {
    background-color: #cae7f2;
    font-weight: bold;
    font-size: 1.2em;
    border: 1px solid #208dc3;
    color: #666;
}
.count-num {
    padding: 0px 6px;
    font-size: 1.5em;
    color: #da5019;
    font-family: "Roboto Mono", monospace;
}
.step-header {
    margin-bottom: 10px;
}
.step-header div {
    font-size: 1.2em;
    color: #fff;
    padding: 4px 10px 4px 10px;
}

.step-header-active {
    background-color: #a0d3e8;
}

.step-header-nonactive {
    background-color: #a3a3a3;
}

.step-header h2 {
    margin: 0px;
    padding: 3px 0px 0px 10px;
}
.step-header h2 span {
    font-size: 0.5em;
}
</style>

<script>
import axios from "axios";

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
            optionCounts: [],
            // フォームの有効無効
            // 地域未選択時に他フォームを無効化するための変数
            nextStep: true,
            // オプションが持つ該当物件がなければチェックボタンを無効化する
            optionDisable: [],
            classStepHeaderFlag: {
                active: "step-header-active",
                nonActive: "step-header-nonactive"
            },
            // カウントアップ用のsetIntervalの処理終了に利用
            countTimer: ""
        };
    },
    watch: {
        // 地域選択の値を監視
        "searchValues.area": function() {
            // 地域の選択がなければ、条件の選択ができないように設定
            if (this.searchValues.area.length > 0) {
                this.nextStep = false;
            } else {
                this.nextStep = true;
            }
        },
        // フォーム全体の値を監視
        searchValues: {
            handler: async function() {
                // 地域未選択時は処理しない;
                if (this.searchValues.area.length < 1) {
                    this.propertyCount = "--";
                    return;
                }

                try {
                    const response = await axios.post(
                        "/property_count",
                        this.searchValues
                    );

                    let updatedPropertyCount = response.data.propertyCount;
                    let updatedOptionCounts = response.data.optionCounts;

                    if (this.propertyCount == "--") {
                        this.propertyCount = 0;
                    }

                    // 該当物件のカウントを上下させる
                    this.countUpDown(this.propertyCount, updatedPropertyCount);

                    // オプションの該当件数を更新
                    this.optionCountUpdate(updatedOptionCounts);
                } catch (error) {
                    console.log("エラー");
                    console.log(this.searchValues.area);
                    this.propertyCount = "--";
                }
            },
            deep: true
        }
    },

    methods: {
        // 該当検討のカウントアップダウンのアニメーション
        countUpDown: function(fromNum, toNum) {
            // 現在のカウントアップを処理をクリアする
            if (this.countTimer) {
                clearInterval(this.countTimer);
            }

            // どのくらい時間をかけてカウントするか
            let count_duration;
            const startTime = Date.now();
            const rangeChange = Math.abs(toNum - fromNum);

            // 変動幅が小さい数値ではカウント時間を短くする
            if (rangeChange < 10) {
                count_duration = 100;
            } else if (rangeChange < 100) {
                count_duration = 500;
            } else {
                count_duration = 1000;
            }

            this.countTimer = setInterval(() => {
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
                    // 地域選択をしているか再確認する
                    this.propertyCount =
                        this.searchValues.area.length > 0 ? toNum : "--";
                    clearInterval(this.countTimer);
                }
                // intervalの数値を大きくすれば緩やかな見え方になる
            }, 16);
        },

        // オプション項目のフォームを無効を切り替える
        allOptionDisable: function() {
            Object.keys(this.rentalPropertyOptions).forEach(key => {
                let optionId = this.rentalPropertyOptions[key].id;
                this.optionDisable[optionId] = true;
            });
        },

        // オプションフォームの有効無効を判定する
        optionDisableCheck: function(nextStep, optionDisable) {
            let flag;
            if (nextStep) {
                flag = true;
            } else {
                flag = optionDisable ? true : false;
            }
            return flag;
        },

        // オプションの該当件数を更新
        optionCountUpdate: function(updatedOptionCounts) {
            // 0件 or 該当なしの場合はボタンの無効化
            Object.keys(this.rentalPropertyOptions).forEach(key => {
                let optionId = this.rentalPropertyOptions[key].id;
                if (!updatedOptionCounts[optionId]) {
                    this.optionCounts[optionId] = 0;
                    this.optionDisable[optionId] = true;
                } else {
                    // 現在選択中のオプションの件数表示は「--」にする
                    if (this.searchValues.option.includes(optionId)) {
                        this.optionCounts[optionId] = "--";
                    }
                    // 該当件数を入れる
                    else {
                        this.optionCounts[optionId] =
                            updatedOptionCounts[optionId];
                    }
                    this.optionDisable[optionId] = false;
                }
            });
        }
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
        },

        step2ActiveCheck: function() {
            return !this.nextStep
                ? this.classStepHeaderFlag.active
                : this.classStepHeaderFlag.nonActive;
        }
    },

    created() {
        this.allOptionDisable();
    },

    mounted() {
        console.log(this.rentalPropertyOptions);
    }
};
</script>
