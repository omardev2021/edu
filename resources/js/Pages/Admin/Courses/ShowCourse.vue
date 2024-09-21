<template>

    <div class="flex min-h-screen bg-mainColor font-primary">
        <!-- Admin Sidebar -->
        <AdminSidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-softBlue p-6 flex justify-between items-center shadow-sm">
                <h2 class="text-3xl font-semibold text-white">{{ course.title }}</h2>
                <div class="space-x-4">
                    <button @click="showAddChapterForm" class="px-4 py-2 mx-3 bg-softRed rounded-lg">
                        <i class="fas fa-plus mr-2"></i> اضافة جزء
                    </button>

                    <button @click="showAddHighlightForm" class="px-4 py-2 bg-softRed rounded-lg">
                        <i class="fas fa-plus mr-2"></i> اضافة أبرز المواضيع
                    </button>


                </div>
            </header>

            <!-- Content: Chapters, Highlights, and Add Buttons -->
            <main class="flex-1 p-8 space-y-8">
                <h3 class="text-2xl font-semibold text-veryDarkBlue">جميع الاجزاء</h3>

                <!-- Chapters List -->
                <div v-for="chapter in course.chapters" :key="chapter.id" class="space-y-4">
                    <div class="p-6 bg-white shadow-lg rounded-lg border border-gray-200">
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-semibold text-darkBlue">{{ chapter.chapter_number }}</h3>
                                <h4 class="text-xl font-semibold text-darkBlue">{{ chapter.title }}</h4>

                            </div>

                            <div>
                                <button @click="showAddLessonForm(chapter.id)" class="px-4 py-1 text-sm  bg-softRed rounded-lg">اضافة درس</button>
                                <button @click="editChapter(chapter)" class="px-4 py-2 text-gray-600"><i class="fas fa-edit"></i> تعديل</button>
                                <button @click="deleteChapter(chapter.id)" class="px-4 py-2 text-red-600"> <i class="fas fa-trash-alt"></i> حذف</button>


                            </div>
                        </div>

                        <!-- Lessons within Chapter -->
                        <ul class="mt-4 space-y-2">
                            <li v-for="lesson in chapter.lessons" :key="lesson.id" class="pl-4 flex items-center justify-between">


                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-700">{{ lesson.lesson_number }}</span>
                                    <span class="text-lg text-gray-700">{{ lesson.title }}</span>
                                </div>
                                <div>
                                    <Link :href="route('admin.lessons.show', lesson.id)" class="text-xs bg-softRed px-4 py-2 rounded-lg">تفاصيل الدرس</Link>
                                    <button @click="editLesson(lesson)" class="px-4 py-2 text-gray-600"><i class="fas fa-edit"></i></button>
                                    <button @click="deleteLesson(lesson.id)" class="px-4 py-2 text-red-600"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>


                <!-- Highlights Section -->
                <h3 class="text-2xl font-semibold text-veryDarkBlue">أبرز المواضيع</h3>
                <div v-for="highlight in course.highlights" :key="highlight.id" class="space-y-4">
                    <div class="p-6 bg-white shadow-lg rounded-lg border border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl text-darkBlue">{{ highlight.content }}</span>
                            <div>
                                <button @click="editHighlight(highlight)" class="px-4 py-2 text-gray-600"><i class="fas fa-edit"></i> تعديل</button>
                                <button @click="deleteHighlight(highlight.id)" class="px-4 py-2 text-red-600"><i class="fas fa-trash-alt"></i> حذف</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Modals for Add/Edit Forms -->
            <Modal v-if="isChapterModalVisible" @close="closeModals">
                <div>
                    <h3 class="text-xl font-semibold mb-4">{{ isEditingChapter ? 'تعديل الجزء' : 'اضافة جزء جديد' }}</h3>
                    <form @submit.prevent="submitChapterForm">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium">عنوان الجزء</label>
                            <input type="text" v-model="chapterForm.title" id="title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg mb-4" required />
                            <label for="chapter_number" class="block text-sm font-medium">رقم الجزء (مثال : الجزء الاول)</label>
                            <input type="text" v-model="chapterForm.chapter_number" id="chapter_number" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softRed  rounded-lg">{{ isEditingChapter ? 'تعديل' : 'اضافة' }}</button>
                        <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400  rounded-lg">اغلاق</button>

                    </form>
                </div>
            </Modal>

            <Modal v-if="isLessonModalVisible" @close="closeModals">
                <div>
                    <h3 class="text-xl font-semibold mb-4">{{ isEditingLesson ? 'تعديل الدرس' : 'اضافة درس جديد' }}</h3>
                    <form @submit.prevent="submitLessonForm">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium">عنوان الدرس</label>
                            <input type="text" v-model="lessonForm.title" id="title" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" required />
                        </div>
                        <div class="mb-4">
                            <label for="lesson_number" class="block text-sm font-medium">رقم الدرس (مثال : الدرس الاول)</label>
                            <textarea v-model="lessonForm.lesson_number" id="lesson_number" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softRed text-mainColor rounded-lg">{{ isEditingLesson ? 'تعديل' : 'اضافة' }}</button>
                        <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400  rounded-lg">اغلاق</button>
                    </form>
                </div>
            </Modal>



            <!-- Add/Edit Highlight Modal -->
            <Modal v-if="isHighlightModalVisible" @close="closeModals">
                <div>
                    <h3 class="text-xl font-semibold mb-4">{{ isEditingHighlight ? 'تعديل أبرز الموضوع' : 'اضافة أبرز الموضوع' }}</h3>
                    <form @submit.prevent="submitHighlightForm">
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium">المحتوى</label>
                            <textarea v-model="highlightForm.content" id="content" class="mt-1 block w-full px-4 py-2 border border-grayDark rounded-lg" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-softRed  rounded-lg">{{ isEditingHighlight ? 'تعديل' : 'اضافة' }}</button>
                        <button @click="closeModals" class="mr-4 px-4 py-2 bg-gray-400  rounded-lg">اغلاق</button>
                    </form>
                </div>
            </Modal>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import AdminSidebar from '@/Components/AdminSidebar.vue'
import Modal from '@/Components/AdminModal.vue'
import { Link } from '@inertiajs/vue3'
import Banner from './../../../Components/Banner.vue';


const props = defineProps({ course: Object })

// State for modals and editing
const isChapterModalVisible = ref(false)
const isLessonModalVisible = ref(false)
const isEditingChapter = ref(false)
const isEditingLesson = ref(false)
const activeChapterId = ref(null)
const chapterToEdit = ref(null)
const highlightToEdit = ref(null)
const lessonToEdit = ref(null)
const isHighlightModalVisible = ref(false)
const isEditingHighlight = ref(false)


// Form state
const chapterForm = ref({
    title: '',
    chapter_number: '',
})

const lessonForm = ref({
    title: '',
    lesson_number: '',
})

const highlightForm = ref({ content: '' })

// Show modals
const showAddHighlightForm = () => {
    resetHighlightForm()
    isHighlightModalVisible.value = true
    isEditingHighlight.value = false
}

// Submit Highlight Form
const submitHighlightForm = () => {
    if (isEditingHighlight.value) {
        Inertia.put(route('admin.highlights.update', highlightToEdit.value.id), highlightForm.value, {
            onSuccess: closeModals,
        })
    } else {
        Inertia.post(route('admin.highlights.store', props.course.id), highlightForm.value, {
            onSuccess: closeModals,
        })
    }
}

// Edit Highlight
const editHighlight = (highlight) => {
    highlightToEdit.value = highlight
    highlightForm.value = { content: highlight.content }
    isEditingHighlight.value = true
    isHighlightModalVisible.value = true
}

// Delete Highlight
const deleteHighlight = (highlightId) => {
    if (confirm('Are you sure you want to delete this highlight?')) {
        Inertia.delete(route('admin.highlights.destroy', highlightId))
    }
}

// Reset form states
const resetHighlightForm = () => {
    highlightForm.value = { content: '' }
}

// Show modals
const showAddChapterForm = () => {
    resetChapterForm()
    isChapterModalVisible.value = true
    isEditingChapter.value = false
}

const showAddLessonForm = (chapterId) => {
    resetLessonForm()
    activeChapterId.value = chapterId
    isLessonModalVisible.value = true
    isEditingLesson.value = false
}

// Edit chapter
const editChapter = (chapter) => {
    chapterToEdit.value = chapter
    chapterForm.value = { title: chapter.title, chapter_number: chapter.chapter_number }
    isEditingChapter.value = true
    isChapterModalVisible.value = true
}

// Edit lesson
const editLesson = (lesson) => {
    lessonToEdit.value = lesson
    lessonForm.value = { title: lesson.title, lesson_number: lesson.lesson_number }
    isEditingLesson.value = true
    isLessonModalVisible.value = true
}

// Submit Chapter Form
const submitChapterForm = () => {
    if (isEditingChapter.value) {
        Inertia.put(route('admin.chapters.update', chapterToEdit.value.id), chapterForm.value, {
            onSuccess: closeModals,
        })
    } else {
        Inertia.post(route('admin.chapters.store', props.course.id), chapterForm.value, {
            onSuccess: closeModals,
        })
    }
}

// Submit Lesson Form
const submitLessonForm = () => {
    if (isEditingLesson.value) {
        Inertia.put(route('admin.lessons.update', lessonToEdit.value.id), lessonForm.value, {
            onSuccess: closeModals,
        })
    } else {
        Inertia.post(route('admin.lessons.store', activeChapterId.value), lessonForm.value, {
            onSuccess: closeModals,
        })
    }
}

// Delete Chapter
const deleteChapter = (chapterId) => {
    if (confirm('Are you sure you want to delete this chapter?')) {
        Inertia.delete(route('admin.chapters.destroy', chapterId))
    }
}

// Delete Lesson
const deleteLesson = (lessonId) => {
    if (confirm('Are you sure you want to delete this lesson?')) {
        Inertia.delete(route('admin.lessons.destroy', lessonId))
    }
}

// Reset form states
const resetChapterForm = () => {
    chapterForm.value = { title: '', chapter_number: '' }
}

const resetLessonForm = () => {
    lessonForm.value = { title: '', lesson_number: '' }
}

// Close all modals
const closeModals = () => {
    isChapterModalVisible.value = false
    isLessonModalVisible.value = false
    isHighlightModalVisible.value = false

}
</script>

<style>
/* Add subtle transitions for buttons */
button {
    transition: background-color 0.3s ease;
}
</style>
