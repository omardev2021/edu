<template>

    <div class="flex min-h-screen bg-mainColor">

        <AdminSidebar />
        <!-- Main Admin Content Area -->
        <div class="flex-1 flex flex-col font-primary">


                <!-- Header -->
                <header class="bg-softBlue text-mainColor p-6 flex justify-between items-center shadow-md">
                    <h2 class="text-2xl font-semibold">الصفحة الرئيسية</h2>
                    <Link :href="route('path.index')" class="px-4 py-2 bg-softRed text-black rounded-lg ">
                        العودة للموقع
                    </Link>
                </header>

            <!-- Content: Overview Stats -->
            <main class="flex-1 p-6">

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                        <i class="fas fa-book-open text-4xl text-softBlue ml-4"></i>
                        <div>
                            <h4 class="text-2xl font-semibold text-veryDarkBlue">{{stats.total_courses}}</h4>
                            <p class="text-customGray">مجموع الكورسات</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                        <i class="fas fa-chalkboard-teacher text-4xl text-softBlue ml-4"></i>
                        <div>
                            <h4 class="text-2xl font-semibold text-veryDarkBlue">{{stats.total_lessons}}</h4>
                            <p class="text-customGray">مجموع الدروس</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                        <i class="fas fa-tags text-4xl text-softBlue ml-4"></i>
                        <div>
                            <h4 class="text-2xl font-semibold text-veryDarkBlue">{{stats.total_topics}}</h4>
                            <p class="text-customGray">مجموع المواضيع</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
                        <i class="fas fa-users text-4xl text-softBlue ml-4"></i>
                        <div>
                            <h4 class="text-2xl font-semibold text-veryDarkBlue">{{stats.total_users}}</h4>
                            <p class="text-customGray">مجموع المستخدمين</p>
                        </div>
                    </div>
                </div>



                <!-- Recent Activity: Advanced Course List -->
                <div class="mt-10">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">كورسات الصفحة الرئيسية</h3>

                        <Link class="px-4 py-2 bg-softRed text-black rounded-lg " :href="route('admin.courses.index')">
                            تصفح الكل
                        </Link>

                    </div>

                    <!-- Courses List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col" v-for="course in courses" :key="course.id">
                            <div class="flex items-start">
                                <img :src="'/storage/' + course.image_path" alt="Course Icon" class="h-12 w-12 object-cover rounded-lg ml-4" />
                                <div class="flex-1">
                                    <h4 class="text-xl font-semibold text-darkBlue">{{ course.title }}</h4>
                                    <p class="text-customGray truncate-lines">{{ course.description }}</p>
                                </div>
                            </div>



                            <!-- Action Buttons -->
                            <div class="mt-4 flex justify-end space-x-3">
                                <Link :href="route('admin.courses.edit', course.id)"class="px-4 py-2 text-gray-600">
                                    <i class="fas fa-edit"></i> تعديل
                                </Link>
                                <button @click="deleteCourse(course.id)" class="px-4 py-2 text-red-600">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                                <Link :href="route('admin.courses.show', course.id)" class="px-4 py-2 bg-softRed  rounded-lg ">
                                    عرض الموارد
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import AdminHeader from "@/Components/AdminHeader.vue";
import AdminSidebar from "@/Components/AdminSidebar.vue";
import { Link } from '@inertiajs/vue3'
import Banner from "@/Components/Banner.vue";
import {Inertia} from "@inertiajs/inertia";


const props = defineProps({
    courses: Array,
    stats:Array
})

// Mock data for demonstration purposes


const recentCourses = ref([
    {
        id: 1,
        title: 'Intro to Vue.js',
        description: 'Learn the basics of Vue.js',
        icon: '/path/to/icon1.jpg',
        chapter_count: 4,
        lesson_count: 15,
    },
    {
        id: 2,
        title: 'Mastering Laravel',
        description: 'Advanced Laravel techniques',
        icon: '/path/to/icon2.jpg',
        chapter_count: 6,
        lesson_count: 25,
    },
    {
        id: 3,
        title: 'Tailwind CSS for Beginners',
        description: 'Learn to style with Tailwind CSS',
        icon: '/path/to/icon3.jpg',
        chapter_count: 5,
        lesson_count: 20,
    },
    // Add more courses as needed
])

// Methods
const editCourse = (id) => {
    console.log('Edit course with id:', id)
}

const deleteCourse = (id) => {
    if (confirm('are you sure?')) {
        Inertia.delete(route('admin.courses.destroy', id))

    }
}
</script>

<style scoped>
/* Add some basic styles to format the dashboard layout */

.truncate-lines {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2; /* Limit to 2 lines */
    line-height: 1.5em; /* Adjust to your preferred line height */
    max-height: 3em; /* Limit the height for 2 lines */
}
</style>
