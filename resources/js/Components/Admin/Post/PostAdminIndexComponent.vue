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
            this.$emit('post-selected', post); // Отправляем событие с выбранным постом
            this.selectedPost = post;
        },
    }


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
            <div class="category text-sm text-gray-400 font-semibold">{{post.category_id.title}}</div>
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
