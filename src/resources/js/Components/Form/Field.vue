<script setup>
const props = defineProps({
    error: String
})
</script>

<template>
    <div class="py-1.5 px-2.5 border border-slate-600 rounded space-x-2 flex items-center">
        <slot/>
    </div>
    <div v-if="error" class="min-h-fit px-1 text-red-700 text-sm" v-text="error ?? '&nbsp;'"></div>
</template>

<style scoped lang="postcss">

</style>
