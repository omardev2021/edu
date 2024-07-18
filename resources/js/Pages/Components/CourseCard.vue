<template>
    <Link
        :href="course.is_accessible ? route('course.show', course.id) : ''"
        :class="[ { 'cursor-not-allowed': !course.is_accessible, 'text-blue-500': course.is_accessible }]"
        @click.prevent="!course.is_accessible && $event.preventDefault()"
    >
        <div class="bg-white rounded shadow max-w-lg relative">
            <!-- Bookmark Icon -->
            <div class="absolute -top-4 left-0 p-2" v-if="course.is_accessible">
                <div class="relative group">
                    <img
                        :src="bookmarked ? '/images/bookmark.png' : '/images/bookmark-gray.png'"
                        class="w-8 cursor-pointer"
                        @click.stop.prevent="toggleBookmark"
                    >
                    <span class="tooltip text-sm">{{bookmarked ? 'إزالة من المفضلة' : 'اضافة الى المفضلة'}}</span>
                </div>
            </div>
            <div class="flex gap-2 p-4 items-center">
                <img :src="course.is_accessible ? getImagePath(course.image_path) : '/images/locked.png'" class="w-10 justify-center">
                <h3 class="font-bold text-gray-600 text-lg">{{ course.title }}</h3>
            </div>
            <hr>
            <p class="text-gray-600 p-4 text-sm">{{ course.description }}</p>
            <div class="flex flex-row items-center gap-1 mr-4">
                <button v-for="topic in course.topics" :key="topic.id" class="px-4 border border-gray-300 text-gray-600 text-xs">
                    {{ topic.title }}
                </button>
            </div>
            <div :class="{
                'flex justify-between items-center mt-4 font-secondary': true,
                'bg-purpleCustom text-white': course.is_accessible && course.completed_lessons === course.total_lessons,
                'bg-softBlue text-white': course.is_accessible && course.completed_lessons > 0 && course.completed_lessons !== course.total_lessons,
                'bg-softRed text-white': course.is_accessible && course.completed_lessons === 0,
                'bg-grayDark text-white': !course.is_accessible
            }">
                <div class="px-4">
                    <h3>عدد الدروس</h3>
                    <h3 class="text-2xl lessons-no">
                        {{ course.is_accessible ? `${course.completed_lessons}/${course.total_lessons}` : `${course.total_lessons}` }}
                    </h3>
                </div>
                <button class="vertical-border px-2 text-2xl">
                    {{ course.is_accessible
                    ? (course.completed_lessons === course.total_lessons
                        ? 'مراجعة'
                        : (course.completed_lessons > 0 ? 'استئناف' : 'البداية'))
                    : 'مغلق'
                    }}
                </button>
            </div>
        </div>
    </Link>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

// Define props
const props = defineProps({
    course: Object,
});

// Destructure course from props
const { course } = props;

// Define bookmarked state
const bookmarked = ref(course.bookmarked);

// Function to toggle bookmark status
const toggleBookmark = async (event) => {
    event.stopPropagation();
    event.preventDefault();

    try {
        if (bookmarked.value) {
            await axios.delete(route('bookmark.destroy'), { data: { course_id: course.id } });
            bookmarked.value = false;
        } else {
            await axios.post(route('bookmark.store'), { course_id: course.id });
            bookmarked.value = true;
        }
    } catch (error) {
        console.error(error);
    }
};

function getImagePath(imagePath) {
    return '/images/' + imagePath;
}
</script>

<style scoped>
.tooltip {
    display: none;
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-5px);
    background-color: #333;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    white-space: nowrap;
    z-index: 10;
    opacity: 0;
    transition: opacity 0.3s;
}

.group:hover .tooltip {
    display: block;
    opacity: 1;
}
</style>
