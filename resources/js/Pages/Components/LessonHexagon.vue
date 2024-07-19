<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 100"
        :class="[
            'hexagon',
            completed ? 'completed' : 'not-completed'
        ]"
        width="20"
        height="20"
    >
        <polygon
            points="50,1 98,25 98,75 50,99 2,75 2,25"
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
.hexagon {
    margin: 0 1.5px;
}
.hexagon.not-completed polygon {
    fill: transparent;
    stroke: white;
}
.hexagon.completed polygon {
    fill: white;
    stroke: none;
}
</style>
