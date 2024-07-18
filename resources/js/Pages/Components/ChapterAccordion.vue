<template>
    <div>
        <div class="mb-4 shadow-lg">
            <div class="bg-softBlue text-white p-4 flex justify-between items-center cursor-pointer" @click="toggleChapter">
                <div class="flex items-center">
                    <h2 class="font-bold mr-4">{{ chapter.chapter_number }}</h2>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-4 circles">
                        <span
                            v-for="lesson in chapter.lessons"
                            :key="lesson.id"
                            :class="[
                                'w-4 h-4 rounded-full mr-1',
                                lesson.completed ? 'bg-white' : 'border border-white'
                            ]"
                        ></span>
                    </div>
                </div>
            </div>
            <div class="bg-white">
                <h1 class="font-bold text-2xl p-4">{{ chapter.title }}</h1>
                <hr>
            </div>
            <transition name="accordion" @enter="enter" @leave="leave">
                <div v-if="isOpen" class="bg-white">
                    <div v-for="lesson in chapter.lessons" :key="lesson.id" class="border-b">
                        <div class="flex justify-between">
                            <!-- Lesson Content -->
                            <div class="w-3/4 p-3">
                                <h3 class="font-bold text-sm">{{ lesson.lesson_number }}</h3>
                                <h3 class="text-lg font-bold text-veryDarkBlue">{{ lesson.title }}</h3>
                                <ul class="mt-4">
                                    <li v-for="objective in lesson.objectives" :key="objective.id" class="text-customGray">
                                    +    {{ objective.title }}
                                    </li>
                                </ul>
                            </div>
                            <!-- Action Section -->
                            <div class="bg-mainColor flex flex-col w-1/4">
                                <div class="flex flex-col h-full justify-between">
                                    <div class="p-10 flex justify-center items-center">
                                        <i :class="getLessonIcon(lesson)" class="text-3xl text-white"></i>
                                    </div>
                                    <div class="bg-softRed p-2 text-center text-white font-secondary w-full" @click="navigateToLesson(lesson)">
                                        {{ getLessonButtonText(lesson) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <div class="bg-white flex justify-between p-4">
                <div>
                    <span>تم اكمال {{ completedLessons }} من اصل {{ totalLessons }}</span>
                </div>
                <div @click="toggleChapter">
                    <i :class="isOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const isOpen = ref(true)

const props = defineProps({
    chapter: {
        type: Object,
        required: true
    }
})

const toggleChapter = () => {
    isOpen.value = !isOpen.value
}

const enter = (el) => {
    el.style.height = '0'
    el.style.opacity = '0'
    requestAnimationFrame(() => {
        el.style.height = el.scrollHeight + 'px'
        el.style.opacity = '1'
        el.style.transition = 'height 0.5s ease, opacity 0.5s ease'
    })
}

const leave = (el) => {
    el.style.height = el.scrollHeight + 'px'
    el.style.opacity = '1'
    requestAnimationFrame(() => {
        el.style.height = '0'
        el.style.opacity = '0'
        el.style.transition = 'height 0.5s ease, opacity 0.5s ease'
    })
}

const completedLessons = computed(() => props.chapter.lessons.filter(lesson => lesson.completed).length)
const totalLessons = computed(() => props.chapter.lessons.length)

const navigateToLesson = (lesson) => {
    if (lesson.completed_slides_count === 0) {
        // Navigate to the first slide
        window.location.href = `/lessons/${lesson.id}?slide=0`;
    } else if (lesson.completed_slides_count < lesson.total_slides_count) {
        // Navigate to the first incomplete slide
        const firstIncompleteSlideIndex = lesson.slides.findIndex(slide => !slide.completed) + 1;
        window.location.href = `/lessons/${lesson.id}?slide=${firstIncompleteSlideIndex}`;
    } else {
        // Navigate to review
        window.location.href = `/lessons/${lesson.id}?review=true`;
    }
}


const getLessonIcon = (lesson) => {
    if (lesson.completed_slides_count === 0) {
        return 'fas fa-play';
    } else if (lesson.completed_slides_count < lesson.total_slides_count) {
        return 'fas fa-play';
    } else {
        return 'fas fa-check-circle';
    }
}

const getLessonButtonText = (lesson) => {
    if (lesson.completed_slides_count === 0) {
        return 'ابدأ الدرس';
    } else if (lesson.completed_slides_count < lesson.total_slides_count) {
        return 'استئناف';
    } else {
        return 'راجع';
    }
}
</script>

<style scoped>
.border {
    border-width: 2px;
}
</style>
