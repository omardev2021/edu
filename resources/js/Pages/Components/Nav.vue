<template>

    <header class="bg-[#4215ba] text-white py-4 font-primary" dir="rtl">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <img src="../../assets/lowkalo-ww.png" class="justify-center" width="130">
            <nav class="hidden md:flex space-x-4">
                <ul class="flex space-x-4">
                    <li>
                        <Link
                            :href="route('home')"
                            class="nav-link text-lg ml-3"
                            :class="{ 'bg-[rgba(256,255,255,0.2)] text-white font-bold': $page.url === '/about', 'hover:bg-[rgba(256,255,255,0.2)]': $page.url !== '/about' }"
                        >الرئيسية</Link>
                    </li>
                    <li>
                        <Link
                            :href="route('path.index')"
                            class="nav-link text-lg "
                            :class="{ 'bg-[rgba(256,255,255,0.2)] text-white font-bold': route().current('path.show') || route().current('path.index'), 'hover:bg-[rgba(256,255,255,0.2)]': !route().current('home') }"
                        >الكورس</Link>
                    </li>
                    <li>
                        <Link
                            href="/courses"
                            class="nav-link text-lg"
                            :class="{ 'bg-[rgba(256,255,255,0.2)] text-white font-bold': route().current('course.index'), 'hover:bg-[rgba(256,255,255,0.2)]': !route().current('home') }"
                        >المواضيع</Link>
                    </li>
                    <li>
                        <Link
                            :href="route('contact.index')"
                            class="nav-link text-lg"
                            :class="{ 'bg-[rgba(256,255,255,0.2)] text-white font-bold': $page.url === '/contact-us', 'hover:bg-[rgba(256,255,255,0.2)]': $page.url !== '/contact-us' }"
                        >تواصل معنا</Link>
                    </li>

                    <li>
                        <Link
                            :href="route('checkout')"
                            class="nav-link text-lg"
                            :class="{ 'bg-[rgba(256,255,255,0.2)] text-white font-bold': route().current('checkout'), 'hover:bg-[rgba(256,255,255,0.2)]': !route().current('home') }"
                        >سجل الان</Link>
                    </li>
                </ul>
            </nav>

            <!-- Settings Dropdown -->
            <div class="ms-3 relative">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition items-center gap-2">
                            <span>{{ $page.props.auth.user.name }}</span>
                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                        </button>

                        <span v-else class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                {{ $page.props.auth.user.name }}
                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">حساب المستخدم</div>
                        <DropdownLink :href="route('profile.show')">حسابي & الاعدادات</DropdownLink>
                        <DropdownLink v-if="$page.props.auth.user.is_admin " :href="route('admin.index')">لوحة الإدارة</DropdownLink>

                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">API Tokens</DropdownLink>
                        <div class="border-t border-gray-200" />
                        <!-- Authentication -->
                        <form @submit.prevent="logout">
                            <DropdownLink as="button">تسجيل الخروج</DropdownLink>
                        </form>
                    </template>
                </Dropdown>
            </div>
        </div>
    </header>

    <!-- Bottom Navigation for Mobile -->
    <nav class="fixed bottom-0 left-0 right-0 bg-softBlue shadow-lg z-50 md:hidden font-primary ">
        <div class="container mx-auto px-4">
            <ul class="flex justify-around items-center py-2 ">
                <li>
                    <Link :href="route('home')" class="mobile-nav-link" :class="{ active: $page.url === '/resources' }">
                        <i class="fas fa-home text-xl "></i>
                        <span class="text-sm ">الرئيسية</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('path.index')" class="mobile-nav-link" :class="{ active: route().current('path.show') || route().current('path.index') }">
                        <i class="fas fa-pen text-xl "></i>
                        <span class="text-sm ">الكورس</span>
                    </Link>
                </li>
                <li>
                    <Link href="/courses" class="mobile-nav-link" :class="{ active: $page.url === '/courses' }">
                        <i class="fas fa-book text-xl "></i>
                        <span class="text-sm ">المواضيع</span>
                    </Link>
                </li>
                <li>
                    <Link href="/contact-us" class="mobile-nav-link " :class="{ active: $page.url === '/contact-us' }">
                        <i class="fas fa-contact-book text-xl "></i>
                        <span class="text-sm ">تواصل معنا</span>
                    </Link>
                </li>

                <li>
                    <Link href="/apply" class="mobile-nav-link" :class="{ active: $page.url === '/apply' }">
                        <i class="fas fa-file-alt text-xl "></i>
                        <span class="text-sm ">سجل الان</span>
                    </Link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { router } from '@inertiajs/vue3';

const logout = () => {
    router.post(route('logout'));
};
</script>

<style>
.nav-link {
    @apply px-3 py-1 rounded-full transition duration-300;
}
.mobile-nav-link {
    @apply flex flex-col items-center text-white hover:text-softRed transition;
}
.mobile-nav-link.active {
    @apply text-softRed;
}
</style>
