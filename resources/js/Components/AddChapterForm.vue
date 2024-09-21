<template>
    <div>
        <h3 class="text-xl font-semibold mb-4">Add New Chapter</h3>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium">Chapter Title</label>
                <input type="text" v-model="form.title" id="title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
            </div>

            <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">Add Chapter</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
    title: ''
})

const submitForm = () => {
    // Emit event with form data to parent
    console.log('Creating chapter with title:', form.value.title)
}
</script>

<style scoped>
/* Add any required styles */
</style>
