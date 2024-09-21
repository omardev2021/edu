<template>

    <div class="flex min-h-screen bg-mainColor font-primary">
        <!-- Admin Sidebar (same as before) -->
        <AdminSidebar />

        <!-- Main Admin Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue p-6 flex justify-between items-center shadow-sm">
                <h2 class="text-3xl font-semibold text-white">كل الكورسات</h2>
                <div class="space-x-4">
                    <Link :href="route('admin.courses.create')" class="px-4 py-2 bg-softRed rounded-lg ">
                        <i class="fas fa-plus mr-2"></i> اضافة كورس
                    </Link>
                </div>
            </header>

            <!-- Content: Course List -->
            <main class="flex-1 p-6">


                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Loop through courses -->
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
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import AdminSidebar from '@/Components/AdminSidebar.vue'
import { Link } from '@inertiajs/vue3'
import Banner from "@/Components/Banner.vue";
import {Inertia} from "@inertiajs/inertia";
// Get courses data from Inertia page props
defineProps({
    courses: Array,
})

const editCourse = (id) => {
    console.log('Edit course with id:', id)
}

const deleteCourse = (id) => {
    if (confirm('are you sure?')) {
        Inertia.delete(route('admin.courses.destroy', id))

    }
}

const showResources = (id) => {
    console.log('Show resources for course id:', id)
    // Add navigation logic to course resources page
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
