<template>
    <div>
        <HeaderComponent/>
        <router-view></router-view>
    </div>
</template>

<script>
import HeaderComponent from '../Components/Includes/HeaderComponent';

export default {
    name: "Main",
    components: {
        HeaderComponent,
    },
}
</script>
