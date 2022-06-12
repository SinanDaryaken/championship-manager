<template>
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <table class="table">
                        <thead class="table-dark">
                        <tr>
                            <td>Team</td>
                            <td>Points</td>
                            <td>Won</td>
                            <td>Draw</td>
                            <td>Lost</td>
                            <td>Goal againts</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="team in teams">
                            <td>{{ team.name }}</td>
                            <td>{{ team.points }}</td>
                            <td>{{ team.won ? team.won : 0 }}</td>
                            <td>{{ team.drawn ? team.drawn : 0 }}</td>
                            <td>{{ team.lost ? team.lost : 0 }}</td>
                            <td>{{ team.goal_average }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12" v-for="(fixture, week) in fixtures">
                            <table class="table">
                                <thead class="table-dark">
                                <tr>
                                    <td>Fixture</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in fixture">
                                    <td class="d-flex justify-content-between">
                                        <span>{{ item.home_team }}</span>
                                        <span>{{ item.home_team_score + ' - ' + item.away_team_score }}</span>
                                        <span>{{ item.away_team }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <table class="table">
                        <thead class="table-dark">
                        <tr>
                            <td>Prediction</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="predict in predictions">
                            <td>{{ predict.name }}</td>
                            <td>{{ predict.percentage }}%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-lg-12 d-flex justify-content-around">
            <button class="btn btn-primary" @click="completeGame" :disabled="week >= weekCount">Complete Game</button>
            <button class="btn btn-primary" @click="playGame" :disabled="week >= weekCount">Play</button>
            <button class="btn btn-danger" @click="refresh">Restart</button>
        </div>

    </div>
</template>

<script>
export default {
    name: "Game",
    data() {
        return {
            teams: {},
            fixtures: {},
            predictions: {},
            count: 1,
            totalWeek: '',
        }
    },
    created() {
        this.fetchTeams();
        this.fetchFixtures();
        this.fetchCountedFixturesWeek();
    },
    methods: {
        fetchTeams() {
            axios.get('/api/teams/fetch-all-and-ordered')
                .then((response) => {
                    this.teams = response.data
                }).catch((error) => {
                console.log(error)
            })

        },
        fetchCountedFixturesWeek() {
            axios.get('/api/fixtures/fetch-counted-fixtures-week')
                .then((response) => {
                    this.totalWeek = response.data;
                }).catch((error) => {
                console.log(error)
            })

        },
        fetchFixtures() {
            axios.get('/api/fixtures/fetch-group-by-week')
                .then((response) => {
                    this.fixtures = response.data
                }).catch((error) => {
                console.log(error)
            })
        },
        predict() {
            axios.get('/api/games/predict')
                .then((response) => {
                    this.predictions = response.data
                }).catch((error) => {
                console.log(error)
            })
        },
        playGame() {
            axios.get('/api/games/play-game-by-week/' + this.count)
                .then((response) => {
                    this.count++;
                    this.fetchTeams();
                    this.fetchFixtures();

                    if (this.count === this.totalWeek) {
                        this.predictions = {};
                    } else if (this.count >= this.totalWeek - 2) {
                        this.predict();
                    }
                }).catch((error) => {
                console.log(error)
            })
        },
        completeGame() {
            axios.get('/api/games/complete-game')
                .then((response) => {
                    this.fetchTeams();
                    this.fetchFixtures();
                    this.count = 1;
                }).catch((error) => {
                console.log(error)
            })
        },
        refresh() {
            axios.get('/api/fixtures/refresh')
                .then((response) => {
                    this.count = 1;
                    this.fetchTeams();
                    this.fetchFixtures();
                    this.predictions = {};
                }).catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
