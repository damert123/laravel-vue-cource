<script>

import AuthLayout from "@/Layouts/AuthLayout.vue";
import Post from "@/Components/Post/Post.vue";


export default {
    name: "Index",
    layout: AuthLayout,

    components:{
        Post
    },

    props:{
        userPosts: Object
    },

    data(){
        return{

        }
    },

    methods:{
        // getComments(post) {
        //     if (!this.isShowed) {
        //         axios.get(route('posts.comments.index', post.id))
        //             .then(res => {
        //                this.comments = res.data
        //                 console.log(res.data)
        //             });
        //     } else {
        //         this.isShowed = false
        //     }
        // },


        // storeComment(post){
        //     const commentData = {
        //         title: this.newComment[post.id],
        //     }
        //
        //     if (this.comment && this.comment.id){
        //         commentData.parent_id = this.comment.id;
        //     }
        //
        //     axios.post(route('posts.comments.store', post.id), commentData)
        //         .then(res => {
        //             this.getComments(post)
        //             this.newComment[post.id] = '';
        //             // this.comments[post.id].push(res.data);
        //             this.isShowed[post.id] = true;
        //             post.comments_count++;
        //         })
        //         .catch(e =>{
        //             this.errorMessage = e.response.data.message;
        //     })
        //
        // }
    },


}
</script>

<template>

    <div class="flex justify-center">
        <h1 class="text-2xl mt-12 font-bold">Welcome to the Homepage !</h1>
    </div>
    <div class="">
        <Post v-for="post in userPosts" :post="post" />
    </div>




</template>

<style scoped>

</style>
