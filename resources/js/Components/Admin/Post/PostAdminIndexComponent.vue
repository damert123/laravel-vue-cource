<script>
import LikeLogo from "@/Components/Post/LikeLogo.vue";
import CommentLogo from "@/Components/Post/CommentLogo.vue";
import ViewIcon from "@/Components/Post/ViewIcon.vue";
export default {
    name: "PostAdminIndexComponent",

    components:{
        LikeLogo,
        CommentLogo,
        ViewIcon
    },

    props: {
        posts:{
            type: Array,
            required: true
        }

    },

    data() {
        return {

            selectedPost: null,
        };
    },

    methods:{
        selectPost(post){
            this.$emit('post-selected', post);
            this.selectedPost = post;
        },



        // handleDeleteClick(){
        //     this.$emit('open-popup', 'Delete')
        // }
    },




}
</script>

<template>
    <div class="post-list space-y-4">
        <div
            v-for="post in posts"
            :key="post.id"
            class="post-item p-4 border border-gray-600 rounded-lg bg-gray-800 hover:bg-gray-700 transition-all duration-200"
            @click="selectPost(post)"
        >
            <div class="flex justify-between">
                <div class="category text-sm text-gray-400 font-semibold">{{post.category_id.title}}</div>
                <div @click.stop="this.$emit('open-delete-popup', post.id)"  class="bg-red-950 w-fit p-1 rounded-md">
                    <svg class="w-5 h-5" viewBox="0 0 30 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.45 32.8542C4.51667 32.8542 3.72222 32.5264 3.06667 31.8708C2.41111 31.2153 2.08333 30.4215 2.08333 29.4896V3.6875H0V1.60417H8.33333V0H20.8333V1.60417H29.1667V3.6875H27.0833V29.4896C27.0833 30.4479 26.7625 31.2486 26.1208 31.8917C25.4792 32.5347 24.6778 32.8556 23.7167 32.8542H5.45ZM25 3.6875H4.16667V29.4896C4.16667 29.8632 4.28681 30.1701 4.52708 30.4104C4.76736 30.6507 5.075 30.7708 5.45 30.7708H23.7187C24.0382 30.7708 24.3319 30.6375 24.6 30.3708C24.8681 30.1042 25.0014 29.8097 25 29.4875V3.6875ZM10.0167 26.6042H12.1V7.85417H10.0167V26.6042ZM17.0667 26.6042H19.15V7.85417H17.0667V26.6042Z" fill="#7D0303"/>
                    </svg>
                </div>
            </div>

            <div class="tags text-xs text-gray-500 mb-1">
                <span v-for="tag in post.tags" :key="tag.id" class="tag-item mr-1">
                    {{ tag.name }}
                </span>
            </div>
            <h3 class="post-title text-lg font-bold text-white">{{ post.title }}</h3>
            <div class="post-meta flex justify-between text-sm text-gray-400">
                <div class="date">Публикация {{ post.date }}</div>
                <div class="profile-by">От: {{post.username}} </div>
            </div>
            <div class="post-stats flex justify-between mt-2 text-gray-300">
                <div class="flex items-center space-x-2 text-white text-md">
                    <div class="flex items-center space-x-2 hover:text-blue-600 transition duration-150 " >
                        <span>{{ post.like_count }}</span>
                        <LikeLogo class="w-4"/>
                    </div>
                    <span class="mx-2">|</span>
                    <div class="flex items-center space-x-2 hover:text-blue-600 transition duration-150 ">

                        <span> {{post.comments_count}}</span>
                        <CommentLogo class="w-4" />
                    </div>


                </div>
                <div class="flex items-center space-x-2">
                    <ViewIcon class="w-5"/>
                    <span>{{ post.views }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
