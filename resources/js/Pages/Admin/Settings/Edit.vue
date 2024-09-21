<template>

    <div class="flex min-h-screen bg-mainColor font-primary">
        <AdminSidebar />

        <div class="flex-1 flex flex-col">
            <header class="bg-softBlue text-mainColor p-6 flex justify-between items-center shadow-md">
                <h2 class="text-xl font-bold tracking-tight">اعدادات الصفحة الرئيسية</h2>
            </header>

            <main class="flex-1 p-8 space-y-8">
                <div class="p-6 bg-white rounded-lg shadow-lg max-w-6xl mx-auto">


                    <form @submit.prevent="updateSettings">
                        <div class="mb-4">
                            <label class="block font-semibold mb-2">عنوان الدورة</label>
                            <input v-model="form.program_name" type="text" class="w-full p-2 border border-gray-300 rounded" />
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">وصف الدورة</label>
                            <textarea v-model="form.program_description" class="w-full p-2 border border-gray-300 rounded"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">الايميل</label>
                            <input v-model="form.email" type="email" class="w-full p-2 border border-gray-300 rounded" />
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">رقم الجوال</label>
                            <input v-model="form.phone" type="text" class="w-full p-2 border border-gray-300 rounded" />
                        </div>

                        <button type="submit" class="px-4 py-2 bg-softBlue text-white rounded">تعديل وحفظ</button>
                    </form>
                </div>
            </main>

        </div>
    </div>


</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AdminSidebar from "@/Components/AdminSidebar.vue";


// Props passed from the backend
const props = defineProps({
    setting: Array,
});

// Using a ref to create a reactive form object
const form = ref({
    program_name: props.setting.program_name || '',
    program_description: props.setting.program_description || '',
    email: props.setting.email || '',
    phone: props.setting.phone || '',
});

// Function to handle saving settings
const updateSettings = () => {
    Inertia.post(route('settings.update'), form.value, {
        onSuccess: () => {
            console.log('Settings updated successfully');
        },
        onError: (errors) => {
            console.error('Failed to update settings:', errors);
        }
    });
};
</script>
