<template>
    <Head title="كورس ادارة المخزون" />
    <Feedback />
   <Nav />
    <div class="bg-[#F3F4FF] text-gray-800">
        <main class="py-5 px-4 lg:px-40 font-primary grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- First Section -->
            <!-- First Section -->
            <div class="lg:col-span-2 ">
                <section class="mb-6">



                    <!-- Course Data Part -->
                    <Transition name="fade">
                <div>
                    <div  class="bg-white shadow-md rounded-sm text-gray-600">


                        <div class="flex justify-between mb-4 items-center pt-4 px-4">
                            <div class="flex gap-3 items-center">
                                <div>
                                    <img src="../../assets/cer-icon.png" class="w-[55px]">
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-yellow-500">{{ settings.program_name }}</h1>
                                    <p class="text-gray-500">{{totalCourses}} كورسات •  تم اكمال {{ progressPercentage.toFixed(0) }}%</p>
                                </div>

                            </div>

                        </div>
                        <p class="mt-4 p-4">{{ settings.program_description }}</p>
                        <hr>
                        <div class="flex justify-between items-center p-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-600">{{ settings.program_name }}</h3>
                                <p class="text-sm">{{ totalCourses }} كورسات . تم اكمال {{ progressPercentage.toFixed() }}%</p>
                            </div>
                            <Link :href="route('course.index')" class="bg-[#4215ba] text-white shadow-lg px-4 py-2 rounded-full">انتقل للدورات</Link>
                        </div>
                    </div>
                    <!-- path's courser -->
                    <div v-if="showCourseDataPart" class="low-opacity shadow-md rounded-sm text-gray-600 px-4">
                        <!-- Item -->
                        <CourseLine v-for="course in courses" :key="course.id" :course="course" />





                    </div>
                </div>
                    </Transition>


                    <h2 class="text-xl text-grayDark font-bold mb-4 mt-4">المسجلين في الدورة</h2>

                    <div class="bg-white shadow-md rounded-sm text-gray-600 p-6 lg:max-w-sm mt-5">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <img src="/images/m-profile.jpg" alt="Student 1" class="w-16 h-16 rounded-full">
                                <div>
                                    <h3 class="font-bold">محمد الشريف</h3>
                                    <p class="text-sm">المدير التنفيذي لسلسلة مطاعم</p>
                                </div>
                            </div>

                            <div class="text-center">
                                <button class="bg-white text-sm font-semibold shadow-lg px-4 py-1 rounded-full  border border-gray-200">
                                    انضم الينا الان
                                </button>
                            </div>

                        </div>
                    </div>

                </section>
            </div>
            <!-- Second Section -->
            <div class="lg:row-span-2 flex flex-col space-y-6 lg:col-span-1">
                <div class="p-6 bg-gradient-to-r from-[#4215ba] to-blue-700 text-white rounded-sm  shadow-md">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold mb-4">سجل الان في لوكالو</h2>
                        <img src="../../assets/cer-icon.png" class="w-[50px]">
                    </div>
                    <p class="mb-6">الموعد النهائي لدورة القبول القادمة يقترب.</p>
                    <div class="text-center">
                        <Link href="/apply" class="inline-block px-6 py-2 border border-white text-white font-semibold rounded-full shadow-md bg-transparent hover:bg-white hover:text-blue-700 transition-colors duration-300">اكمل طلبك الان</Link>
                    </div>
                </div>
                <div class="bg-[rgba(255,255,255,0.5)]  py-4 px-4 rounded-md">
                    <div class="divider-container">
                        <h3 class="font-bold text-grayDark text-center pb-2 text-lg">معلومات عن القبول</h3>
                        <div class="divider">
                            <div class="diamond"></div>
                        </div>
                    </div>
                    <h3 class="font-bold text-grayDark text-center pb-2">للاجوبة السريعة</h3>
                    <ul class="list-disc list-inside text-grayDark">
                        <li>تواصل معنا عبر البريد البريد الالكتروني <span class="underline text-blue-500">{{ settings.email }}</span></li>
                        <li>اتصال او واتس اب <span class="underline text-blue-500">{{ settings.phone }}</span></li>
                    </ul>
                    <h3 class="font-bold text-grayDark text-center pb-2 mt-4">لتفاصيل اكثر</h3>
                    <ul class="list-disc list-inside text-grayDark">
                        <li>تواصل معنا <Link :href="route('contact.index')" class="underline text-blue-500">ارسل رسالة الان</Link></li>
                    </ul>
                </div>
                <!-- Repeated Sections -->
                <div class="bg-[rgba(255,255,255,0.5)]  py-4 px-4 rounded-md">
                    <div class="divider-container">
                        <h3 class="font-bold text-grayDark text-center pb-2 text-lg">برامج الدرجات العلمية لدينا</h3>
                        <div class="divider">
                            <div class="diamond"></div>
                        </div>
                    </div>
                    <p class=" text-grayDark pb-2">تعرف على المزيد حول برامج الشهادات المبتكرة التي تقدمها لوكالو والتي تعطل التعليم العالي التقليدي.</p>

                    <div class="text-center mt-3">
                        <button class="bg-white text-xs font-semibold shadow-lg px-8 py-1 rounded-full  border border-gray-200 mb-2">برنامج ادارة المطاعم - قريبا
                            </button>
                        <br>
                        <button class="bg-white text-xs font-semibold shadow-lg px-8 py-1 rounded-full  border border-gray-200"> برنامج سلامة الغذاء - قريبا</button>

                    </div>
                </div>
                <!-- Repeated Sections -->
                <div class="bg-[rgba(255,255,255,0.5)]  py-4 px-4 rounded-md">
                    <div class="divider-container">
                        <h3 class="font-bold text-grayDark text-center pb-2 text-lg">نموذج الرسوم الدراسية لدينا</h3>
                        <div class="divider">
                            <div class="diamond"></div>
                        </div>
                    </div>
                    <p class=" text-grayDark pb-2">نحن انتقائيون، ولكن بأسعار معقولة إذا تم قبولنا. تعرف على كيفية توسيع نطاق الوصول إلى أعلى مستوى من التعليم من خلال نموذج تعليمي مبتكر.</p>

                    <div class="text-center mt-3">
                        <button class="bg-white text-xs font-semibold shadow-lg px-10 py-1 rounded-full  border border-gray-200 mb-2">اعرف المزيد</button>

                    </div>
                </div>


            </div>

        </main>

        <div class="mb-6 px-4 md:px-[135px] md:mx-6 mt-10" v-if="bookmarks.length > 0">
            <div class="divider-container">
                <div class="divider">
                    <div class="diamond"></div>
                </div>
                <div class="divider-text font-primary">الكورسات المفضلة</div>
            </div>
        </div>


            <div class="flex justify-center flex-wrap gap-4 font-primary">
                <CourseCard
                    v-for="course in bookmarks"
                    :key="course.id"
                    :course="course"
                />
            </div>

        <div class="mb-6 px-4 md:px-[135px] md:mx-6 mt-20" v-if="completedCourses.length > 0">
            <div class="divider-container">
                <div class="divider">
                    <div class="diamond"></div>
                </div>
                <div class="divider-text font-primary">الكورسات المكتملة</div>
            </div>
        </div>


        <div class="flex justify-center flex-wrap gap-4 font-primary">
            <CourseCard
                v-for="course in completedCourses"
                :key="course.id"
                :course="course"
            />
        </div>

        <Footer class="mt-20"/>

    </div>
</template>


<script>
export default {
    layout: null, // Explicitly set the layout to null
};
</script>

<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import { ref } from 'vue';
import locked from '../../assets/locked.png'
import CourseLine from "@/Pages/Components/CourseLine.vue";
import PathItem from "@/Pages/Components/PathItem.vue";
import Feedback from "@/Pages/Components/Feedback.vue";
import Nav from "@/Pages/Components/Nav.vue";
import Footer from "@/Pages/Components/Footer.vue";
import CourseCard from "@/Pages/Components/CourseCard.vue";
const props = defineProps({

    courses: Array,
    totalCourses: Number,
    progressPercentage: Number,
    bookmarks: Array,
    completedCourses: Array,
    settings:Array


});

const showCourseDataPart = ref(true);

const toggleParts = () => {
    showCourseDataPart.value = !showCourseDataPart.value;
};


</script>

<style scoped>

*{
    direction: rtl;
}

.divider-container {
    position: relative;
    width: 100%;
    text-align: center;
    /*margin-top: 20px;*/
    margin-bottom: 20px;
}

.divider {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    position: relative;
}

.divider::before, .divider::after {
    content: '';
    flex-grow: 1;
    height: 2px;
    background-color: #999999; /* Medium gray color for good contrast */
}

.diamond {
    width: 15px;
    height: 15px;
    border: 2px solid #999999; /* Medium gray border for good contrast */
    background-color: #F3F4FF; /* Same as the container background color */
    position: relative;

    transform: rotate(45deg);
}
.divider-text {
    position: absolute;
    top: -40px;
    left: 50%;
    transform: translateX(-50%);
    padding: 0 10px;
    font-size: 22px; /* Adjust font size as needed */
    font-weight: bold;
    color: #999999; /* Slightly darker gray for the text */
    text-transform: uppercase;
}
.fade-enter-active {
    transition: opacity 0.5s;
}
.fade-enter-from {
    opacity: 0;
}
</style>
