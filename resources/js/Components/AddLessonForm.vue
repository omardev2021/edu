<template>
    <div>
        <h3 class="text-xl font-semibold mb-4">Add New Lesson</h3>
        <form @submit.prevent="submitForm">
            <!-- Lesson Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium">Lesson Title</label>
                <input
                    type="text"
                    v-model="form.title"
                    id="title"
                    class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg"
                    required
                />
            </div>

            <!-- Lesson Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">Lesson Description</label>
                <textarea
                    v-model="form.description"
                    id="description"
                    class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg"
                    rows="4"
                    required
                ></textarea>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">
                    Add Lesson
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'

// Form data for new lesson
const form = ref({
    title: '',
    description: ''
})

// Submit form
const submitForm = () => {
    console.log('Creating lesson with data:', form.value)
    // You can add logic here to emit data to the parent component
    // or make an API call to save the lesson.
}
</script>

<style scoped>
/* Add any custom styling if needed */
</style>
