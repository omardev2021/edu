<template>
    <Feedback />
   <Nav />
    <div class="bg-[#F3F4FF] text-gray-800">
        <main class="py-5 px-4 lg:px-40 font-primary grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- First Section -->
            <!-- First Section -->
            <div class="lg:col-span-2 ">
                <section class="mb-6">

                    <!-- all paths -->
                    <Transition name="fade">
                        <div v-if="!showCourseDataPart" class="p-6 bg-white shadow-md rounded-sm text-gray-600">
                            <div class="flex justify-between mb-4 items-center">
                                <div class="flex gap-3 items-center">
                                    <div>
                                        <img src="../../assets/cer-icon.png" class="w-[55px]">
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-yellow-500">دبولمة ادارة المخزون</h1>
                                        <p class="text-gray-500">{{paths.length + 1}} مسارات •  تم اكمال 0%</p>
                                    </div>

                                </div>
                                <div>
                                    <button @click="toggleParts" class="bg-white text-md font-semibold shadow-lg px-5 py-1 rounded-full border border-gray-200">إغلاق</button>

                                </div>
                            </div>
                            <p class="mt-2">يقدم ماجستير إدارة الأعمال لدينا المعرفة والمهارات التي تحتاجها للنجاح في بيئة الأعمال اليوم. اضغط على أي تركيز لتنشيطه وبدء التعلم.</p>

                            <div class="flex flex-col items-center mb-4">

<!--                                active path-->
                                <Link :href="route('path.show',activePath.id)">
                                <div class="  rounded-md text-center my-4 border border-gray-200 cursor-pointer hover:bg-gray-100 ">
                                    <div class="flex justify-between items-center p-1 ">
                                        <div>
                                            <p class="text-grayDark font-semibold text-sm">فعال</p>

                                        </div>


                                        <div class="text-sm font-bold text-grayDark">{{ progressPercentage.toFixed(0) }}%</div>
                                    </div>
                                    <img src="../../assets/road.png" class="w-[55px]  mx-auto ">


                                    <div class="mt-2  py-4 px-8 text-veryDarkBlue">{{activePath.title}}</div>
                                </div>
                            </Link>

                                <div class="flex items-center w-full my-4">
                                    <hr class="flex-grow border-gray-300">
                                    <p class="mx-4 text-gray-500 whitespace-nowrap">يتم فتح المنهج بالكامل بعد <br> اكمال بياناتك والاشتراك</p>
                                    <hr class="flex-grow border-gray-300">
                                </div>                            </div>
                            <div class="flex flex-wrap justify-center gap-4 text-center">
<!--                                all paths-->

                                <PathItem v-for="path in paths" :key="path.id" :path="path" />

                            </div>

                        </div>
                    </Transition>

                    <!-- Course Data Part -->
                    <Transition name="fade">
                <div>
                    <div v-if="showCourseDataPart" class="bg-white shadow-md rounded-sm text-gray-600">
                        <div class="flex justify-between items-center p-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-600">{{ activePath.title }}</h3>
                                <p class="text-sm">{{ totalCourses }} كورسات • تم اكمال {{ progressPercentage.toFixed(0) }}%</p>
                            </div>
                            <button @click="toggleParts" class="bg-white font-semibold shadow-lg px-4 py-2 rounded-full flex items-center justify-center gap-2 border border-gray-200">
                                منهج الدورة
                                <img src="../../assets/cer-icon.png" class="w-5">
                            </button>
                        </div>
                        <p class="mt-4 p-4">{{ activePath.description }}</p>
                        <hr>
                        <div class="flex justify-between items-center p-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-600">كورس ادارة المخزون</h3>
                                <p class="text-sm">{{ activePath.courses.length }} كورسات . تم اكمال {{ progressPercentage.toFixed() }}%</p>
                            </div>
                            <Link :href="route('course.index')" class="bg-[#4215ba] text-white shadow-lg px-4 py-2 rounded-full">انتقل للدورات</Link>
                        </div>
                    </div>
                    <!-- path's courser -->
                    <div v-if="showCourseDataPart" class="low-opacity shadow-md rounded-sm text-gray-600 px-4">
                        <!-- Item -->
                        <CourseLine v-for="course in activePath.courses" :key="course.id" :course="course" />





                    </div>
                </div>
                    </Transition>


                    <h2 class="text-xl text-grayDark font-bold mb-4 mt-4">المسجلين في الدورة</h2>

                    <div class="bg-white shadow-md rounded-sm text-gray-600 p-6 lg:max-w-sm mt-5">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <img src="../../assets/student.avif" alt="Student 1" class="w-16 h-16 rounded-full">
                                <div>
                                    <h3 class="font-bold">عمر اسامة</h3>
                                    <p class="text-sm">مهندس برمجيات<br>السودان جامعة المستقبل</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <img src="../../assets/student.avif" alt="Student 1" class="w-16 h-16 rounded-full">
                                <div>
                                    <h3 class="font-bold">عمر اسامة</h3>
                                    <p class="text-sm">مهندس برمجيات<br>السودان جامعة المستقبل</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <img src="../../assets/student.avif" alt="Student 1" class="w-16 h-16 rounded-full">
                                <div>
                                    <h3 class="font-bold">عمر اسامة</h3>
                                    <p class="text-sm">مهندس برمجيات<br>السودان جامعة المستقبل</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <img src="../../assets/student.avif" alt="Student 1" class="w-16 h-16 rounded-full">
                                <div>
                                    <h3 class="font-bold">عمر اسامة</h3>
                                    <p class="text-sm">مهندس برمجيات<br>السودان جامعة المستقبل</p>
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
                        <li>تواصل معنا عبر البريد البريد الالكتروني <span class="underline text-blue-500">info@lowkalo.com</span></li>
                        <li>اتصال او واتس اب <span class="underline text-blue-500">055555555</span></li>
                    </ul>
                    <h3 class="font-bold text-grayDark text-center pb-2 mt-4">لتفاصيل اكثر</h3>
                    <ul class="list-disc list-inside text-grayDark">
                        <li>تواصل معنا <span class="underline text-blue-500">ارسل رسالة الان</span></li>
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
                        <button class="bg-white text-xs font-semibold shadow-lg px-10 py-1 rounded-full  border border-gray-200 mb-2">برامج الادارة</button>
                        <br>
                        <button class="bg-white text-xs font-semibold shadow-lg px-8 py-1 rounded-full  border border-gray-200"> برامج المحاسبة</button>

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

        <div class="mb-6 px-4 md:px-[135px] md:mx-6 mt-10">
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

        <div class="mb-6 px-4 md:px-[135px] md:mx-6 mt-20">
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

    paths: Array,
    activePath: Object,
    totalCourses: Number,
    progressPercentage: Number,
    bookmarks: Array,
    completedCourses: Array,

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
