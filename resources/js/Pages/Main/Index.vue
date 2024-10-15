<script>

import AuthLayout from "@/Layouts/AuthLayout.vue";


export default {
    name: "Index",
    layout: AuthLayout,
    props:{
        userPosts: Object
    },

    data(){
        return{
            comments: {},
            isShowed: {},

        }
    },

    methods:{
        getComments(post) {
            if (!this.comments[post.id]) {
                axios.get(`posts/${post.id}/comments`)
                    .then(res => {
                        this.comments[post.id] = res.data.data;
                        this.isShowed[post.id] = true;
                    });
            } else {
                this.isShowed[post.id] = !this.isShowed[post.id];
            }
        }
    },


}
</script>

<template>

    <div class="flex justify-center">
        <h1 class="text-2xl mt-12 font-bold">Welcome to the Homepage !</h1>
    </div>

    <div v-for="post in userPosts" class="mb-8 pb-4">
        <div class="max-w-2xl mx-auto bg-customBlack rounded-xl shadow-md overflow-hidden">
            <div class="p-6">

                <!-- Категория поста -->
                <div class="inline-block mb-4 px-3 py-1 bg-gray-300 text-white text-sm font-semibold rounded-full">
                    {{ post.category_id.title }}
                </div>

                <!-- Заголовок поста -->
                <h1 class="text-2xl font-bold text-white mb-4">{{ post.title }}</h1>

                <div class="flex flex-wrap mb-4">
                <span v-for="tag in post.tags" :key="tag.id" class="inline-block bg-blue-200 text-blue-700 text-sm px-3 py-1 mr-2 mb-2 rounded-full">
                    {{ tag.name }}
                </span>
                </div>

                <!-- Изображение поста -->
                <img class="w-full h-auto object-cover mb-4" :src="post.image_path" alt="Post Image">

                <!-- Контент поста -->
                <p class="text-white mb-4">{{ post.content }}</p>

                <!-- Дополнительная информация: просмотры, профиль автора -->
                <div class="text-sm text-gray-400 mb-4">
                    <span class="mr-4">Published on: {{ post.date }}</span>
                    <span>By Profile: {{ post.username }}</span>
                </div>

                <!-- Кнопки для лайков, комментариев и просмотров -->
                <div class="flex items-center justify-between space-x-6">

                    <div class="flex items-center space-x-6">
                        <!-- Кнопка для лайков с иконкой -->
                        <button class="flex items-center space-x-2 text-white hover:text-blue-600 transition duration-150 ">
                            <svg viewBox="0 0 46 41" class="w-6 h-6" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-width="4.16667" stroke-linecap="round" stroke-linejoin="round"  d="M13.625 2.33331C7.29683 2.33331 2.16663 7.46352 2.16663 13.7916C2.16663 25.25 15.7083 35.6666 23 38.0896C30.2916 35.6666 43.8333 25.25 43.8333 13.7916C43.8333 7.46352 38.7031 2.33331 32.375 2.33331C28.5 2.33331 25.0729 4.25727 23 7.20206C21.9432 5.69726 20.5395 4.46916 18.9076 3.62168C17.2758 2.77419 15.4638 2.33228 13.625 2.33331Z" />
                            </svg>
                            <span>{{ post.like_count }}</span>
                        </button>

                        <!-- Кнопка для комментариев с иконкой -->
                        <button @click="getComments(post)"  class="flex items-center space-x-2 text-white hover:text-blue-600 transition duration-150">
                            <svg v-if="!isShowed[post.id]" class="w-6 h-6" viewBox="0 0 42 42" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-width="4.16667" stroke-linecap="round" stroke-linejoin="round" d="M21 39.75C24.7084 39.75 28.3335 38.6503 31.4169 36.5901C34.5004 34.5298 36.9036 31.6014 38.3227 28.1753C39.7419 24.7492 40.1132 20.9792 39.3897 17.3421C38.6663 13.7049 36.8805 10.364 34.2582 7.74176C31.636 5.11952 28.2951 3.33376 24.6579 2.61028C21.0208 1.88681 17.2508 2.25812 13.8247 3.67727C10.3986 5.09641 7.47022 7.49964 5.40995 10.5831C3.34967 13.6665 2.25 17.2916 2.25 21C2.25 24.1 3 27.0229 4.33333 29.5979L2.25 39.75L12.4021 37.6667C14.9771 39 17.9021 39.75 21 39.75Z" />
                            </svg>
                            <svg v-if="isShowed[post.id]" class="w-6 h-6" viewBox="0 0 42 42" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-width="4.16667" stroke-linecap="round" stroke-linejoin="round" d="M21 39.75C24.7084 39.75 28.3335 38.6503 31.4169 36.5901C34.5004 34.5298 36.9036 31.6014 38.3227 28.1753C39.7419 24.7492 40.1132 20.9792 39.3897 17.3421C38.6663 13.7049 36.8805 10.364 34.2582 7.74176C31.636 5.11952 28.2951 3.33376 24.6579 2.61028C21.0208 1.88681 17.2508 2.25812 13.8247 3.67727C10.3986 5.09641 7.47022 7.49964 5.40995 10.5831C3.34967 13.6665 2.25 17.2916 2.25 21C2.25 24.1 3 27.0229 4.33333 29.5979L2.25 39.75L12.4021 37.6667C14.9771 39 17.9021 39.75 21 39.75Z" />
                            </svg>
                            <span>{{ post.comments_count }}</span>
                        </button>
                    </div>


                    <!-- Просмотры -->
                    <div class="flex items-center space-x-2 text-white  ">
                        <svg class="w-6 h-6" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.9668 10.9375C17.3554 10.9375 9.54782 15.3428 3.40134 24.1533C3.22589 24.4076 3.12975 24.7081 3.12506 25.017C3.12037 25.3259 3.20733 25.6292 3.37497 25.8887C8.09763 33.2813 15.8008 39.0625 24.9668 39.0625C34.0332 39.0625 41.8945 33.2637 46.6259 25.8545C46.7897 25.6001 46.8767 25.304 46.8767 25.0015C46.8767 24.6989 46.7897 24.4028 46.6259 24.1484C41.8838 16.8242 33.9648 10.9375 24.9668 10.9375Z" stroke="white" stroke-width="3.125" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M25 32.8125C29.3147 32.8125 32.8125 29.3147 32.8125 25C32.8125 20.6853 29.3147 17.1875 25 17.1875C20.6853 17.1875 17.1875 20.6853 17.1875 25C17.1875 29.3147 20.6853 32.8125 25 32.8125Z" stroke="white" stroke-width="3.125" stroke-miterlimit="10"/>
                        </svg>
                        <span>{{ post.views }}</span>
                    </div>
                </div>
            </div>

            <div v-if="isShowed[post.id]" class="">
                <div v-for="comment in comments[post.id]" :key="comment.id" class=" py-4 px-6 border-t border-gray-600 text-white">
                    <strong>{{ comment.username }}</strong>: {{ comment.title }}
                </div>
            </div>

        </div>
    </div>



</template>

<style scoped>

</style>
