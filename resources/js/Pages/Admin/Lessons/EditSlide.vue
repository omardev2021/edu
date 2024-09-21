<template>
    <div class="flex min-h-screen bg-mainColor">
        <AdminSidebar />

        <div class="flex-1 flex flex-col">
            <header class="bg-softBlue text-mainColor p-6 flex justify-between items-center shadow-md">
                <h2 class="text-3xl font-bold tracking-tight">تعديل صفحة الدرس</h2>
            </header>

            <main class="flex-1 p-8 space-y-8">
                <section>
                    <div class="bg-white w-full max-w-6xl p-8 rounded-lg shadow-lg">
                        <form @submit.prevent="saveSlide">
                            <div class="mb-4">
                                <!-- Bind to slideData.content -->
                                <MarkdownEditor v-model="slideData.content">
                                    <template #toolbar="{ editor }">
                                        <!-- Editor toolbar content can be added here if needed -->
                                    </template>
                                </MarkdownEditor>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-softRed  rounded-lg">تعديل</button>
                        </form>
                    </div>
                </section>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import AdminSidebar from '@/Components/AdminSidebar.vue';
import { Inertia } from '@inertiajs/inertia';
import MarkdownEditor from "@/Components/MarkdownEditor.vue";

// Props passed from the parent component or page
const props = defineProps({
    lesson: Object,
    slide: Object
});

// Reactive object to hold the slide data
const slideData = ref({
    id: props.slide.id,
    content: '',  // Initialize with an empty string

});

// Ensure slide content is loaded correctly
onMounted(() => {
    if (props.slide.content) {
        slideData.value.content = props.slide.content;
    }



    console.log('Slide content loaded:', slideData.value.content);
});

// Watch the props in case the slide prop is updated externally
watch(() => props.slide, (newSlide) => {
    if (newSlide.content) {
        slideData.value.content = newSlide.content;
    }


});

// Function to save the slide
const saveSlide = () => {
    Inertia.put(route('admin.slides.update', [props.lesson.id, slideData.value.id]), {
        content: slideData.value.content,  // Save content field

    }, {
        onSuccess: () => {
            console.log('Slide updated successfully');
        },
        onError: (errors) => {
            console.error('Error updating slide', errors);
        }
    });
};

// Function to close modals (optional)
const closeModals = () => {
    // Add your modal closing logic here
};
</script>
