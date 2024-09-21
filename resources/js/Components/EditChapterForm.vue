<template>
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Edit Chapter</h3>

        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="chapter-title" class="block text-gray-700 font-medium mb-2">Chapter Title</label>
                <input
                    type="text"
                    id="chapter-title"
                    v-model="formData.title"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-softBlue"
                    placeholder="Enter chapter title"
                    required
                />
            </div>

            <div class="flex justify-end">
                <button type="button" @click="$emit('close')" class="px-4 py-2 mr-2 text-gray-500 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-softBlue rounded-lg hover:bg-lightBlue">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    chapterId: {
        type: Number,
        required: true
    }
})

const emit = defineEmits(['submit', 'close'])

// Placeholder data for initial chapter form (this would come from your actual data source)
const chapterData = ref({
    id: props.chapterId,
    title: ''
})

// Form data
const formData = ref({
    title: ''
})

// Load chapter details when the component is mounted
onMounted(() => {
    // Assuming you fetch the chapter data here based on the `props.chapterId`
    // For now, we're just copying the existing title to formData
    formData.value.title = chapterData.value.title
})

// Submit form
const submitForm = () => {
    emit('submit', formData.value)
}
</script>
