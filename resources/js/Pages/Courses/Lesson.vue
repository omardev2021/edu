<template>
    <LessonComponent :lesson="lesson" :chapterTitle="chapterTitle" :lessonCount="lessonsCount" :slideIndex="slideIndex" />
</template>

<script setup>
import LessonComponent from '../Components/LessonComponent.vue';
import { ref } from 'vue';

defineProps({
    lesson: Object,
    slideIndex: Number,
    lessonsCount: Number
});


</script>
