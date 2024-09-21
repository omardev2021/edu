<template>
    <div class="flex min-h-screen bg-mainColor font-primary font-primary">
        <!-- Admin Sidebar -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-6 flex justify-between items-center shadow-md">
                <h2 class="text-2xl font-semibold">المستخدمين</h2>
            </header>

            <!-- Content: Users Table -->
            <main class="flex-1 p-6">
                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-darkBlue text-mainColor">
                    <tr>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الاسم</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">الايميل</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">حالة الاشتراك</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id" class="border-b">
                        <td class="py-3 px-4">{{ user.name }}</td>
                        <td class="py-3 px-4">{{ user.email }}</td>
                        <td class="py-3 px-4">
                            <!-- Display subscription status based on 'status' field -->
                            <span v-if="user.status === 'joined'" class="text-green-600 font-semibold">مشترك</span>
                            <span v-else class="text-red-600 font-semibold">غير مشترك</span>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </main>

            <!-- Modal for Edit User -->
        </div>
    </div>
</template>

<script setup>
import AdminSidebar from '@/Components/AdminSidebar.vue'


const props = defineProps({
    users: Array,
})



// Open modal to edit user

// Close the modal


// Update user details


// Delete user

</script>

<style scoped>
/* Add custom styling here */
</style>
