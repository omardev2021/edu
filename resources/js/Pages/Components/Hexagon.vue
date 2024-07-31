<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 100"
        :class="[
            'circle',
            completed ? 'completed' : 'not-completed',
            isCurrent ? 'current' : ''
        ]"
        @click="handleClick"
        width="20" height="20"
    >
        <circle
            cx="50"
            cy="50"
            r="48"
            :fill="completed ? (isCurrent ? 'transparent' : 'white') : '#a8a8a8'"
            :stroke="isCurrent ? 'white' : (completed ? 'white' : 'none')"
            stroke-width="7"
        />
    </svg>
</template>

<script>
export default {
    props: {
        completed: Boolean,
        isCurrent: Boolean,
        slideIndex: Number,
        currentSlideIndex: Number
    },
    methods: {
        handleClick() {
            if (this.completed || this.slideIndex <= this.currentSlideIndex) {
                this.$emit('goToSlide', this.slideIndex);
            }
        }
    }
}
</script>

<style scoped>
.circle {
    cursor: pointer;
    margin: 0 1.5px;
}
.circle.not-completed circle {
    fill: rgba(0, 0, 0, 0.4);
    stroke: none;
}
.circle.current circle {
    fill: transparent !important;
    stroke: white !important;
}
</style>
