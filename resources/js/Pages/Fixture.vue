<template>
    <div class="row m-auto mt-5">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3" v-for="(fixture, week) in fixtures">
                    <table class="table">
                        <thead class="table-dark">
                        <tr>
                            <td>Fixtures</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in fixture">
                            <td class="d-flex justify-content-between">
                                <span>Week {{ item.number_of_week }}</span>
                                <span>{{ item.home_team }}</span>
                                <span>{{ item.home_team_score + ' - ' + item.away_team_score }}</span>
                                <span>{{ item.away_team }}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <router-link :to="{name: 'game'}" class="btn btn-outline-primary">
                        Start Simulation
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Fixture",
    data() {
        return {
            fixtures: {},
        }
    },
    created() {
        this.prepare();
    },
    methods: {
        prepare() {
            axios.get('/api/fixtures/prepare')
                .then((response) => {
                    this.getFixtures()
                }).catch((error) => {
                console.log(error)
            })
        },
        getFixtures() {
            axios.get('/api/fixtures/fetch-group-by-week')
                .then((response) => {
                    this.fixtures = response.data
                    console.log(this.fixtures);
                }).catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
