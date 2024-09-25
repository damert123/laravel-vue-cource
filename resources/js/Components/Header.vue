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
        },
    },

    computed:{
      login(){
          return this.$page.props.auth.login;
      },
      user(){
          return this.$page.props.auth.user;
      }
    },

    methods:{

            handleLogout(){
             this.$inertia.post('/logout');
            },

            handleLogin() {
                this.$inertia.get('/login'); // Перенаправление на страницу логина
            }
        },



}
</script>

<template>
<header v-if="showHeader" class="bg-customBlack text-white py-2 mb-12">

    <div class="flex justify-around">

        <div class="h-8 w-8 m-1">
            <ApplicationLogo/>
        </div>



        <nav class="flex space-x-4 items-center">
            <Link :href="route('dashboard')" class="text-lg relative border-b-2 border-transparent hover:border-red-500 transition-all duration-100 ease-in">HOME</Link>
            <Link :href="route('admin.posts.index')" class="text-lg relative border-b-2 border-transparent hover:border-red-500 transition-all duration-100 ease-in">POSTS</Link>
            <Link :href="route('admin.index')" class="text-lg relative border-b-2 border-transparent hover:border-red-500 transition-all duration-100 ease-in">ADMIN</Link>
        </nav>

        <div class="flex items-center space-x-4">
            <Link v-if="login" :href="route('main.index')" class="font-semibold">{{ login }}</Link>
            <button v-if="!user" @click="handleLogin" class="bg-blue-500 px-3 py-1 rounded hover:bg-blue-700 transition-all duration-100 ease-in">
                Войти
            </button>
            <button v-if="user" @click="handleLogout" class="bg-red-500 px-3 py-1 rounded hover:bg-red-700 transition-all duration-100 ease-in">
                Выйти
            </button>


        </div>


    </div>


</header>
</template>

<style scoped>




</style>
