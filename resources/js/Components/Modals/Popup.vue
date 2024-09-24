<script xmlns="http://www.w3.org/1999/html">
export default {
    name: "Popup",

    props:{
        isVisible:{
            type: Boolean,
            required: true,
        },
        content: String,
    },
    methods:{
        closeModal(){
            this.$emit('close');
        }
    }
}
</script>

<template>
    <transition
        enter-active-class="transition-opacity ease-in-out duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity ease-in-out duration-300"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="isVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center backdrop-blur-sm">
            <div class="bg-customBlack w-1/3 p-6 rounded-lg shadow-lg">
                <slot />
                <button @click="closeModal" class="mt-4 w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Закрыть</button>
            </div>
        </div>
    </transition>
</template>

<style scoped>

</style>
