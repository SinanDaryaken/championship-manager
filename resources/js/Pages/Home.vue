<template>
    <div class="row mt-5">
        <div class="col-lg-6 ">
            <h3>League</h3>
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
            <router-link :to="{name: 'fixture'}" class="btn btn-outline-primary">
                Generate Fixture
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            teams: {}
        }
    },
    created() {
        this.fetchTeams();
    },
    methods: {
        fetchTeams() {
            axios.get('/api/teams/fetch-all-and-ordered')
                .then((response) => {
                    this.teams = response.data
                }).catch((error) => {
                console.log(error)
            })

        }
    }
}
</script>

<style scoped>

</style>
