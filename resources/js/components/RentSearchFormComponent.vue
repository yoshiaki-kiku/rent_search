<template>
    <div
        style="min-width: 768px;"
        class="container mt-2 mb-4 p-4 bg-white border shadow"
    >
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
                        v-model="searchValues.areas"
                        :id="'rentalArea' + rentalArea.id"
                    >
                    <label
                        class="form-check-label"
                        :for="'rentalArea' + rentalArea.id"
                    >
                        {{ rentalArea.name }}
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
                                    name="rent1"
                                    v-model="searchValues.rent1"
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
                                    name="rent2"
                                    v-model="searchValues.rent2"
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
                                        v-model="searchValues.floorPlans"
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
                                        name="options"
                                        :value="option.id"
                                        class="form-check-input"
                                        :id="'option' + option.id"
                                        v-model="searchValues.options"
                                    >
                                    <label
                                        class="form-check-label"
                                        :for="'option' + option.id"
                                    >
                                        {{ option.name }}
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
</template>

<style scoped>
.table-head {
    width: 120px;
}

.btn-result {
    font-size: 1.4em;
    padding: 15px 30px;
}
</style>

<script>
export default {
    props: {
        initRentalAreas: Array,
        initRentalFloorPlans: Array,
        initRentalPropertyOptions: Array
    },
    data: function() {
        return {
            rentalAreas: this.initRentalAreas,
            rentalFloorPlans: this.initRentalFloorPlans,
            rentalPropertyOptions: this.initRentalPropertyOptions,
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
            searchValues: {
                areas: [],
                rent1: null,
                rent2: null,
                floorPlans: [],
                age: null,
                options: []
            }
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
            handler: function() {
                console.log(this.searchValues.options);
            },
            deep: true
        }
    },

    mounted() {
        console.log(this.rentalPropertyOptions);
    }
};
</script>
