<template>
    <div class="flex min-h-screen bg-mainColor font-primary">
        <!-- Admin Sidebar -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-6 flex justify-between items-center shadow-md">
                <h2 class="text-3xl font-bold tracking-tight">اضافة صفحة جديدة للدرس</h2>
            </header>

            <!-- Content: Slides, Objectives, Terms, and Add Buttons -->
            <main class="flex-1 p-8 space-y-8">
                <!-- Slides List -->
                <section>

                    <!-- Full-width Modals for Forms -->
                    <div class="bg-white w-full max-w-6xl p-8 rounded-lg shadow-lg">
                        <div>

                            <form @submit.prevent="addSlide">
                                <div class="mb-4">
                                    <label for="slide_content" class="block text-sm font-medium mb-4">محتوي الصفحة</label>
                                    <MarkdownEditor v-model="slideForm.content">
                                        <template #toolbar="{ editor }">


                                        </template>
                                    </MarkdownEditor>
                                    <!--                            <textarea v-model="slideForm.content" id="slide_content" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required></textarea>-->
                                </div>
                                <button type="submit" class="px-4 py-2 bg-softRed  rounded-lg">اضافة</button>

                            </form>
                        </div>
                    </div>

                </section>



            </main>









        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import AdminSidebar from '@/Components/AdminSidebar.vue'
import Modal from '@/Components/AdminModal.vue'
import { Inertia } from '@inertiajs/inertia'
import MarkdownEditor from "@/Components/MarkdownEditor.vue";

const props = defineProps({
    lesson: Object,
})



// State for form data
const slideForm = ref({ content: '' })




// Form submission methods
const addSlide = () => {
    Inertia.post(route('admin.slides.store', props.lesson.id), slideForm.value, {
        onSuccess: () => {

            slideForm.value.content = ''
        }
    })
}





// Update methods



// Close modals

</script>

<style scoped>
button {
    transition: background-color 0.3s ease;
}
/*button:hover {*/
/*    background-color: #ef4444;*/
/*    color: #fff;*/
/*}*/
</style>
