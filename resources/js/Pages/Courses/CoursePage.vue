<template>

    <Nav />
    <Feedback />
    <div class="bg-[#F3F4FF] text-gray-800">
        <main class="flex-1 py-5 px-5 md:px-40 grid grid-cols-1 lg:grid-cols-3 gap-6 font-primary">
            <div class="lg:col-span-2">


                <section class="mb-6">

                    <div class=" mb-6">
                        <div class="flex gap-3 items-center mb-2">
                            <img :src="getImagePath(course.image_path)" class=" w-20 justify-center" >
                            <h1 class="text-4xl font-bold text-softBlue max-w-lg leading-snug	">{{ course.title }}</h1>

                        </div>
                        <p class="text-lg">
                            {{  course.description }}
                        </p>
                    </div>
                    <!--                    second part-->
                    <div class="bg-white p-4 rounded-md mb-6 flex justify-between items-center" v-if="nextCourse">
                        <div>
                            <p class="text-sm">الكورس التالي</p>
                            <h2 class="text-xl font-bold">{{nextCourse.title}}</h2>
                        </div>
                        <Link :href="route('course.show',nextCourse.id)"
                              :class="[
            ' px-4 py-2 rounded-full',
            {
                'bg-softBlue text-white': nextCourse.is_accessible,
                'bg-grayDark text-white': !nextCourse.is_accessible,

            }
        ]"
                        >انتقل للكورس</Link>
                    </div>


                    <div class="mb-6 mt-20">
                        <div class="divider-container">
                            <div class="divider">
                                <div class="diamond"></div>
                            </div>
                            <div class="divider-text ">الأجزاء</div>
                        </div>
                    </div>


                    <chapter-accordion v-for="chapter in course.chapters" :key="chapter.id" :chapter="chapter"/>

                </section>
            </div>
            <div class="space-y-6">
                <div
                    :class="[
            'group rounded-md px-3 py-5 relative shadow-sm transition-all duration-300 ease-in-out cursor-pointer',
            {
                'bg-softBlue text-white': bookmarked,
                'bg-white hover:bg-softBlue hover:text-white': !bookmarked && isHovered,
                'bg-white text-softBlue': !bookmarked && !isHovered
            }
        ]"
                    @mouseenter="handleMouseEnter"
                    @mouseleave="handleMouseLeave"
                    @click="toggleBookmark"
                >
                    <!-- Bookmark Icon -->
                    <div class="absolute -top-4 left-0 p-2">
                        <img
                            :src="isHovered || bookmarked ? '/images/bookmark-dark.png' : '/images/bookmark.png'"
                            class="w-8"
                        >
                    </div>
                    <h3 class="text-xl font-bold text-center transition-all duration-300 ease-in-out"
                        :class="{ 'text-white': bookmarked || isHovered, 'text-softBlue': !bookmarked && !isHovered }">
                         {{bookmarked ? 'إزالة من الكورسات المفضلة' : 'إضافة الى الكورسات المفضلة'}}
                    </h3>
                </div>

                <div class="bg-[rgba(255,255,255,0.5)]  p-4 rounded-md text-grayDark">

                    <div class="divider-container">
                        <h3 class="font-bold text-grayDark text-center pb-2 text-lg">أبرز مواضيع الدورة</h3>
                        <div class="divider">
                            <div class="diamond"></div>
                        </div>
                    </div>
                    <ul class="list-disc list-inside">

                        <li v-for="highlight in course.highlights" :key="highlight" class="text-sm">{{highlight.content}}</li>
                    </ul>
                    <div class="text-center">
                        <button @click="scrollToKeyTerms" class="mt-2 bg-transparent text-softBlue font-bold px-4 py-2 rounded-md text-sm">تصفح المصطلحات الرئيسية</button>

                    </div>
                </div>


                <div class="bg-[rgba(255,255,255,0.5)]  p-4 rounded-md text-grayDark">

                    <div class="divider-container">
                        <h3 class="font-bold text-grayDark text-center pb-2 text-lg">دورات مشابهة</h3>
                        <div class="divider">
                            <div class="diamond"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center px-4 py-1" v-for="course in relatedCourses" :key="course.id">
                        <Link :href="course.is_accessible ? route('course.show',course.id) : '#' ">
                        <div class="flex items-center gap-3">
                            <img :src="course.is_accessible ? getImagePath(course.image_path) : '/images/locked.png'" class="w-8">
                            <h2 class="font-bold text-sm">{{ course.title }}</h2>
                        </div>
                        </Link>
                    </div>

                </div>
<!--                <div class="bg-[rgba(255,255,255,0.5)]  p-4 rounded-md">-->
<!--                    <h2 class="text-xl font-bold mb-2">RELATED COURSES</h2>-->
<!--                    <p>Customer Validation</p>-->
<!--                </div>-->



            </div>
        </main>

        <!-- Key Terms Section -->
        <div class="mt-8 px-4 font-primary md:px-[135px]" id="key-terms-section">
            <div class="divider-container">
                <h3 class="font-bold text-grayDark text-center pb-2 text-xl">المصطلحات الرئيسية</h3>
                <div class="divider">
                    <div class="diamond"></div>
                </div>
            </div>
            <p class="text-center text-md text-grayDark mb-4 md:px-8 mx-auto">
                المصطلحات الأساسية هي المفاهيم التي تعتقد لوكالو أنها تستحق اهتمامًا خاصًا عند دراسة هذا الموضوع. انقر فوق أي مصطلح رئيسي في القائمة أدناه للانتقال مباشرة إلى الدرس الذي تم تقديمه فيه.
            </p>
            <div v-for="chapter in course.chapters" :key="chapter.id" class="mb-8 font-bold text-grayDark">
                <div v-for="lesson in chapter.lessons" :key="lesson.id" class="mb-4">
                    <div class="pt-2">
                        <h3 class="text-sm uppercase">{{ chapter.chapter_number }} | {{ lesson.lesson_number }}</h3>
                        <h4 class="text-2xl mt-1">{{ lesson.title }}</h4>
                    </div>
                    <div v-for="term in lesson.terms" :key="term.id" class="mt-5">
                        <Link :href="navigateToLessonUrl(lesson)">
                            <h5 class="text-xl text-darkBlue mb-2 hover:text-softBlue hover:bg-white hover:rounded inline-block px-2 py-1 transition duration-300">{{ term.title }}</h5>
                        </Link>
                        <p>{{ term.content }}</p>
                    </div>
                </div>
            </div>
        </div>

        <Footer class="mt-20"/>
    </div>
</template>

<script setup>
import ChapterAccordion from "../Components/ChapterAccordion.vue";
import Footer from "@/Pages/Components/Footer.vue";
import { ref } from 'vue';
import {Link} from '@inertiajs/vue3';
import Feedback from "@/Pages/Components/Feedback.vue";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import Nav from "@/Pages/Components/Nav.vue";
import axios from "axios";



const toast = useToast();


const props = defineProps({
    course: Object,
    relatedCourses: Array,
    nextCourse:Object
});

// Destructure course from props
const { course } = props;

// Define bookmarked state
const bookmarked = ref(course.bookmarked);


const showSuccessToast = (message) => {
    toast.success(message, {
        position: 'top-left',
        duration: 5000,
    });
};

// Function to toggle bookmark status
const toggleBookmark = async (event) => {
    event.stopPropagation();
    event.preventDefault();

    try {
        if (bookmarked.value) {
            await axios.delete(route('bookmark.destroy'), { data: { course_id: course.id } });
            bookmarked.value = false;
            showSuccessToast('تمت إزالة الكورس بنجاح');

        } else {
            await axios.post(route('bookmark.store'), { course_id: course.id });
            bookmarked.value = true;
            showSuccessToast('تمت اضافة الكورس بنجاح');

        }
    } catch (error) {
        console.error(error);
    }
};

const isHovered = ref(false);

const handleMouseEnter = () => {
    isHovered.value = true;
};

const handleMouseLeave = () => {
    isHovered.value = false;
};

function getImagePath(imagePath) {
    return '/images/' + imagePath;
}

const navigateToLessonUrl = (lesson) => {
    if (lesson.completed_slides_count === 0) {
        // Navigate to the first slide
        return `/lessons/${lesson.id}?slide=1`;
    } else if (lesson.completed_slides_count < lesson.total_slides_count) {
        // Navigate to the first incomplete slide
        const firstIncompleteSlideIndex = lesson.slides.findIndex(slide => !slide.completed) + 1;
        return `/lessons/${lesson.id}?slide=${firstIncompleteSlideIndex}`;
    } else {
        // Navigate to review
        return `/lessons/${lesson.id}?review=true`;
    }
}


const scrollToKeyTerms = () => {
    const element = document.getElementById('key-terms-section');
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}


</script>

<style>
*{
    direction: rtl;
}
.low-opcity {
    background-color: rgb(255,255,255,0.5);
}
.divider-container {
    position: relative;
    width: 100%;
    text-align: center;
    /*margin-top: 20px;*/
    margin-bottom: 20px;
}

.divider {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    position: relative;
}

.divider::before, .divider::after {
    content: '';
    flex-grow: 1;
    height: 2px;
    background-color: #999999; /* Medium gray color for good contrast */
}

.diamond {
    width: 15px;
    height: 15px;
    border: 2px solid #999999; /* Medium gray border for good contrast */
    background-color: #F3F4FF; /* Same as the container background color */
    position: relative;

    transform: rotate(45deg);
}
.divider-text {
    position: absolute;
    top: -40px;
    left: 50%;
    transform: translateX(-50%);
    padding: 0 10px;
    font-size: 22px; /* Adjust font size as needed */
    font-weight: bold;
    color: #999999; /* Slightly darker gray for the text */
    text-transform: uppercase;
}


</style>

