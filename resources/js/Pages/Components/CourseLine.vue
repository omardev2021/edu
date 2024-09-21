<template>
    <div class="flex justify-between items-center p-4">
        <div class="flex items-center gap-3">
            <img :src="'/storage/' + course.image_path" class="w-10">
            <h2 class="font-bold text-sm">{{ course.title }}</h2>
        </div>
        <Link :href="course.is_accessible ? route('course.show',course.id) : '#'" :disabled="!course.is_accessible" class="rounded-full bg-white p-1 shadow-lg ">
            <i :class="['fas fa-arrow-left text-xl p-1', course.is_accessible ? 'text-softBlue' : 'text-gray-500']"></i>
        </Link>
    </div>
    <hr>
</template>

<script setup>

import { Link } from '@inertiajs/vue3';

defineProps({
    course:Object
})


function getImagePath(imagePath) {
    return '/images/' + imagePath;
}

</script>
