<template>
    <div class="bg-[#F3F4FF] font-primary" dir="rtl">
        <Nav />
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-8">
            <h1 class="text-3xl font-bold mb-6 text-center text-veryDarkBlue">التسجيل في الدورة</h1>
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الاسم</label>
                    <input v-model="form.name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">البريد الالكتروني</label>
                    <input v-model="form.email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">رقم الجوال</label>
                    <input v-model="form.phone" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">المدينة</label>
                    <input v-model="form.city" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الجامعة</label>
                    <input v-model="form.university" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">المسمى الوظيفي</label>
                    <input v-model="form.jobTitle" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                </div>
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">تفاصيل الدورة</h2>
                    <p class="mt-2 text-gray-600">إسم الدورة: <span class="font-medium">دورة إدارة المخزون للمطاعم والكافيهات</span></p>
                    <p class="mt-1 text-gray-600">السعر: <span class="font-medium">300 ر.س</span></p>
                </div>
                <button :disabled="loading" type="submit" class="w-full bg-softBlue text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span v-if="loading">جاري التحويل...</span>
                    <span v-else>المتابعة لعملية الدفع</span>
                </button>
            </form>
        </div>
    </div>
    <Footer />
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import Nav from "@/Pages/Components/Nav.vue";
import Footer from "@/Pages/Components/Footer.vue";

const form = useForm({
    name: '',
    email: '',
    phone: '',
    university: '',
    city: '',
    jobTitle: '',
});

const loading = ref(false);

function submitForm() {
    loading.value = true;
    form.post('/payment', {
        onError: (errors) => {
            loading.value = false;
            // handle errors
            console.log(errors);
        },
        onSuccess: (response) => {
            loading.value = false;
            // handle success, possibly redirect to the payment URL
            if (response.payment) {
                window.location.href = response.payment;
            }
        }
    });
}
</script>

<style>
*{
    direction: rtl;
}
</style>
