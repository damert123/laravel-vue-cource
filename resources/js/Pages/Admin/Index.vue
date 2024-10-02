<script>

import AuthLayout from "@/Layouts/AuthLayout.vue";
import Popup from "@/Components/Modals/Popup.vue";
import PostCreateComponent from "@/Components/Post/PostCreateComponent.vue";
import CommentCreateComponent from "@/Components/Comment/CommentCreateComponent.vue";
import UserCreateComponent from "@/Components/User/UserCreateComponent.vue";
import PostAdminIndexComponent from "@/Components/Admin/Post/PostAdminIndexComponent.vue";
import SlideTransitionComponent from "@/Components/Transition/SlideTransitionComponent.vue";
import {Link} from "@inertiajs/vue3";

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
        Link
    },

    emits: ['open-popup'],

    props:{
        categories: Array,
        posts: Object,
        videos: Array,
        roles: Array,
    },

    data(){
      return {
          postsData: this.posts,
          filter: {},
          isPostMenuOpen: false,
          isUserMenuOpen: false,
          isPopupVisible: false,
          popupType: '',
          commentableType: '',
          successMessage: '',
          errorMessage: '',
          selectedPost: null,
          selectedPostId: null,
          isPageChange: false

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
            axios.post(route('admin.posts.store'), postData, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            })
                .then(res => {
                    this.successMessage = res.data.message;
                    this.postsData.data.unshift(res.data.post);
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

        handleDeletePost(postId) {
            this.selectedPostId = postId;
            this.togglePopup('Delete');
        },

        deletePost(postId){
            axios.delete(route('admin.posts.destroy', postId))
                .then(res=>{
                    this.successMessage = res.data.message;
                    this.postsData.data = this.postsData.filter(post => post.id !== postId); // Обновляем локальное состояние
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000);
                    this.isPopupVisible = false;
                })
                .catch(e => {
                    this.errorMessage = e.response?.data?.message || 'Произошла ошибка при удалении';

                });
        },

        getPosts(){

            const query = new URLSearchParams(this.filter).toString();
            window.history.pushState({}, '', `?${query}`);

            axios.get(route('admin.posts.index'), {
                params: this.filter
            })
                .then(res =>{
                    this.postsData = res.data
                })
        },

        resetFilters(){
            this.filter = {};
            this.getPosts(null);
        },

        debounceGetPosts() {
            clearTimeout(this.debounceTimeout);
            this.debounceTimeout = setTimeout(() => {
                this.getPosts();
            }, 300);
        },

    },

    mounted() {
        this.postsData = this.posts;
        if (this.postsData.meta.current_page){
            this.filter.page = this.postsData.meta.current_page
        }
    },

    watch: {
           filter:{
               handler(){
                   if(!this.isPageChange){
                       this.filter.page = 1;
                   }
                   this.debounceGetPosts();
                   this.isPageChange = false
               },
               deep: true
           },
        'filter.page': function (){
               this.isPageChange = true
               this.getPosts();
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

     <!-- POPUP Окно -->
     <Popup :isVisible="isPopupVisible" :hideCloseButton="popupType === 'Delete'"  @close="isPopupVisible = false">

         <template v-if="popupType === 'Post'">
             <PostCreateComponent :categories="categories" :errorMessage="errorMessage" @store-post="storePost" />
         </template>

         <template v-if="popupType === 'Comment'">
             <CommentCreateComponent :posts="posts" :videos="videos" :errorMessage="errorMessage" @store-comment="storeComment" />
         </template>

         <template v-if="popupType === 'User'">
             <UserCreateComponent :roles="roles" :errorMessage="errorMessage" @store-user="storeUser"/>
         </template>

         <template v-if="popupType === 'Delete'">

                 <h2 class="text-xl font-semibold text-white mb-4">Удалить пост?</h2>
                 <p class="text-gray-300 mb-6">Вы уверены, что хотите удалить этот пост? Это действие не может быть отменено.</p>

                 <div class="flex justify-end space-x-4">
                     <!-- Кнопка отмены -->
                     <button @click="isPopupVisible = false" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                         Отмена
                     </button>

                     <!-- Кнопка удаления -->
                     <button @click="deletePost(selectedPostId)" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                         Удалить
                     </button>
                 </div>

         </template>
     </Popup>

 </div>


    <div class="flex h-auto text-white w-4/5 mx-auto mt-12 rounded-lg">
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

            <div class="border-b-2 border-gray-600 mb-4"></div>

            <div class="space-y-4 mb-4">
                <!-- Первый инпут для поиска по тексту 1 -->

                <div class="flex justify-between">
                    <div class="flex w-1/2 items-center rounded-lg p-2 ">
                        <svg class="w-5 h-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="2" fill="none" />
                            <line x1="15" y1="15" x2="23" y2="23" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <input type="text" placeholder="Поиск" v-model="filter.title" class=" bg-gray-800  rounded-xl text-white placeholder-gray-400 focus:outline-none w-full" />
                    </div>

                    <!-- Второй инпут для поиска по категориям -->
                    <div class="flex items-center rounded-lg p-2">
                        <input type="text" placeholder="Категория" v-model="filter.category_title" class="bg-gray-800 rounded-xl text-white placeholder-gray-400 focus:outline-none w-full" />
                    </div>

                    <div class="flex w-1/4 items-center rounded-lg p-2">
                        <input type="date" v-model="filter.published_at_from" class="bg-gray-800 text-white rounded-xl focus:outline-none w-full" />
                    </div>

                    <div>
                        <a @click.prevent="resetFilters" href="#">Сброс</a>
                    </div>
                </div>


                <!-- Инпут для даты -->

            </div>


            <PostAdminIndexComponent :posts="postsData" @open-popup="togglePopup" @open-delete-popup="handleDeletePost" @post-selected="handlePostSelect"/>

                <div class="flex justify-center items-center  space-x-4 mt-5">
                    <div>
                        <a v-if="postsData.meta.current_page !== 1"
                           class="py-2 px-4 border border-gray-600 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition-all duration-200"
                           @click.prevent="filter.page = filter.page - 1">
                            &lt;
                        </a>
                    </div>

                    <template v-for="link in postsData.meta.links" :key="link.label" >
                        <template v-if="Number(link.label) &&
                        (postsData.meta.current_page - link.label < 2 &&
                         postsData.meta.current_page - link.label > -2) ||
                         Number(link.label) === 1 || Number(link.label) === postsData.meta.last_page">
                            <a :class="{
                                    'py-2 px-4 border border-gray-600 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition-all duration-200': !link.active,
                                    'py-2 px-4 border border-gray-500 rounded-lg bg-gray-500 text-white': link.active
                                }"
                               @click.prevent="filter.page = link.label"
                               v-html="link.label"
                            >
                            </a>
                        </template>
                    </template>

                    <div>
                        <a  v-if="postsData.meta.current_page !== postsData.meta.last_page"
                            class="py-2 px-4 border border-gray-600 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition-all duration-200"
                            @click.prevent="filter.page = filter.page + 1">
                            &gt;
                        </a>
                    </div>
                </div>


        </div>

        <SlideTransitionComponent>
            <div v-if="selectedPost" class="flex-grow w-1/3 p-4 bg-customBlack rounded-r-xl border-l-2 border-gray-600">
                <h2 class="text-white text-lg font-bold">Редактировать пост</h2>

                <div class="mt-4">

                    <div class="my-4">
                        <img v-if="selectedPost.image_path" :src="selectedPost?.image_path" alt="Post Image" class="border mb-2 w-3/4 h-3/4 m-auto rounded-xl" />
                        <div v-if="!selectedPost.image_path" class="text-center font-semibold text-slate-500 p-3 border rounded-xl ">НЕТ ИЗОБРАЖЕНИЯ</div>
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
