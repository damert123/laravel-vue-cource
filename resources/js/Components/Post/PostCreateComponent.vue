<script>
import AuthLayout from "@/Layouts/AuthLayout.vue";

export default {
    name: "Index",

    props: {
        categories: Array,
        errorMessage: String,
    },

    emits: ['store-post'],

    data(){
        return{
            post: {category_id: null}

        }
    },

    computed: {
        isPostButtonDisabled() {
            return !this.post.title || !this.post.content || !this.post.category_id;
        },
    },

    methods:{
        storePost(){
            this.$emit('store-post', this.post);
        },
        setImage(e){
           this.post.image = e.target.files[0]
        }
    }


}
</script>

<template>

    <div>

        <p class="text-white font-semibold text-center mb-4">Добавить пост</p>

        <!-- Сообщение об ошибке -->
        <div v-if="errorMessage" class="mb-4 text-red-500 text-center">
            {{ errorMessage }}
        </div>

        <div class="mb-4">
            <input v-model="post.title" type="text" placeholder="Заголовок" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
        </div>
        <div class="mb-4">
            <textarea v-model="post.content" placeholder="Описание" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
        </div>

        <div class="mb-4">
            <input v-model="post.published_at" ref="datetimeInput" @focus="$refs.datetimeInput.showPicker()" type="datetime-local" placeholder="Дата публикации" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
        </div>

        <div class="mb-4">
            <input
                @change="setImage"
                type="file"
                accept="image/*"
                class="w-full p-2 rounded-md bg-gray-800 text-white border border-gray-600  placeholder-gray-400  focus:outline-none focus:ring-2 focus:ring-emerald-500"
            />
        </div>

        <div class="mb-4">
            <select v-model="post.category_id" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option :value="null" hidden="hidden" disabled>Выберите категорию</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
            </select>
        </div>
        <div class="text-center">
            <button @click.prevent="storePost" :disabled="isPostButtonDisabled" :class="isPostButtonDisabled ? 'bg-gray-600 cursor-not-allowed' : 'bg-emerald-700 hover:bg-emerald-600'" class="w-full px-4 py-2 rounded-md text-white">Добавить</button>
        </div>
    </div>

</template>

<style scoped>

</style>
