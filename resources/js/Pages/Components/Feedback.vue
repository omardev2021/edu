<template>
    <div class="font-primary">
        <!-- Feedback Button -->
        <div id="feedback-button" @click="openModal = true" class="fixed top-1/2 -left-3 transform -translate-y-1/2 bg-softBlue text-white pl-3 pr-2 py-4 rounded-r cursor-pointer hover:pl-5 transition-all duration-300 z-50">
            <span class="block"><i class="fas fa-message"></i> Feedback</span>
        </div>

        <!-- Feedback Modal with Transition -->
        <Transition
            enter-active-class="transition-opacity transition-transform duration-300"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition-opacity transition-transform duration-300"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="openModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" @click.self="closeModal">
                <form @submit.prevent="submitFeedback">
                    <div class="bg-white p-6 rounded-lg shadow-xl relative w-full max-w-lg">
                        <button class="absolute top-3 right-3 text-2xl font-bold text-gray-600 hover:text-gray-800 transition-colors" @click="closeModal">&times;</button>
                        <h2 class="text-2xl font-semibold mb-4 text-gray-800 text-center">اكتب إنطباعك</h2>
                        <textarea v-model="form.message" id="message" placeholder="مرحبا ، اريد فقط ان اقول ..." class="w-full p-3 border border-gray-300 rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        <div v-if="errors.message" class="text-red-600 mb-2">{{ errors.message[0] }}</div>
                        <div class="mb-4 text-gray-600">
                            <p>يمكنك أيضًا التواصل معنا مباشرةً على عنوان البريد الإلكتروني <a href="mailto:feedback@lowkalo.com" class="text-blue-500 hover:underline">feedback@lowkalo.com</a></p>
                        </div>
                        <button class="bg-softRed w-full text-white px-4 py-2 rounded hover:bg-green-600 transition-colors" type="submit">إرسال</button>
                    </div>
                </form>
            </div>
        </Transition>
    </div>
</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
    setup() {
        const openModal = ref(false);
        const errors = ref({});
        const toast = useToast();

        const form = ref({
            message: '',
        });

        const closeModal = () => {
            openModal.value = false;
        };

        const submitFeedback = async () => {
            try {
                const response = await Inertia.post(route('feedback.store'), form.value);
                showSuccessToast('تم الإرسال بنجاح');
                resetForm(); // Clear the form inputs
                errors.value = {}; // Clear errors
                closeModal(); // Optionally close modal on success
            } catch (error) {
                console.error('Failed to send message', error);
                showErrorToast('فشل في الإرسال'); // Show error toast on failure
                if (error.response && error.response.data && error.response.data.errors) {
                    errors.value = error.response.data.errors; // Set validation errors
                }
            }
        };



        const showSuccessToast = (message) => {
            toast.success(message, {
                position: 'top-left',
                duration: 3000,
            });
        };

        const showErrorToast = (message) => {
            toast.error(message, {
                position: 'top-right',
                duration: 3000,
            });
        };

        const resetForm = () => {
            form.value.message = '';
        };

        return {
            openModal,
            form,
            closeModal,
            submitFeedback,
            errors,
        };
    },
};
</script>

<style scoped>
* {
    direction: rtl;
}
#feedback-button {
    writing-mode: vertical-rl;
    text-orientation: mixed;
}
</style>
