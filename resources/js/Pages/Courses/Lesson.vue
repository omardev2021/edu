<template>
    <Head :title="lesson.lesson_number"/>
    <LessonComponent :lesson="lesson" :chapterTitle="chapterTitle" :lessonCount="lessonsCount" :slideIndex="slideIndex" />
</template>

<script setup>
import LessonComponent from '../Components/LessonComponent.vue';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3'
defineProps({
    lesson: Object,
    slideIndex: Number,
    lessonsCount: Number
});


</script>
