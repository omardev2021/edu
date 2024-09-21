<template>
    <div class="flex min-h-screen bg-mainColor font-primary">
        <!-- Admin Sidebar -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold">تعديل الكورس</h2>
            </header>

            <!-- Content: Form to Edit Course -->
            <main class="flex-1 p-6">
                <h3 class="text-xl font-semibold mb-6">معلومات الكورس الاساسية</h3>

                <form @submit.prevent="updateCourse" enctype="multipart/form-data">
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

                    <!-- Course Image Upload with Preview -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-darkBlue">الصورة</label>
                        <input type="file" @change="handleImageUpload" id="image" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" />
                        <!-- Image Preview -->
                        <div v-if="form.image || courseImage" class="mt-4">
                            <p class="text-sm font-medium text-darkBlue">Image Preview:</p>
                            <img :src="imagePreview" alt="Image Preview" class="mt-2 h-40 w-40 object-cover rounded-lg" />
                        </div>
                    </div>

                    <!-- Course Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-darkBlue">نوع الكورس (مدفوع ام مجاني)</label>
                        <select style="direction: ltr" v-model="form.type" id="type" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg bg-white" required>
                            <option value="" disabled>اختر النوع</option>
                            <option value="public">مجاني</option>
                            <option value="paid">مدفوع</option>
                        </select>
                    </div>

                    <!-- Is Featured -->
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" v-model="form.is_featured" id="is_featured" class="ml-2" />
                        <label for="is_featured" class="block text-sm font-medium text-darkBlue">هل تريد ان يظهر الكورس في الصفحة الرئيسية ؟</label>
                    </div>

                    <!-- Multi-checkbox for Topics -->
                    <div class="mb-4">
                        <label for="topics" class="block text-sm font-medium text-darkBlue">اختر المواضيع</label>
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
                            تعديل
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
    course: Object,
    topics: Array
})

const form = ref({
    title: props.course.title,
    description: props.course.description,
    image: null,
    type: props.course.type,
    is_featured: props.course.is_featured === 1, // Set initial value for is_featured
    selected_topics: props.course.topics.map(topic => topic.id) // Pre-fill selected topics
})

// Store the course image URL for preview if no new image is uploaded
const courseImage = props.course.image_path ? `/storage/${props.course.image_path}` : null

// Computed property to show either uploaded image or existing course image
const imagePreview = ref(courseImage)

const handleImageUpload = (event) => {
    const file = event.target.files[0]
    form.value.image = file

    // Generate image preview URL
    imagePreview.value = URL.createObjectURL(file)
}

const updateCourse = () => {
    const formData = new FormData()
    formData.append('title', form.value.title)
    formData.append('description', form.value.description)
    if (form.value.image) {
        formData.append('image', form.value.image)
    }
    formData.append('type', form.value.type)
    formData.append('is_featured', form.value.is_featured ? 1 : 0)
    formData.append('topics', JSON.stringify(form.value.selected_topics))

    Inertia.post(route('admin.courses.update', props.course.id), formData, {
        forceFormData: true
    })
}
</script>

<style scoped>
/* Custom styling if needed */
</style>
