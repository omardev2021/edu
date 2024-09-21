<template>
    <div class="flex min-h-screen bg-mainColor font-primary">
        <!-- Admin Sidebar -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold">اضافة كورس جديد</h2>
            </header>

            <!-- Content: Form to Add New Course -->
            <main class="flex-1 p-6">
                <h3 class="text-xl font-semibold mb-6">معلومات الكورس الاساسية</h3>

                <form @submit.prevent="createCourse" enctype="multipart/form-data">
                    <!-- Course Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-darkBlue">العنوان</label>
                        <input type="text" v-model="form.title" id="title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
                    </div>

                    <!-- Course Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-darkBlue">الوصف</label>
                        <textarea v-model="form.description" id="description" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" rows="4" required></textarea>
                    </div>

                    <!-- Course Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-darkBlue">الصورة</label>
                        <input type="file" @change="handleImageUpload" id="image" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
                    </div>

                    <!-- Course Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-darkBlue">نوع الكورس (مدفوع ام مجاني)</label>
                        <select v-model="form.type" id="type" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg bg-white" style="direction: ltr" required>
                            <option value="" disabled>اختار النوع</option>
                            <option value="public">مجاني</option>
                            <option value="paid">مدفوع</option>
                        </select>
                    </div>

                    <!-- Is Featured -->
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" v-model="form.is_featured" id="is_featured" class="ml-2" />
                        <label for="is_featured" class="block text-sm font-medium text-darkBlue">هل تريد ان يظهر الكورس في الصفحة الرئيسية</label>
                    </div>

                    <!-- Multi-select for Topics -->
<!--                    <div class="mb-4">-->
<!--                        <label for="topics" class="block text-sm font-medium text-darkBlue">Select Topics</label>-->
<!--                        <select v-model="form.selected_topics" id="topics" multiple class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg bg-white">-->
<!--                            <option v-for="topic in topics" :key="topic.id" :value="topic.id">{{ topic.title }}</option>-->
<!--                        </select>-->
<!--                    </div>-->

                    <div class="mb-4">
                        <label for="topics" class="block text-sm font-medium text-darkBlue">اختيار مواضيع للكورس</label>
                        <div class="max-h-48 overflow-y-auto">
                            <div v-for="topic in topics" :key="topic.id" class="flex items-center">
                                <input type="checkbox" :value="topic.id" v-model="form.selected_topics" class="ml-2" />
                                <label>{{ topic.title }}</label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg hover:bg-lightBlue">
                            تاكيد واضافة
                        </button>
                    </div>
                </form>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import AdminSidebar from "@/Components/AdminSidebar.vue";

const props = defineProps({
    topics:Array
})

const form = ref({
    title: '',
    description: '',
    image: null,
    type: '',
    is_featured: false,
    selected_topics: [], // Hold the selected topic IDs
})

const handleImageUpload = (event) => {
    form.value.image = event.target.files[0]
}

const createCourse = () => {
    const formData = new FormData()
    formData.append('title', form.value.title)
    formData.append('description', form.value.description)
    formData.append('image', form.value.image)
    formData.append('type', form.value.type)

    formData.append('is_featured', form.value.is_featured ? 1 : 0)

    // Attach topics as a JSON string
    formData.append('topics', JSON.stringify(form.value.selected_topics))

    Inertia.post(route('admin.courses.store'), formData, {
        forceFormData: true,
        onError: (errors) => {
            console.log(errors) // For debugging if validation errors occur
        },
    })
}

</script>


<style scoped>
/* Additional styling for clearer dropdown */

</style>
