<template>
    <Link :href="path.is_accessible ? route('path.show',path.id) : '#'" :class="path.is_accessible ? '' : 'cursor-not-allowed'">
    <div class=" p-4  w-48">
        <img  :src="pathImage"  class="w-12 mx-auto mb-2">
        <h2 class="font-bold text-sm text-veryDarkBlue">{{path.title}}</h2>
    </div>
    </Link>
</template>


<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';



const props = defineProps(['path']);


const pathImage = computed(() => {
    if (props.path.completed) {
        return '/images/road-y.png';
    } else if (props.path.is_accessible) {
        return '/images/road.png';
    } else {
        return '/images/locked.png';
    }
});

</script>
