<template>

    <div class="flex min-h-screen bg-mainColor font-primary">
        <!-- Admin Sidebar -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-6 flex justify-between items-center shadow-md">
                <h2 class="text-2xl font-semibold">المواضيع (Tags)</h2>
                <button @click="openCreateModal" class="px-4 py-2 bg-softRed text-black rounded-lg ">
                    اضافة موضوع
                </button>
            </header>

            <!-- Content: Topics Table -->
            <main class="flex-1 p-6">


                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-darkBlue text-mainColor">
                    <tr>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">عنوان الموضوع</th>
                        <th class="text-right py-3 px-4 uppercase font-semibold text-sm">ادارة</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(topic, index) in topics" :key="index" class="border-b">
                        <td class="py-3 px-4">{{ topic.title }}</td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-3">
                                <button @click="openEditModal(topic)" class="px-4 py-2  mx-3 bg-softBlue text-mainColor rounded-lg hover:bg-lightBlue">
                                    تعديل
                                </button>
                                <button @click="deleteTopic(topic.id)" class="px-4 py-2 bg-softRed mx-3 text-mainColor rounded-lg hover:bg-purpleCustom">
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </main>

            <!-- Modal for Add/Edit Topic -->
            <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                    <h2 class="text-2xl mb-4">{{ isEditing ? 'تعديل الموضوع' : 'اضافة موضوع' }}</h2>
                    <form @submit.prevent="isEditing ? updateTopic() : storeTopic()">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-2">عنوان الموضوع</label>
                            <input type="text" v-model="form.title" class="w-full p-2 border rounded-md" required />
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softBlue text-mainColor rounded-lg hover:bg-lightBlue">
                            {{ isEditing ? 'تعديل' : 'اضافة' }}
                        </button>
                        <button type="button" @click="closeModal" class="px-4 py-2 mr-2 bg-gray-400 text-mainColor rounded-lg hover:bg-gray-500">
                            اغلاق
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AdminSidebar from '@/Components/AdminSidebar.vue'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Banner from "@/Components/Banner.vue";

const props = defineProps({
    topics: Array,
})

const isModalOpen = ref(false);
const isEditing = ref(false);
const form = useForm({
    title: '',
    id: null,
});

const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    isModalOpen.value = true;
}

const openEditModal = (topic) => {
    isEditing.value = true;
    form.title = topic.title;
    form.id = topic.id;
    isModalOpen.value = true;
}

const closeModal = () => {
    isModalOpen.value = false;
}

const storeTopic = () => {
    form.post(route('admin.topics.store'), {
        onSuccess: () => closeModal(),
    });
}

const updateTopic = () => {
    form.put(route('admin.topics.update', form.id), {
        onSuccess: () => closeModal(),
    });
}

const deleteTopic = (id) => {
    if (confirm('Are you sure you want to delete this topic?')) {
        form.delete(route('admin.topics.destroy', id), {
            onSuccess: () => {},
        });
    }
}
</script>

<style scoped>
/* Add some basic styles */
</style>
