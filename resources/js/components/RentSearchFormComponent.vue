<template>
    <div>
        <form>
            <h2>地域の選択</h2>
            <ul class="row">
                <li class="col-3 form-group form-check"
                    v-for="(rentalArea, index) in rentalAreas" :key="index">
                    <input type="checkbox"
                        name="rental_area"
                        :value="rentalArea.id"
                        v-model="rentalAreasChecked"
                        class="form-check-input"
                        id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">
                        {{ rentalArea.area_name }}
                    </label>
                </li>
            </ul>
            <h2>条件の選択</h2>
            <table class="table table-bordered my-border">
                <tbody>
                    <tr>
                        <th class="table-head my-bg-secondary">賃料</th>
                        <td>Otto</td>
                    </tr>
                    <tr>
                        <th class="my-bg-secondary">間取り</th>
                        <td>
                            <ul class="row">
                                <li class="col-3 form-group form-check"
                                    v-for="(RentalFloorPlan, index) in RentalFloorPlans"
                                    :key="index">
                                    <input type="checkbox"
                                        name="floor_plan_name"
                                        :value="RentalFloorPlan.id"
                                        v-model="rentalAreasChecked"
                                        class="form-check-input"
                                        id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">
                                        {{ RentalFloorPlan.floor_plan_name }}
                                    </label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</template>

<style scoped>
    .table-head {
        width: 120px;
    }

</style>

<script>
    export default {
        props: {
            InitRentalAreas: Array,
            InitRentalFloorPlans: Array,
        },
        data: function () {
            return {
                rentalAreas: this.InitRentalAreas,
                RentalFloorPlans: this.InitRentalFloorPlans,
                rentalAreasChecked: [],
            }
        },
        mounted() {
            console.log(this.RentalFloorPlans)
        }
    }
</script>
