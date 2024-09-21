<template>
    <div class="flex min-h-screen bg-mainColor font-primary">
        <!-- Admin Sidebar (same as before) -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold">طلبات التواصل</h2>

            </header>

            <!-- Content: Contacts Table -->
            <main class="flex-1 p-6 ">
                <h3 class="text-xl font-semibold mb-6">طلبات التواصل (Contact Form)</h3>

                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-darkBlue text-mainColor">
                    <tr>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الاسم</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الايميل</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الرسالة</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(contact, index) in contacts" :key="index" class="border-b">
                        <td class="py-3 px-4">{{ contact.name }}</td>
                        <td class="py-3 px-4">{{ contact.email }}</td>
                        <td class="py-3 px-4">{{ contact.message }}</td>

                    </tr>
                    </tbody>
                </table>
            </main>

            <main class="flex-1 p-6">
                <h3 class="text-xl font-semibold mb-6">اراء العملاء او المقترحات (Feedbacks)</h3>

                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-darkBlue text-mainColor">
                    <tr>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الاسم</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الايميل</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الرسالة</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(contact, index) in feedbacks" :key="index" class="border-b">
                        <td class="py-3 px-4">{{ contact.user.name }}</td>
                        <td class="py-3 px-4">{{ contact.user.email }}</td>
                        <td class="py-3 px-4">{{ contact.message }}</td>

                    </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</template>

<script setup>
import AdminSidebar from '@/Components/AdminSidebar.vue'
import { ref } from 'vue'


const props = defineProps({
    contacts: Array,
    feedbacks: Array
})
// Mock data for contacts


const goToCreateContact = () => {
    console.log('Navigating to create contact page...')
    // Add routing logic here
}

const deleteContact = (id) => {
    console.log('Delete contact with id:', id)
    // Add logic to handle deleting the contact
}
</script>

<style scoped>
/* Add some basic styles */
</style>
