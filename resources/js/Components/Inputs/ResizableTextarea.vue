<template>
    <div>
        <label :for="id" class="text-white">{{ label }}</label>
        <textarea
            :id="id"
            v-model="content"
            class="w-full p-2 mb-2 bg-gray-800 text-white rounded"
            :style="{ height: textareaHeight + 'px' }"
            @input="autoResize"
        ></textarea>
    </div>
</template>

<script>
export default {
    name: 'ResizableTextarea',
    props: {
        modelValue: {
            type: String,
            default: '',
        },
        label: {
            type: String,
            default: 'Контент',
        },
        id: {
            type: String,
            default: 'resizable-textarea',
        },
    },
    data() {
        return {
            content: this.modelValue,
            textareaHeight: 50, // Начальная высота
        };
    },
    watch: {
        modelValue(newValue) {
            this.content = newValue;
            this.autoResize();
        },
        content(newValue) {
            this.$emit('update:modelValue', newValue);
        },
    },
    methods: {
        autoResize() {
            this.$nextTick(() => {
                const textarea = this.$refs.textarea;
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        },
    },
};
</script>

<style scoped>
textarea {
    resize: none; /* Отключаем стандартное изменение размера */
    overflow: hidden; /* Прячем скроллбар */
}
</style>
