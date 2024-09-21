<template>
    <!-- Admin Sidebar -->
    <aside class="w-64 bg-mainColor text-grayDark border border-l-1 border-gray-200 font-primary">
        <div class="py-6">
            <h1 class="text-2xl font-bold text-center text-darkBlue">لوحة التحكم</h1>
            <nav class="mt-10 space-y-2">
                <Link
                    :href="route('admin.index')"
                    :class="{
    'flex items-center py-3 px-6 rounded-lg text-veryDarkBlue transition hover:bg-lightBlue': true,
    'bg-lightBlue text-white': route().current('admin.index') // Apply active style
  }"
                >
                    <i class="fas fa-chart-pie ml-3"></i> لوحة التحكم
                </Link>

                <Link :href="route('admin.courses.index')"
                      :class="{
    'flex items-center py-3 px-6 rounded-lg text-veryDarkBlue transition hover:bg-lightBlue': true,
    'bg-lightBlue text-white': route().current('admin.courses.index') // Apply active style
  }"
                >
                    <i class="fas fa-book ml-3"></i> الكورسات
                </Link>
                    <Link :href="route('admin.topics')"
                          :class="{
    'flex items-center py-3 px-6 rounded-lg text-veryDarkBlue transition hover:bg-lightBlue': true,
    'bg-lightBlue text-white': route().current('admin.topics') // Apply active style
  }"
                    >
                    <i class="fas fa-list ml-3"></i> المواضيع
                </Link>
                <Link :href="route('settings.edit')"
                      :class="{
    'flex items-center py-3 px-6 rounded-lg text-veryDarkBlue transition hover:bg-lightBlue': true,
    'bg-lightBlue text-white': route().current('settings.edit') // Apply active style
  }"
                >
                    <i class="fas fa-home-alt ml-3"></i> اعدادات الصفحة الرئيسية
                </Link>

                        <Link :href="route('admin.contacts')"
                              :class="{
    'flex items-center py-3 px-6 rounded-lg text-veryDarkBlue transition hover:bg-lightBlue': true,
    'bg-lightBlue text-white': route().current('admin.contacts') // Apply active style
  }"
                        >
                    <i class="fas fa-users ml-3"></i> طلبات التواصل
                </Link>


                <Link :href="route('admin.users.index')"
                      :class="{
    'flex items-center py-3 px-6 rounded-lg text-veryDarkBlue transition hover:bg-lightBlue': true,
    'bg-lightBlue text-white': route().current('admin.users.index') // Apply active style
  }"
                >
                    <i class="fas fa-users ml-3"></i> المستخدمين
                </Link>
            </nav>
        </div>
    </aside>


</template>

<style>
/* Subtle transitions and shadows */
a, button {
    transition: background-color 0.3s ease, color 0.3s ease;
}
</style>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
</script>
