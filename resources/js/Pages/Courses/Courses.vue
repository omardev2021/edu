<template>
    <Nav />
    <Feedback />
    <div class="bg-[#F3F4FF]">
        <main class="container mx-auto px-4 py-8 font-primary">
            <div class="flex justify-start mb-3 md:pr-20 md:mr-6">
                <h2 class="text-xl font-bold text-gray-700">البحث</h2>
            </div>
            <!-- search -->
            <div class="flex justify-start items-center mb-6 md:px-20 md:mx-6 space-x-2">
                <input type="text" class="w-full p-2 border border-gray-300 rounded-tr-md rounded-br-md" placeholder="ابحث عن اي كورس" v-model="searchQuery">
                <button  class="bg-softBlue text-white font-bold py-2 px-4 rounded-tl-md rounded-bl-md">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- filters -->
            <div class="flex flex-wrap gap-4 mb-6 md:px-20 md:mx-6">
                <div class="filter-section flex-1">
                    <h2 class="font-bold mb-2">تصفية بالمواضيع</h2>
                    <div class="buttons flex flex-wrap gap-2">
                        <button :class="{'bg-lightBlue text-white': topicFilter === '', 'bg-white text-gray-800': topicFilter !== ''}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setTopicFilter('')">كل المواضيع</button>


                        <button v-for="topic in topics" :key="topic.id" :class="{'bg-lightBlue text-white': topicFilter === topic.id, 'bg-white text-gray-800': topicFilter !== topic.id}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setTopicFilter(topic.id)">
                            {{ topic.title }}
                        </button>
                    </div>
                </div>
                <div class="filter-section flex-1">
                    <h2 class="font-bold mb-2">تصفية بمستوى التقدم</h2>
                    <div class="buttons flex flex-wrap gap-2">

                        <button :class="{'bg-lightBlue text-white': progressFilter === '', 'bg-white text-gray-800': progressFilter !== ''}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setProgressFilter('')">كل المستويات</button>

                        <button :class="{'bg-lightBlue text-white': progressFilter === 'not_started', 'bg-white text-gray-800': progressFilter !== 'not_started'}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setProgressFilter('not_started')">لم يتم البدأ</button>
                        <button :class="{'bg-lightBlue text-white': progressFilter === 'in_progress', 'bg-white text-gray-800': progressFilter !== 'in_progress'}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setProgressFilter('in_progress')">قيد المشاهدة</button>
                        <button :class="{'bg-lightBlue text-white': progressFilter === 'finished', 'bg-white text-gray-800': progressFilter !== 'finished'}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setProgressFilter('finished')">مكتمل</button>
                    </div>
                </div>
                <div class="filter-section w-full">
                    <h2 class="font-bold mb-2">تصفية بالحالة</h2>
                    <div class="buttons flex flex-wrap gap-2">

                        <button :class="{'bg-lightBlue text-white': accessibilityFilter === '', 'bg-white text-gray-800': accessibilityFilter !== ''}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setAccessibilityFilter('')">كل الحالات</button>

                        <button :class="{'bg-lightBlue text-white': accessibilityFilter === 'accessible', 'bg-white text-gray-800': accessibilityFilter !== 'accessible'}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setAccessibilityFilter('accessible')">مدفوع</button>
                        <button :class="{'bg-lightBlue text-white': accessibilityFilter === 'free', 'bg-white text-gray-800': accessibilityFilter !== 'free'}" class="border border-gray-300 px-3 py-1 shadow-sm rounded-sm" @click="setAccessibilityFilter('free')">مجاني</button>
                    </div>
                </div>
            </div>

            <!-- filters -->
            <div class="flex justify-between items-center md:pr-20 md:mr-6 mt-20 -mb-5">
                <div class="flex ">

                    <button @click="showTopics = false" :class="!showTopics ? 'button-active' : 'button-inactive'" class="rounded-tr-sm rounded-br-sm p-3  flex items-center relative group border border-gray-700">
                        <i class="fas fa-th-large" ></i>
                        <span class="tooltip text-sm">عرض كل الدروس</span>
                    </button>
                    <button @click="showTopics = true" :class="showTopics ? 'button-active' : 'button-inactive'" class="rounded-tl-sm rounded-bl-sm p-3  flex items-center relative group border border-gray-700">
                        <i class="fas fa-list-ul"></i>
                        <span class="tooltip text-sm">تصنيف بالمواضيع</span>
                    </button>
                </div>
            </div>

            <div class="mb-6 md:px-20 md:mx-6">
                <div class="divider-container">
                    <div class="divider">
                        <div class="diamond"></div>
                    </div>
                    <div class="divider-text ">الكورسات</div>
                </div>
            </div>

            <div class="flex flex-col items-center gap-4">
                <template v-if="showTopics">
                    <div v-for="topic in filteredTopics" :key="topic.id" class="w-full">
                        <h3 class="text-lg font-bold mb-4 text-start lg:mr-[110px]">{{ topic.title }}</h3>
                        <div class="flex justify-center flex-wrap gap-4">
                            <CourseCard v-for="course in filteredCourses(topic.courses)" :key="course.id" :course="course" />
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="flex justify-center flex-wrap gap-4">
                        <CourseCard v-for="course in filteredCourses(courses)" :key="course.id" :course="course" />
                    </div>
                </template>
            </div>
        </main>
    </div>
    <Footer />
</template>

<script setup>
import { ref, computed } from "vue";
import ChapterAccordion from "../Components/ChapterAccordion.vue";
import CourseCard from "@/Pages/Components/CourseCard.vue";
import Nav from "@/Pages/Components/Nav.vue";
import Feedback from "@/Pages/Components/Feedback.vue";
import Footer from "@/Pages/Components/Footer.vue";

const props = defineProps({
    topics: Array,
    courses: Array,
});

const searchQuery = ref("");
const topicFilter = ref("");
const progressFilter = ref("");
const accessibilityFilter = ref("");
const showTopics = ref(false);

const setTopicFilter = (topicId) => {
    topicFilter.value = topicId;
};

const setProgressFilter = (progress) => {
    progressFilter.value = progress;
};

const setAccessibilityFilter = (accessibility) => {
    accessibilityFilter.value = accessibility;
};

const filteredTopics = computed(() => {
    if (!searchQuery.value) {
        return props.topics;
    }

    return props.topics.filter((topic) =>
        topic.title.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const filteredCourses = (courses) => {
    return courses.filter((course) => {
        // Filter by topic
        if (topicFilter.value && !course.topics.some((topic) => topic.id === topicFilter.value)) {
            return false;
        }

        // Filter by progress
        if (progressFilter.value) {
            const progress = getProgress(course);
            if (progressFilter.value === "not_started" && progress !== "not_started") {
                return false;
            } else if (progressFilter.value === "in_progress" && progress !== "in_progress") {
                return false;
            } else if (progressFilter.value === "finished" && progress !== "finished") {
                return false;
            }
        }

        // Filter by accessibility
        if (accessibilityFilter.value) {
            if (accessibilityFilter.value === "accessible" && !course.is_accessible) {
                return false;
            } else if (accessibilityFilter.value === "free" && course.is_accessible) {
                return false;
            }
        }

        // Filter by search query
        if (
            searchQuery.value &&
            !course.title.toLowerCase().includes(searchQuery.value.toLowerCase())
        ) {
            return false;
        }

        return true;
    });
};

const getProgress = (course) => {
    if (course.completed_lessons === 0) {
        return "not_started";
    } else if (course.completed_lessons < course.total_lessons) {
        return "in_progress";
    } else if (course.completed_lessons === course.total_lessons) {
        return "finished";
    }
    return "";
};
</script>

<style scoped>
*{
    direction: rtl;
}
.vertical-border::before {
    content: "";
    display: inline-block;
    vertical-align: middle;
    height: 1.5em; /* Adjust the height as needed */
    width: 2px;
    background-color: currentColor; /* Same color as text */
    margin-left: 1em; /* Increased space between border and text */
}

.divider-container {
    position: relative;
    width: 100%;
    text-align: center;
    margin-top: 20px;
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
    background-color: #F3F4FF; /* Same as the container background color */
    padding: 0 10px;
    font-size: 22px; /* Adjust font size as needed */
    font-weight: bold;
    color: #999999; /* Slightly darker gray for the text */
    text-transform: uppercase;
}

button {
    transition: background-color 0.3s, color 0.3s;
}
.button-active {
    background-color: #4a4a4a;
    color: white;
}
.button-inactive {
    background-color: transparent;
    color: #4a4a4a;
}

.group:hover .tooltip {
    display: block;
}
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
    opacity: 1;
}
</style>
