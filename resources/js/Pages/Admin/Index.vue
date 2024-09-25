<script>

import AuthLayout from "@/Layouts/AuthLayout.vue";
import Popup from "@/Components/Modals/Popup.vue";
import PostCreateComponent from "@/Components/Post/PostCreateComponent.vue";
import CommentCreateComponent from "@/Components/Comment/CommentCreateComponent.vue";
import UserCreateComponent from "@/Components/User/UserCreateComponent.vue";
import PostAdminIndexComponent from "@/Components/Admin/Post/PostAdminIndexComponent.vue";
import SlideTransitionComponent from "@/Components/Transition/SlideTransitionComponent.vue";

export default {
    name: "Index",
    layout: AuthLayout,

    components:{
        Popup,
        PostCreateComponent,
        CommentCreateComponent,
        UserCreateComponent,
        PostAdminIndexComponent,
        SlideTransitionComponent,
    },

    props:{
        categories: Array,
        posts: Array,
        videos: Array,
        roles: Array,
    },

    data(){
      return {
          isPostMenuOpen: false,
          isUserMenuOpen: false,
          isPopupVisible: false,
          popupType: '',
          commentableType: '',
          successMessage: '',
          errorMessage: '',
          selectedPost: null,
      };
    },


    methods:{
        togglePostMenu(){
          this.isPostMenuOpen = !this.isPostMenuOpen;
        },

        toggleUserMenu(){
            this.isUserMenuOpen = !this.isUserMenuOpen;
        },

        togglePopup(type){
            this.isPopupVisible = true;
            this.popupType = type;
            this.errorMessage = '';
            this.post = {category_id: null}
            this.comment = {
                commentable_type: '',
                commentable_id: null,
                }
            this.user = {
                role_id: null
            }
            this.commentableType = ''
        },

        handlePostSelect(post) {
            this.selectedPost = post;
        },

        storePost(postData){
            axios.post(route('admin.posts.store'), postData)
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

        storeComment(commentData){
            axios.post(route('admin.comment.store'), commentData)
                .then(res => {
                    this.successMessage = res.data.message;
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000)
                    this.comment = {
                        commentable_id: null,
                        commentable_type: '',
                    };
                    this.isPopupVisible = false;
                    this.commentableType = ''
                })
                .catch(e => {
                   this.errorMessage = e.response.data.message;
                })
        },

        storeUser(userData) {
            axios.post(route('admin.users.store'), userData)
                .then(res => {
                    this.successMessage = res.data.message;
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000);
                    this.user = {
                        role_id: null
                    };
                    this.isPopupVisible = false;
                })
                .catch(e => {
                    this.errorMessage = e.response.data.message;
                });
        },




    },



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

     <!-- POPUP Окно -->
     <Popup :isVisible="isPopupVisible"  @close="isPopupVisible = false">

         <template v-if="popupType === 'Post'">
             <PostCreateComponent :categories="categories" :errorMessage="errorMessage" @store-post="storePost" />
         </template>

         <template v-if="popupType === 'Comment'">
             <CommentCreateComponent :posts="posts" :videos="videos" :errorMessage="errorMessage" @store-comment="storeComment" />
         </template>

         <template v-if="popupType === 'User'">
             <UserCreateComponent :roles="roles" :errorMessage="errorMessage" @store-user="storeUser"/>
         </template>


     </Popup>

 </div>


    <div class="flex h-screen text-white w-4/5 mx-auto mt-12 rounded-lg">
        <!-- Боковое меню -->
        <div class="w-64 bg-black p-4 rounded-l-xl bg-opacity-30">
            <h2 class="text-xl mb-4">Админка</h2>
            <div class="border-b-2 border-gray-600 mb-4"></div>
            <ul>
                <li @click="togglePostMenu" class="cursor-pointer flex justify-between items-center">
                    <span>Посты</span>
                    <span>{{ isPostMenuOpen ? '▲' : '▼' }}</span>
                </li>
                <ul v-show="isPostMenuOpen" class="ml-4">
                    <li class="mt-4 cursor-pointer">Комментарии</li>
                    <li class="cursor-pointer">Тэги</li>
                    <li class="cursor-pointer">Категории</li>
                </ul>

                <li @click="toggleUserMenu" class="mt-4 cursor-pointer flex justify-between items-center">
                    <span>Пользователи</span>
                    <span>{{ isUserMenuOpen ? '▲' : '▼' }}</span>
                </li>
                <ul v-show="isUserMenuOpen" class="ml-4">
                    <li class="cursor-pointer">Роли</li>
                    <li class="cursor-pointer">Разрешения</li>
                </ul>
            </ul>
        </div>

        <!-- Пустое пространство для контента -->

        <div class="flex-grow p-4 bg-customBlack ">
            <!-- КНОПКИ ДЛЯ СОЗДАНИЯ -->
            <div class="flex justify-center items-center gap-x-5 text-white text-md mb-4">
                <div @click="togglePopup('Post')" class="bg-customBlack px-4 py-2 rounded-2xl hover:bg-gray-600 transition-all duration-100 cursor-pointer ease-linear flex items-center">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.58333 17H16.9167V8.66665H19V17H27.3333V19.0833H19V27.4166H16.9167V19.0833H8.58333V17ZM6.5 0.333313H29.4167C31.0743 0.333313 32.664 0.991793 33.8361 2.1639C35.0082 3.336 35.6667 4.92571 35.6667 6.58331V29.5C35.6667 31.1576 35.0082 32.7473 33.8361 33.9194C32.664 35.0915 31.0743 35.75 29.4167 35.75H6.5C4.8424 35.75 3.25269 35.0915 2.08058 33.9194C0.90848 32.7473 0.25 31.1576 0.25 29.5V6.58331C0.25 4.92571 0.90848 3.336 2.08058 2.1639C3.25269 0.991793 4.8424 0.333313 6.5 0.333313ZM6.5 2.41665C5.39493 2.41665 4.33512 2.85563 3.55372 3.63703C2.77232 4.41844 2.33333 5.47824 2.33333 6.58331V29.5C2.33333 30.605 2.77232 31.6649 3.55372 32.4463C4.33512 33.2277 5.39493 33.6666 6.5 33.6666H29.4167C30.5217 33.6666 31.5815 33.2277 32.3629 32.4463C33.1443 31.6649 33.5833 30.605 33.5833 29.5V6.58331C33.5833 5.47824 33.1443 4.41844 32.3629 3.63703C31.5815 2.85563 30.5217 2.41665 29.4167 2.41665H6.5Z" fill="white"/>
                    </svg>
                    <a>Пост</a>
                </div>

                <div @click="togglePopup('Comment')" class="bg-customBlack px-4 py-2 rounded-2xl hover:bg-gray-600 transition-all duration-100 cursor-pointer ease-linear flex items-center">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.58333 17H16.9167V8.66665H19V17H27.3333V19.0833H19V27.4166H16.9167V19.0833H8.58333V17ZM6.5 0.333313H29.4167C31.0743 0.333313 32.664 0.991793 33.8361 2.1639C35.0082 3.336 35.6667 4.92571 35.6667 6.58331V29.5C35.6667 31.1576 35.0082 32.7473 33.8361 33.9194C32.664 35.0915 31.0743 35.75 29.4167 35.75H6.5C4.8424 35.75 3.25269 35.0915 2.08058 33.9194C0.90848 32.7473 0.25 31.1576 0.25 29.5V6.58331C0.25 4.92571 0.90848 3.336 2.08058 2.1639C3.25269 0.991793 4.8424 0.333313 6.5 0.333313ZM6.5 2.41665C5.39493 2.41665 4.33512 2.85563 3.55372 3.63703C2.77232 4.41844 2.33333 5.47824 2.33333 6.58331V29.5C2.33333 30.605 2.77232 31.6649 3.55372 32.4463C4.33512 33.2277 5.39493 33.6666 6.5 33.6666H29.4167C30.5217 33.6666 31.5815 33.2277 32.3629 32.4463C33.1443 31.6649 33.5833 30.605 33.5833 29.5V6.58331C33.5833 5.47824 33.1443 4.41844 32.3629 3.63703C31.5815 2.85563 30.5217 2.41665 29.4167 2.41665H6.5Z" fill="white"/>
                    </svg>
                    <a>Комментарий</a>
                </div>

                <div @click="togglePopup('User')" class="bg-customBlack px-4 py-2 rounded-2xl hover:bg-gray-600 transition-all duration-100 cursor-pointer ease-linear flex items-center">
                    <svg  class="w-5 h-5 mr-2" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.58333 17H16.9167V8.66665H19V17H27.3333V19.0833H19V27.4166H16.9167V19.0833H8.58333V17ZM6.5 0.333313H29.4167C31.0743 0.333313 32.664 0.991793 33.8361 2.1639C35.0082 3.336 35.6667 4.92571 35.6667 6.58331V29.5C35.6667 31.1576 35.0082 32.7473 33.8361 33.9194C32.664 35.0915 31.0743 35.75 29.4167 35.75H6.5C4.8424 35.75 3.25269 35.0915 2.08058 33.9194C0.90848 32.7473 0.25 31.1576 0.25 29.5V6.58331C0.25 4.92571 0.90848 3.336 2.08058 2.1639C3.25269 0.991793 4.8424 0.333313 6.5 0.333313ZM6.5 2.41665C5.39493 2.41665 4.33512 2.85563 3.55372 3.63703C2.77232 4.41844 2.33333 5.47824 2.33333 6.58331V29.5C2.33333 30.605 2.77232 31.6649 3.55372 32.4463C4.33512 33.2277 5.39493 33.6666 6.5 33.6666H29.4167C30.5217 33.6666 31.5815 33.2277 32.3629 32.4463C33.1443 31.6649 33.5833 30.605 33.5833 29.5V6.58331C33.5833 5.47824 33.1443 4.41844 32.3629 3.63703C31.5815 2.85563 30.5217 2.41665 29.4167 2.41665H6.5Z" fill="white"/>
                    </svg>
                    <a>Пользователя</a>
                </div>
            </div>
            <PostAdminIndexComponent :posts="posts" @post-selected="handlePostSelect"/>

        </div>

        <SlideTransitionComponent >
            <div v-if="selectedPost" class="flex-grow w-1/3 p-4 bg-customBlack rounded-r-xl border-l-2 border-gray-600">
                <h2 class="text-white text-lg font-bold">Редактировать пост</h2>

                <div class="mt-4">

                    <div class="my-4">
                        <img :src="selectedPost?.image_path" alt="Post Image" class="mb-2" />
                        <div class="flex mt-4 items-center justify-between">
                            <span class="text-sm text-gray-400">От: {{ selectedPost?.username }}</span>
                            <span class="text-sm text-gray-400">Выложено: {{ selectedPost?.date }}</span>
                        </div>

                    </div>


                    <label class="text-white">Заголовок</label>
                    <input type="text" v-model="selectedPost.title" class="w-full p-2 mb-2 bg-gray-800 text-white rounded" />

                    <label class="text-white">Контент</label>
                    <textarea v-model="selectedPost.content" class="w-full min-h-52 p-2 mb-2 bg-gray-800 text-white rounded"></textarea>

                    <label class="text-white">Категория</label>
                    <select v-model="selectedPost.category_id.id" class="w-full p-2 mb-2 bg-gray-800 text-white rounded">
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.title }}
                        </option>
                    </select>


                    <label class="text-white">Теги</label>
                    <div class="flex flex-wrap gap-2 mt-2">
            <span v-for="tag in selectedPost.tags" :key="tag.id" class="bg-gray-700 text-white px-2 py-1 rounded flex items-center">
                {{ tag.name }}
                <!-- SVG иконка справа от тега -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5 8l4 4 4-4H5z" />
                </svg>
            </span>
                    </div>


                </div>
            </div>
        </SlideTransitionComponent>
    </div>


</template>

<style scoped>

.slide-enter-active, .slide-leave-active {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.slide-enter, .slide-leave-to {
    transform: translateX(100%);
    opacity: 0;
}


.fade-enter-active, .fade-leave-active {
    transition: opacity 0.1s ease-in-out;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}



</style>
