<script setup>
import Basic from "@/Layouts/Basic.vue"

defineProps({
    historyPaginatedList: Object
})

defineOptions({layout: Basic})
</script>

<template>
    <div>
        123
    </div>
    <hr>
    {{ historyPaginatedList }}
</template>

<style scoped lang="postcss">

</style>
