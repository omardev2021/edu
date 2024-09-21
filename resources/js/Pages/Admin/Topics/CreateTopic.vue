<template>
    <div class="flex min-h-screen bg-mainColor">
        <!-- Admin Sidebar (same as before) -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold">Create New Topic</h2>
            </header>

            <!-- Content: Form to Add New Topic -->
            <main class="flex-1 p-6">
                <h3 class="text-xl font-semibold mb-6">Topic Information</h3>

                <form @submit.prevent="createTopic">
                    <!-- Topic Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-darkBlue">Topic Title</label>
                        <input type="text" v-model="form.title" id="title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg hover:bg-lightBlue">
                            Create Topic
                        </button>
                    </div>
                </form>
            </main>
        </div>
    </div>
</template>

<script setup>
import AdminSidebar from '@/Components/AdminSidebar.vue'
import { ref } from 'vue'

const form = ref({
    title: ''
})

const createTopic = () => {
    console.log('Creating topic with title:', form.value.title)
    // Add logic to submit form and create a new topic
}
</script>

<style scoped>
/* Basic form styling */
</style>
