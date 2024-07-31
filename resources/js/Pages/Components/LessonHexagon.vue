<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 100"
        :class="[
            'circle',
            completed ? 'completed' : 'not-completed'
        ]"
        width="20"
        height="20"
    >
        <circle
            cx="50"
            cy="50"
            r="48"
            :fill="completed ? 'white' : 'transparent'"
            :stroke="completed ? 'none' : 'white'"
            stroke-width="7"
        />
    </svg>
</template>

<script>
export default {
    props: {
        completed: Boolean
    }
}
</script>

<style scoped>
.circle {
    margin: 0 1.5px;
}
.circle.not-completed circle {
    fill: transparent;
    stroke: white;
}
.circle.completed circle {
    fill: white;
    stroke: none;
}
</style>
