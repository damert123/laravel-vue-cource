<script>
export default {
    name: "CommentCreateComponent",

    props:{
        posts: Array,
        videos: Array,
        errorMessage: String,
    },

    emits: ['store-comment'],

    data(){
      return{
          commentableType: '',
          comment:{
              commentable_type: '',
              commentable_id: null,
          },

      }
    },

    computed: {
        isCommentButtonDisabled() {
            return !this.commentableType || !this.comment.title || !this.comment.commentable_id;
        },
    },

    methods: {
        setCommentableType(type){
            this.commentableType = type;
            this.comment.commentable_type = type === 'post' ? 'posts' : 'videos';
            this.comment.commentable_id = null;
        },

        storeComment(){
            this.$emit('store-comment', this.comment)
        }
    }

}
</script>

<template>

        <p class="text-white font-semibold text-center mb-4">Добавить комментарий</p>

        <!-- Сообщение об ошибке -->
        <div v-if="errorMessage" class="mb-4 text-red-500 text-center">
            {{ errorMessage }}
        </div>

        <!-- Кнопки для выбора типа -->
        <div class="mb-4 text-center">
            <button
                @click="setCommentableType('post')"
                :class="commentableType === 'post' ? 'bg-emerald-600 border-emerald-600' : 'bg-gray-800'"
                class="px-4 py-2 mb-4 rounded-md text-white border border-gray-600"
            >
                Комментарий к посту
            </button>
            <button
                @click="setCommentableType('video')"
                :class="commentableType === 'video' ? 'bg-emerald-600 border-emerald-600' : 'bg-gray-800'"
                class="px-4 py-2 rounded-md text-white ml-2 border border-gray-600"
            >
                Комментарий к видео
            </button>
        </div>

        <!-- Поле для ввода текста комментария -->
        <div class="mb-4">
            <input v-model="comment.title" type="text" placeholder="Текст комментария" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
        </div>

        <!-- Селект для постов -->
        <div v-if="commentableType === 'post'" class="mb-4">
            <select v-model="comment.commentable_id" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option :value="null" disabled>Выберите пост</option>
                <option v-for="post in posts" :key="post.id" :value="post.id">{{ post.title }}</option>
            </select>
        </div>

        <!-- Селект для видео -->
        <div v-if="commentableType === 'video'" class="mb-4">
            <select v-model="comment.commentable_id" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option :value="null" disabled>Выберите видео</option>
                <option v-for="video in videos" :key="video.id" :value="video.id">{{ video.title }}</option>
            </select>
        </div>

        <!-- Кнопка для добавления комментария -->
        <div class="text-center">
            <button @click.prevent="storeComment" :disabled="isCommentButtonDisabled" :class="isCommentButtonDisabled ? 'bg-gray-600 cursor-not-allowed' : 'bg-emerald-700 hover:bg-emerald-600'"
                    class="w-full px-4 py-2 rounded-md text-white">Добавить</button>
        </div>

</template>

<style scoped>

</style>
