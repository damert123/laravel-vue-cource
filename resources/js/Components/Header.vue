<script>


import {Link} from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";


export default {
    name: "Header",

    components:{
        Link,
        ApplicationLogo
    },

    data(){
      return {
         profile: this.$page.props.profile || null,
      }
    },

    computed:{
        user(){
            return this.$page.props.auth.user
        }
    },

    mounted() {
        if (!this.profile) {
            this.fetchProfile();
        }
    },

    props:{
        showHeader:{
            type: Boolean,
            default: true
        },

    },


    methods:{
            fetchProfile() {
                axios.get(route('user.profile'))
                    .then(res =>{
                        this.profile = res.data;
                    })
                    .catch(err =>{
                        console.log(err);
                    })

            },

            handleLogout(){
             this.$inertia.post('/logout', {}, {
                 onFinish: () => {
                     this.profile = null;
                 }
             })
            }
        },

        // handleLogout(){
        //     this.$inertia.post('/logout', {}, {
        //         onFinish: () => {
        //             localStorage.removeItem('userProfile'); // Удаляем профиль из localStorage
        //         }
        //     });
        // }

        // logout() {
        //     // Здесь выполняем запрос на выход
        //     axios.post('/logout').then(res => {
        //         localStorage.removeItem('userProfile'); // Удаляем профиль из localStorage
        //
        //     });
        // }

}
</script>

<template>
<header v-if="showHeader" class="bg-customBlack text-white py-2 mb-12">

    <div class="flex justify-around">

        <div class="h-8 w-8 m-1">
            <ApplicationLogo/>
        </div>



        <nav class="flex space-x-4 items-center">
            <Link :href="route('main.index')" class="text-lg relative border-b-2 border-transparent hover:border-red-500 transition-all duration-100 ease-in">HOME</Link>
            <Link :href="route('admin.posts.index')" class="text-lg relative border-b-2 border-transparent hover:border-red-500 transition-all duration-100 ease-in">POSTS</Link>
        </nav>

        <div class="flex items-center space-x-4">
            <span class="font-semibold">{{ profile ? profile.login : ''  }}</span>
            <button @click="handleLogout" href="/logout" method="post" as="button" class="bg-red-500 px-3 py-1 rounded hover:bg-red-700 transition-all duration-100 ease-in">
                Logout
            </button>


        </div>


    </div>


</header>
</template>

<style scoped>




</style>
