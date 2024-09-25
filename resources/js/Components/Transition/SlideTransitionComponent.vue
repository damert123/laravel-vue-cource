<script>
export default {
    name: "SlideTransitionComponent"
}
</script>

<template>

    <transition
        enter-active-class="transition-transform ease-in-out duration-300"
        enter-from-class="-translate-x-10"
        enter-to-class="translate-x-0"
        leave-active-class="transition-transform ease-in-out duration-300"
        leave-from-class="translate-x-0"
        leave-to-class="-translate-x-10"
    >
        <slot></slot>
    </transition>
</template>

<style scoped>

</style>
