<template>
    <div>
        <h3 class="text-xl font-semibold mb-4">Add New Objective</h3>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium">Objective Title</label>
                <input type="text" v-model="form.title" id="title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
            </div>
            <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">Add Objective</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({ title: '' })

const submitForm = () => {
    const objectiveData = { ...form.value }
    $emit('submit', objectiveData)
}
</script>
