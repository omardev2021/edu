<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 100"
        :class="[
      'hexagon',
      completed ? 'completed' : 'not-completed',
      isCurrent ? 'current' : ''
    ]"
        @click="handleClick"
        width="20" height="20"
    >
        <polygon
            points="50,1 98,25 98,75 50,99 2,75 2,25"
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
.hexagon {
    cursor: pointer;
    margin: 0 1.5px;
}
.hexagon.not-completed polygon {
    fill: rgba(0, 0, 0, 0.4);
    stroke: none;
}
.hexagon.current polygon {
    fill: transparent !important;
    stroke: white !important;
}
</style>
