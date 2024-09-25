<script>
export default {
    name: "UserCreateComponent",

    props:{
        roles: Array,
        errorMessage: String,
    },

    emits: ['store-user'],

    data(){
        return{
            user: { role_id: null}
        }
    },

    computed:{
        isUserButtonDisabled() {
            return !this.user.name || !this.user.email || !this.user.password || !this.user.login;
        }
    },

    methods:{
        storeUser(){
            this.$emit('store-user', this.user)
        }
    }



}
</script>

<template>
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

    <!-- Поле для ввода логина -->
    <div class="mb-4">
        <input v-model="user.login" type="text" placeholder="Логин" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
    </div>

    <!-- Селект для ролей -->
    <div class="mb-4">
        <select v-model="user.role_id" class="w-full p-2 rounded-md bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <option :value="null" disabled>Выберите роль (необязательно)</option>
            <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.title }}</option>
        </select>
    </div>

    <!-- Кнопка для добавления пользователя -->
    <div class="text-center">
        <button @click.prevent="storeUser" :disabled="isUserButtonDisabled" :class="isUserButtonDisabled ? 'bg-gray-600 cursor-not-allowed' : 'bg-emerald-700 hover:bg-emerald-600'"
                class="w-full px-4 py-2 rounded-md text-white">Добавить</button>
    </div>
</template>

<style scoped>

</style>
