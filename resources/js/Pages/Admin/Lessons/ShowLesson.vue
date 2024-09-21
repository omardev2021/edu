<template>

    <div class="flex min-h-screen bg-mainColor">
        <!-- Admin Sidebar -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col font-primary">
            <!-- Header -->
            <header class="bg-softBlue text-mainColor p-6 flex justify-between items-center shadow-md">
                <h2 class="text-3xl font-bold tracking-tight">{{ lesson.title }}</h2>
            </header>

            <!-- Content: Slides, Objectives, Terms, and Add Buttons -->
            <main class="flex-1 p-8 space-y-8">
                <Link :href="route('admin.courses.show',lesson.chapter.course)" class=" hover:text-blue-800">
                    <i class="fas fa-arrow-right"></i> الرجوع لصفحة الكورس
                </Link>
                <!-- Slides List -->
                <section>
                    <h4 class="text-2xl font-semibold mb-4">جميع صفحات الدرس (Slides)</h4>
                    <ul class="bg-white shadow-md rounded-lg divide-y divide-gray-200">
                        <li v-for="(slide, index) in lesson.slides" :key="slide.id" class="p-4 flex justify-between items-center">
                            <div class="space-x-4">
                                <!-- Display the index starting from 1 -->
                                <span class="text-lg font-semibold">{{ index + 1 }}. </span>
                                <Link :href="route('admin.slides.edit', [lesson.id, slide.id])" class="text-green-600 mx-2 hover:text-green-800">
                                    <i class="fas fa-edit"></i> تعديل
                                </Link>
                                <button @click="deleteSlide(slide.id)" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                                <!-- Preview Button -->
                                <button @click="previewSlide(slide)" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i> معاينة
                                </button>
                            </div>

                        </li>
                    </ul>
                    <div class="mt-6">
                        <Link :href="route('admin.slides.create',lesson)" class="mt-5 px-4 py-2 bg-softRed rounded-lg">
                            اضافة صفحة (slide)
                        </Link>
                    </div>

                </section>

                <!-- Objectives List -->
                <section>
                    <h4 class="text-2xl font-semibold mb-4">اهداف الدرس</h4>
                    <ul class="bg-white shadow-md rounded-lg divide-y divide-gray-200">
                        <li v-for="objective in lesson.objectives" :key="objective.id" class="p-4 flex justify-between items-center">
                            <div class="text-lg text-gray-700">{{ objective.title }}</div>
                            <div class="flex space-x-2">
                                <button @click="editObjective(objective)" class="text-green-600 mx-2 hover:text-green-800">
                                    <i class="fas fa-edit"></i> تعديل
                                </button>
                                <button @click="deleteObjective(objective.id)" class="text-red-600  hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                            </div>
                        </li>
                    </ul>
                    <button @click="showAddObjectiveForm" class="mt-4 px-4 py-2 bg-softRed  rounded-lg ">
                        اضافة
                    </button>
                </section>

                <!-- Terms List -->
                <section>
                    <h4 class="text-2xl font-semibold mb-4">المصطلحات الرئيسية</h4>
                    <ul class="bg-white shadow-md rounded-lg divide-y divide-gray-200">
                        <li v-for="term in lesson.terms" :key="term.id" class="p-4 flex justify-between items-center">
                            <div class="text-lg text-gray-700">{{ term.title }} - {{ term.content }}</div>
                            <div class="flex space-x-2">
                                <button @click="editTerm(term)" class="text-green-600 mx-2 hover:text-green-800">
                                    <i class="fas fa-edit"></i> تعديل
                                </button>
                                <button @click="deleteTerm(term.id)" class="text-red-600  hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                            </div>
                        </li>
                    </ul>
                    <button @click="showAddTermForm" class="mt-4 px-4 py-2 bg-softRed  rounded-lg ">
                        اضافة
                    </button>
                </section>
            </main>




            <!-- Full-width Modals for Forms -->
            <div v-if="isAddSlideModalVisible" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
                <div class="bg-white w-full max-w-6xl p-8 rounded-lg shadow-lg">
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Add New Slide</h3>
                        <form @submit.prevent="addSlide">
                            <div class="mb-4">
                                <label for="slide_content" class="block text-sm font-medium">Slide Content</label>
                                <MarkdownEditor v-model="slideForm.content">
                                    <template #toolbar="{ editor }">


                                    </template>
                                </MarkdownEditor>
                                <!--                            <textarea v-model="slideForm.content" id="slide_content" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required></textarea>-->
                            </div>
                            <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">Add Slide</button>
                            <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400 text-white rounded-lg">Cancel</button>

                        </form>
                    </div>
                </div>
            </div>



            <!-- Full-width Modals for editing a slide -->
            <div v-if="isEditSlideModalVisible" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
                <div class="bg-white w-full max-w-4xl p-8 rounded-lg shadow-lg">
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Edit Slide</h3>
                        <form @submit.prevent="updateSlide">
                            <div class="mb-4">
                                <label for="slide_content" class="block text-sm font-medium">Slide Content</label>
                                <MarkdownEditor v-model="slideForm.content">
                                    <template #toolbar="{ editor }">
                                        <!-- Toolbar content here -->
                                    </template>
                                </MarkdownEditor>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">Update Slide</button>
                            <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400 text-white rounded-lg">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>



            <Modal v-if="isAddObjectiveModalVisible" @close="closeModals">
                <div>
                    <h3 class="text-xl font-semibold mb-4">اضافة هدف للدرس</h3>
                    <form @submit.prevent="addObjective">
                        <div class="mb-4">
                            <label for="objective_title" class="block text-sm font-medium">العنوان</label>
                            <textarea v-model="objectiveForm.title" id="objective_title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">اضافة</button>
                        <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400 text-white rounded-lg">اغلاق</button>

                    </form>
                </div>
            </Modal>

            <Modal v-if="isAddTermModalVisible" @close="closeModals">
                <div>
                    <h3 class="text-xl font-semibold mb-4">اضافة مصطلح للدرس</h3>
                    <form @submit.prevent="addTerm">
                        <div class="mb-4">
                            <label for="term_title" class="block text-sm font-medium">العنوان</label>
                            <input v-model="termForm.title" id="term_title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
                        </div>
                        <div class="mb-4">
                            <label for="term_content" class="block text-sm font-medium">الوصف</label>
                            <textarea v-model="termForm.content" id="term_content" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">اضافة</button>
                        <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400 text-white rounded-lg">اغلاق</button>

                    </form>
                </div>
            </Modal>


            <!-- Modal for Editing Objective -->
            <Modal v-if="isEditObjectiveModalVisible" @close="closeModals">
                <div>
                    <h3 class="text-xl font-semibold mb-4">تعديل هدف للدرس</h3>
                    <form @submit.prevent="updateObjective">
                        <div class="mb-4">
                            <label for="objective_title" class="block text-sm font-medium">العنوان</label>
                            <textarea v-model="objectiveForm.title" id="objective_title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">تعديل</button>
                        <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400 text-white rounded-lg">اغلاق</button>

                    </form>
                </div>
            </Modal>


            <!-- Modal for Editing Term -->
            <Modal v-if="isEditTermModalVisible" @close="closeModals">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Edit Term</h3>
                    <form @submit.prevent="updateTerm">
                        <div class="mb-4">
                            <label for="term_title" class="block text-sm font-medium">العنوان</label>
                            <input v-model="termForm.title" id="term_title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
                        </div>
                        <div class="mb-4">
                            <label for="term_content" class="block text-sm font-medium">الوصف</label>
                            <textarea v-model="termForm.content" id="term_content" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">تعديل</button>
                        <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400 text-white rounded-lg">اغلاق</button>

                    </form>
                </div>
            </Modal>


            <!-- Fullscreen Modal for Preview -->
            <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white w-full max-w-4xl h-5/6 p-6 rounded-lg shadow-lg overflow-y-auto relative">
                    <button @click="closeModals" class="text-red-600 hover:text-red-800 absolute top-4 right-4">
                        <i class="fas fa-times"></i> اغلاق
                    </button>
                    <!-- Scrollable Content -->
                    <div class="modal-body max-h-full overflow-y-auto">
                        <article class="mt-6 prose prose-sm max-w-none" v-html="selectedSlide.html"></article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import AdminSidebar from '@/Components/AdminSidebar.vue'
import Modal from '@/Components/AdminModal.vue'
import { Inertia } from '@inertiajs/inertia'
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import  {Link} from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";

const props = defineProps({
    lesson: Object,
})

// State for form modals
const isAddSlideModalVisible = ref(false)
const isAddObjectiveModalVisible = ref(false)
const isAddTermModalVisible = ref(false)
const isEditSlideModalVisible = ref(false)
const isEditObjectiveModalVisible = ref(false)
const isEditTermModalVisible = ref(false)

const isModalOpen = ref(false);
const selectedSlide = ref(null);

// State for form data
const slideForm = ref({ content: 'fffffff' })
const objectiveForm = ref({ title: '' })
const termForm = ref({ title: '', content: '' })

// Show modals
const showAddSlideForm = () => {
    isAddSlideModalVisible.value = true
}


const previewSlide = (slide) => {
    selectedSlide.value = slide;
    isModalOpen.value = true;
};


const showAddObjectiveForm = () => {
    isAddObjectiveModalVisible.value = true
}
const showAddTermForm = () => {
    isAddTermModalVisible.value = true
}


// Edit modals
const editSlide = (slide) => {
    slideForm.value.content = slide.content; // Use slide.html to set the content for editing
    slideForm.value.id = slide.id; // Assuming you need to store the ID as well
    isEditSlideModalVisible.value = true;
}
const editObjective = (objective) => {
    objectiveForm.value.title = objective.title;
    objectiveForm.value.id = objective.id;
    isEditObjectiveModalVisible.value = true;
}
const editTerm = (term) => {
    termForm.value.title = term.title;
    termForm.value.content = term.content;
    termForm.value.id = term.id;
    isEditTermModalVisible.value = true;
}

// CRUD operations

const deleteSlide = (id) => {

    if (confirm('are you sure?')) {
        Inertia.delete(route('admin.slides.destroy', id))

    }
}


const deleteObjective = (id) => {
    if (confirm('are you sure?')) {
        Inertia.delete(route('objectives.destroy', id))

    }
}


const deleteTerm = (id) => {
    if (confirm('are you sure?')) {
        Inertia.delete(route('terms.destroy', id))

    }

}

// Form submission methods
const addSlide = () => {
    Inertia.post(route('admin.slides.store', props.lesson.id), slideForm.value, {
        onSuccess: () => {
            closeModals()
            slideForm.value.content = ''
        }
    })
}

const addObjective = () => {
    Inertia.post(route('admin.objectives.store', props.lesson.id), objectiveForm.value, {
        onSuccess: () => {
            closeModals()
            objectiveForm.value.title = ''
        }
    })
}

const addTerm = () => {
    Inertia.post(route('admin.terms.store', props.lesson.id), termForm.value, {
        onSuccess: () => {
            closeModals()
            termForm.value.title = ''
            termForm.value.content = ''
        }
    })
}

// Update methods
const updateSlide = () => {
    Inertia.put(route('admin.slides.update', slideForm.value.id), slideForm.value, {
        onSuccess: () => {
            closeModals()
            slideForm.value.content = ''
        }
    })
}

const updateObjective = () => {
    Inertia.put(route('admin.objectives.update', objectiveForm.value.id), objectiveForm.value, {
        onSuccess: () => {
            closeModals()
            objectiveForm.value.title = ''
        }
    })
}

const updateTerm = () => {
    Inertia.put(route('admin.terms.update', termForm.value.id), termForm.value, {
        onSuccess: () => {
            closeModals()
            termForm.value.title = ''
            termForm.value.content = ''
        }
    })
}

// Close modals
const closeModals = () => {
    isAddSlideModalVisible.value = false
    isAddObjectiveModalVisible.value = false
    isAddTermModalVisible.value = false
    isEditSlideModalVisible.value = false;
    isEditObjectiveModalVisible.value = false;
    isEditTermModalVisible.value = false;
    slideForm.value.content = ''
    termForm.value.title = ''
    termForm.value.content = ''
    objectiveForm.value.title = ''

    isModalOpen.value = false;
    selectedSlide.value = null;
}
</script>

<style scoped>
button {
    transition: background-color 0.3s ease;
}
/*button:hover {*/
/*    background-color: #ef4444;*/
/*    color: #fff;*/
/*}*/

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
}
.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 90%;
    max-height: 90%;
    overflow-y: auto;
}
</style>
