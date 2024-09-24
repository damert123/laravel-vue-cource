<script>

import AuthLayout from "@/Layouts/AuthLayout.vue";
import Popup from "@/Components/Modals/Popup.vue";
export default {
    name: "Index",
    layout: AuthLayout,

    components:{
        Popup
    },

    props:{
        categories: Array,
        posts: Array,
        videos: Array,
    },

    data(){
      return {
          isPopupVisible: false,
          popupType: '',
          commentableType: '',
          post: {
              category_id: null,
          },
          comment: {
              commentable_type: '',
              commentable_id: null,
          },
          user:{},
          successMessage: '',
          errorMessage: '',
      };
    },

    computed: {
        isCommentButtonDisabled() {
            return !this.commentableType || !this.comment.title || !this.comment.commentable_id;
        },
        isPostButtonDisabled() {
            return !this.post.title || !this.post.content || !this.post.category_id;
        },
        isUserButtonDisabled() {
            return !this.user.name || !this.user.email || !this.user.password;
        }
    },

    methods:{
        togglePopup(type){
            this.isPopupVisible = true;
            this.popupType = type;
            this.errorMessage = '';
            this.post = {}
            this.comment = {}
            this.user = {}
            // if (type === 'Comment') {
            //     this.commentableType = '';
            //     this.comment = {
            //         commentable_type: '',
            //         commentable_id: null,
            //         title: ''
            //     };
            // }
        },

        setCommentableType(type){
            this.commentableType = type;
            this.comment.commentable_type = type === 'post' ? 'posts' : 'videos';
            this.comment.commentable_id = null;
        },

        storePost(){
            axios.post(route('admin.posts.store'), this.post)
                .then(res => {
                    this.successMessage = res.data.message;
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000)
                    this.post = { category_id: null}
                    this.isPopupVisible = false
                })
                .catch(e => {
                    this.errorMessage = e.response.data.message ;
                })
        },

        storeComment(){
            axios.post(route('admin.comment.store'), this.comment)
                .then(res => {
                    this.successMessage = res.data.message;
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000)
                    this.comment = {
                        commentable_id: null,
                        commentable_type: '',
                    };
                    this.isPopupVisible = false
                })
                .catch(e => {
                   this.errorMessage = e.response.data.message;
                })
        },

        storeUser() {
            axios.post(route('admin.users.store'), this.user)
                .then(res => {
                    this.successMessage = res.data.message;
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000);
                    this.user = {};
                    this.isPopupVisible = false;
                })
                .catch(e => {
                    this.errorMessage = e.response.data.message;
                });
        }
    }
}
</script>

<template>
    <transition name="fade">
        <div v-if="successMessage" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-emerald-700 text-white p-4 rounded-md border-2 border-emerald-700 shadow-lg flex items-center">
            <svg class="w-6 mr-3" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 50C18.3696 50 12.0107 47.3661 7.32233 42.6777C2.63392 37.9893 0 31.6304 0 25C0 18.3696 2.63392 12.0107 7.32233 7.32233C12.0107 2.63392 18.3696 0 25 0C31.6304 0 37.9893 2.63392 42.6777 7.32233C47.3661 12.0107 50 18.3696 50 25C50 31.6304 47.3661 37.9893 42.6777 42.6777C37.9893 47.3661 31.6304 50 25 50ZM20 37.5L42.5 16.25L38.75 12.5L20 30L11.25 21.25L7.5 25L20 37.5Z" fill="white"/>
            </svg>
            {{ successMessage }}
        </div>
    </transition>

 <div>
     <div class="flex justify-center items-center gap-x-5 text-white text-lg ">
         <div @click="togglePopup('Post')" class="bg-customBlack px-4 py-2 rounded-2xl hover:bg-gray-600 transition-all duration-100 cursor-pointer ease-linear">
            <a>Добавить пост</a>
         </div>

         <div @click="togglePopup('Comment')" class="bg-customBlack px-4 py-2 rounded-2xl hover:bg-gray-600 transition-all duration-100 cursor-pointer ease-linear">
             <a>Добавить комментарий</a>
         </div>

         <div @click="togglePopup('User')" class="bg-customBlack px-4 py-2 rounded-2xl hover:bg-gray-600 transition-all duration-100 cursor-pointer ease-linear">
            <a>Добавить пользователя</a>
         </div>
     </div>

     <!-- POPUP Окно -->
     <Popup :isVisible="isPopupVisible" @close="isPopupVisible = false">
         <template v-if="popupType === 'Post'">
             <p class="text-white font-semibold text-center mb-4">Добавить пост</p>
             <div class="mb-4">
                 <input v-model="post.title" type="text" placeholder="Заголовок" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
             </div>
             <div class="mb-4">
                 <textarea v-model="post.content" placeholder="Описание" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
             </div>
             <div class="mb-4">
                 <select v-model="post.category_id" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                     <option :value=null disabled>Выберите категорию</option>
                     <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
                 </select>
             </div>
             <div class="text-center">
                 <button @click.prevent="storePost" :disabled="isPostButtonDisabled" :class="isPostButtonDisabled ? 'bg-gray-600 cursor-not-allowed' : 'bg-emerald-700 hover:bg-emerald-600'"
                         class="w-full px-4 py-2 rounded-md text-white">Добавить</button>
             </div>
         </template>

         <template v-if="popupType === 'Comment'">
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

         <template v-if="popupType === 'User'">
             <p class="text-white font-semibold text-center mb-4">Добавить пользователя</p>

             <!-- Сообщение об ошибке -->
             <div v-if="errorMessage" class="mb-4 text-red-500 text-center">
                 {{ errorMessage }}
             </div>

             <!-- Поле для ввода имени пользователя -->
             <div class="mb-4">
                 <input v-model="user.name" type="text" placeholder="Имя" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
             </div>

             <!-- Поле для ввода email -->
             <div class="mb-4">
                 <input v-model="user.email" type="email" placeholder="Email" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
             </div>

             <!-- Поле для ввода пароля -->
             <div class="mb-4">
                 <input v-model="user.password" type="password" placeholder="Пароль" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
             </div>

             <!-- Кнопка для добавления пользователя -->
             <div class="text-center">
                 <button @click.prevent="storeUser" :disabled="isUserButtonDisabled" :class="isUserButtonDisabled ? 'bg-gray-600 cursor-not-allowed' : 'bg-emerald-700 hover:bg-emerald-600'"
                         class="w-full px-4 py-2 rounded-md text-white">Добавить</button>
             </div>
         </template>


     </Popup>

 </div>
</template>

<style scoped>

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.1s ease-in-out;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}

</style>
