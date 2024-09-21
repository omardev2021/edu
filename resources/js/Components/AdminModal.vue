<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-500">X</button>
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
</script>

<style scoped>
/* Modal-specific styles can go here */
</style>
