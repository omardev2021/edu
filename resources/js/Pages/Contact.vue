<template>
    <Head title="تواصل معنا"/>
    <Nav />

    <Feedback />

    <div class="flex flex-col bg-mainColor p-4 md:p-20 font-primary mx-auto font-primary">
        <!-- Header Section -->
        <div class="bg-softBlue text-white p-6 rounded-lg shadow-md mb-8 text-center">
            <h1 class="text-3xl font-bold mb-2">اتصل بنا</h1>
            <p class="text-md">نحن هنا للإجابة على أي أسئلة قد تكون لديك حول خدماتنا.</p>
        </div>

        <!-- Contact Information Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <img src="/images/email.png" alt="Email Icon" class="w-12 h-12 ml-4">
                <div>
                    <h2 class="text-xl font-bold">البريد الإلكتروني</h2>
                    <p class="text-gray-600">info@example.com</p>
                </div>
            </div>
            <div class="flex items-center mb-4 md:mb-0">
                <img src="/images/viber.png" alt="Phone Icon" class="w-12 h-12 ml-4">
                <div>
                    <h2 class="text-xl font-bold">رقم الهاتف</h2>
                    <p class="text-gray-600">+966 123 456 789</p>
                </div>
            </div>
            <div class="flex items-center">
                <img src="/images/location.png" alt="Location Icon" class="w-12 h-12 ml-4">
                <div>
                    <h2 class="text-xl font-bold">الموقع</h2>
                    <p class="text-gray-600">الرياض، المملكة العربية السعودية</p>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="bg-white p-10 rounded-lg shadow-md">
            <form @submit.prevent="submitForm">
                <div class="mb-8">
                    <label for="name" class="block text-gray-700 font-bold mb-2">الاسم الكامل</label>
                    <input type="text" v-model="form.name" id="name" class="w-full border-gray-300 rounded-lg shadow-md p-3 text-lg" required />
                </div>
                <div class="mb-8">
                    <label for="email" class="block text-gray-700 font-bold mb-2">البريد الإلكتروني</label>
                    <input type="email" v-model="form.email" id="email" class="w-full border-gray-300 rounded-lg shadow-md p-3 text-lg" required />
                </div>
                <div class="mb-8">
                    <label for="message" class="block text-gray-700 font-bold mb-2">الرسالة</label>
                    <textarea v-model="form.message" id="message" class="w-full border-gray-300 rounded-lg shadow-md p-3 text-lg" rows="6" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-softRed text-white font-bold py-3 px-8 w-full rounded-lg hover:bg-softBlue transition duration-300">
                        إرسال
                    </button>
                </div>
            </form>
        </div>
    </div>
    <Footer />
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import Nav from "@/Pages/Components/Nav.vue";
import Footer from "@/Pages/Components/Footer.vue";
import Feedback from "@/Pages/Components/Feedback.vue";


export default {
    components: {Footer, Nav,Feedback,Head},
    setup() {
        const toast = useToast();

        const form = ref({
            name: '',
            email: '',
            message: '',
        });

        const submitForm = async () => {
            try {
                await Inertia.post(route('contact.store'), form.value);
                showSuccessToast();
                resetForm(); // Clear the form inputs
            } catch (error) {
                console.error('Failed to send message', error);
                showErrorToast('فشل في الإرسال'); // Show error toast on failure
            }
        };

        const showSuccessToast = () => {
            toast.success('تم الإرسال بنجاح', {
                position: 'top-left',
                duration: 5000,
            });
        };

        const showErrorToast = (message) => {
            toast.error(message, {
                position: 'top-left',
                duration: 3000,
            });
        };

        const resetForm = () => {
            form.value = {
                name: '',
                email: '',
                message: '',
            };
        };

        return {
            form,
            submitForm,
        };
    },
};
</script>

<style scoped>
* {
    direction: rtl;
}
.bg-mainColor {
    background-color: #f3f4f6;
}
.font-primary {
    font-family: 'Cairo', sans-serif;
}
</style>
