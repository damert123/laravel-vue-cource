<script>


import {Link} from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
export default {
    name: "Header",

    components:{
        Link,
        ApplicationLogo
    },

    props:{
        showHeader:{
            type: Boolean,
            default: true
        }
    }

}
</script>

<template>
<header v-if="showHeader" class="bg-gray-800 text-white py-2 mb-12">

    <div class="flex justify-around">

        <div class="h-8 w-8 m-1">
            <ApplicationLogo/>
        </div>



        <nav class="flex space-x-4 items-center">
            <Link :href="route('main.index')" class="text-lg relative border-b-2 border-transparent hover:border-red-500 transition-all duration-100 ease-in">HOME</Link>
            <Link :href="route('admin.posts.index')" class="text-lg relative border-b-2 border-transparent hover:border-red-500 transition-all duration-100 ease-in">POSTS</Link>
        </nav>

        <div class="flex items-center space-x-4">
            <span class="font-semibold">Username</span>
            <Link href="/logout" method="post" as="button" class="bg-red-500 px-3 py-1 rounded hover:bg-red-700 transition-all duration-100 ease-in">
                Logout
            </Link>
        </div>


    </div>


</header>
</template>

<style scoped>




</style>
