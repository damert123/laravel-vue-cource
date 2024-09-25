<script>
import Header from "@/Components/Header.vue";

export default {
    name: "AuthLayout",

    components:{
        Header
    },


}
</script>

<template>
    <Header/>
    <main>
        <slot/>
    </main>

</template>

<style scoped>

</style>
