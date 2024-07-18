<template>
    <div class="bg-[#F3F4FF] min-h-screen font-primary flex flex-col" dir="rtl">
        <Nav />
        <div class="flex-grow flex items-center justify-center">
            <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-8">
                <h1 class="text-3xl font-bold mb-6 text-center text-veryDarkBlue">حالة الدفع</h1>
                <div v-if="status === 'success'" class="text-center text-green-500">
                    <p class="mb-4">تمت عملية الدفع بنجاح! تم إنشاء ملفك الشخصي بنجاح.</p>
                    <button @click="goHome" class="w-full bg-softBlue text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">العودة إلى الصفحة الرئيسية</button>
                </div>
                <div v-else class="text-center text-red-500">
                    <img src="/images/fail-image.png" width="200" class="mx-auto">
                    <p class="mb-5">فشلت عملية الدفع. الرجاء التحقق من بيانات بطاقة الدفع وإعادة المحاولة مرة أخرى.</p>
                    <div>
                        <Link :href="route('checkout')" class="block w-full bg-softRed text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">إعادة المحاولة</Link>
                    </div>
                    <div class="mt-3">
                        <Link :href="route('path.show', 1)" class="block w-full bg-softBlue text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">الرئيسية</Link>
                    </div>

                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { useRouter } from 'vue-router';
import Nav from "@/Pages/Components/Nav.vue";
import Footer from "@/Pages/Components/Footer.vue";
import {Link} from '@inertiajs/vue3';

const { props } = usePage();
const status = ref(props.status);
const router = useRouter();

function goHome() {
    router.push('/');
}

function retryPayment() {
    // Implement retry logic or redirect to the payment page
    router.push('/checkout');
}
</script>

<style scoped>
.min-h-screen {
    min-height: 100vh;
}
</style>
