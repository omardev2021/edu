<template>
    <div class="min-h-screen flex flex-col relative font-primary bg-mainColor">
        <div class="bg-softBlue p-4 text-white">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- First div: EXIT button -->
                <button class="text-white mb-4 md:mb-0 font-bold text-xl items-center" @click="goBack">
                    <i class="fas fa-arrow-right text-grayDark "></i> خروج
                </button>

                <!-- Second div: Hexagon container -->
                <div class="flex flex-wrap justify-center items-center mx-auto md:mx-0 md:ml-4">
                    <template v-for="(slide, index) in slides" :key="index">
                        <Hexagon
                            :completed="slide.completed"
                            :isCurrent="currentSlideIndex === index + 1"
                            :slideIndex="index + 1"
                            @goToSlide="goToSlide"
                            class="mx-1"
                        />
                        <div v-if="(index + 1) % 8 === 0" class="w-full"></div>
                    </template>
                </div>

                <!-- Third div: Lesson title -->
                <div class="text-center mt-4 md:mt-0 md:ml-8 font-bold">
                    <h1 class="text-xl">{{ lesson.title }}</h1>
                    <h2 class="text-sm">{{ lesson.chapter.chapter_number }} • {{lesson.lesson_number}} من {{ lessonCount }} دروس</h2>
                </div>
            </div>
        </div>

        <transition :name="slideDirection" mode="out-in">
            <div :key="currentSlideIndex" class="flex flex-col items-center flex-grow pb-24">
                <div v-if="currentSlideIndex === 0" class="flex flex-col items-center flex-grow text-center mt-5">
                    <h3 class="text-2xl font-bold text-softBlue">{{ lesson.title }}</h3>
                    <p class="text-md text-grayDark mt-5">ما ستتعلمه في هذا الدرس</p>
                    <ul class="mt-4 text-gray-700">
                        <li v-for="objective in lesson.objectives" :key="objective.id" class="my-2 flex items-center">
                            <i class="fas fa-check-circle ml-2"></i> {{ objective.title }}
                        </li>
                    </ul>
                    <button @click="startLesson" class="bg-softRed w-full md:w-[500px] font-bold text-xl text-white py-2 px-4 rounded mt-8 absolute bottom-4 left-1/2 transform -translate-x-1/2">
                        إبدأ الدرس
                    </button>
                </div>
                <div v-else-if="currentSlideIndex <= slides.length" class="flex flex-col ">
                    <div  class="mt-4 mb-2 text-start">


                        <article class="mt-6 prose prose-sm max-w-none" v-html="currentSlide.html"></article>

                    </div>
                </div>
                <!-- Final Slide -->
                <div v-else class="text-center flex flex-col items-center mt-20">
                    <div class="bg-white py-8 px-4 md:px-20 rounded-lg shadow-md w-full max-w-xl">
                        <img src="/images/skill.png" alt="Icon" class="mx-auto mb-4 w-[120px]" />
                        <h3 class="text-xl font-bold text-softBlue">{{ lesson.title }}</h3>
                        <p class="text-sm ">المصطلحات الرئيسية للدرس</p>
                        <ul class="mt-4 text-gray-700 mb-8">
                            <li v-for="term in lesson.terms" :key="term.id" class="my-2 text-darkBlue">
                                {{ term.title }}
                            </li>
                        </ul>

                        <Link :href="route('course.show', lesson.chapter.course_id)" class="bg-softRed text-white font-bold py-2 px-4 rounded mt-8 w-full ">
                            العودة للكورس
                            <i class="fas fa-arrow-left mr-2"></i>
                        </Link>
                    </div>
                </div>
            </div>
        </transition>

        <div class="flex justify-between fixed bottom-4 w-full px-4">
            <button v-if="currentSlideIndex > 0" @click="prevSlide" class="bg-transparent border border-grayDark text-grayDark font-bold text-xl py-2 px-4 rounded">
                <i class="fas fa-angle-right"></i>
            </button>
            <button v-if="currentSlideIndex > 0 && currentSlideIndex <= slides.length" @click="nextSlide" class="bg-softRed font-bold text-xl text-white py-2 px-8 rounded">
                متابعة
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import Hexagon from './Hexagon.vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    lesson: Object,
    chapterTitle: String,
    lessonCount: Number,
    courseId: Number,
    slideIndex: Number,
});

const slides = ref(props.lesson.slides);
const currentSlideIndex = ref(0);
const slideDirection = ref('slide-left');

const currentSlide = computed(() => slides.value[currentSlideIndex.value - 1]);

onMounted(() => {
    if (props.slideIndex && props.slideIndex > 0 && props.slideIndex <= slides.value.length) {
        currentSlideIndex.value = props.slideIndex;
    }
});

watch(() => props.slideIndex, (newSlideIndex) => {
    if (newSlideIndex && newSlideIndex > 0 && newSlideIndex <= slides.value.length) {
        currentSlideIndex.value = newSlideIndex;
    }
});

watch(currentSlideIndex, (newIndex) => {
    if (newIndex > 0) {
        updateQueryParams(newIndex);
    }
});

const startLesson = () => {
    currentSlideIndex.value = 1;
};

function getImagePath(imagePath) {
    return '/images/' + imagePath;
}

const completeSlide = async (slideIndex) => {
    try {
        await axios.post(`/lessons/${props.lesson.id}/slides/${slides.value[slideIndex - 1].id}/complete`);
        slides.value[slideIndex - 1].completed = true;
    } catch (error) {
        console.error('Failed to complete slide:', error);
    }
};

const prevSlide = () => {
    if (currentSlideIndex.value > 1) {
        slideDirection.value = 'slide-right';
        currentSlideIndex.value--;
        updateQueryParams(currentSlideIndex.value);
    } else if (currentSlideIndex.value === 1) {
        slideDirection.value = 'slide-right';
        currentSlideIndex.value = 0;
        updateQueryParams(currentSlideIndex.value);
    }
};

const nextSlide = async () => {
    if (currentSlideIndex.value < slides.value.length) {
        await completeSlide(currentSlideIndex.value); // Complete the current slide first
        slideDirection.value = 'slide-left';
        currentSlideIndex.value++;
        updateQueryParams(currentSlideIndex.value);
    } else {
        // Complete the last slide before going to the next lesson
        await completeSlide(currentSlideIndex.value);
        slideDirection.value = 'slide-left';
        currentSlideIndex.value = slides.value.length + 1;
        updateQueryParams(currentSlideIndex.value);
    }
};

const goToSlide = async (index) => {
    if (slides.value[index - 1].completed || index <= currentSlideIndex.value) {
        await completeSlide(currentSlideIndex.value);
        currentSlideIndex.value = index;
        updateQueryParams(currentSlideIndex.value);
    }
};

const goNextLesson = () => {};

const goBack = () => {
    window.history.back();
};

// Function to update query parameters using Inertia
const updateQueryParams = (slideIndex) => {
    const url = new URL(window.location.href);
    url.searchParams.set('slide', slideIndex);
    window.history.replaceState(null, '', url);
};


</script>

<style scoped>
* {
    direction: rtl;
}

.hexagon-container {
    width: 100%;
    padding: 10px 0;
}

.slide-left-enter-active, .slide-left-leave-active {
    transition: all 0.7s ease;
}
.slide-left-enter-from, .slide-left-leave-to {
    transform: translateX(-100%);
    opacity: 0;
}
.slide-left-enter-to, .slide-left-leave-from {
    transform: translateX(0);
    opacity: 1;
}

.slide-right-enter-active, .slide-right-leave-active {
    transition: all 0.7s ease;
}
.slide-right-enter-from, .slide-right-leave-to {
    transform: translateX(100%);
    opacity: 0;
}
.slide-right-enter-to, .slide-right-leave-from {
    transform: translateX(0);
    opacity: 1;
}

.border-white {
    border-color: white;
}

.pointer-events-none {
    pointer-events: none;
}
.bg-blue-500 {
    background-color: #4299e1;
}
.border-blue-500 {
    border-color: #4299e1;
}
</style>
