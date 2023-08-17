<script setup>
const props = defineProps({
    error: String
})
</script>

<template>
    <section class="w-full sm:flex py-1.5 px-2.5">
        <section v-if="$slots.head" class="h-10 flex flex-col justify-center">
            <slot name="head"/>
        </section>
        <section class="flex-grow">
            <section class="h-10 flex flex-col justify-center">
                <slot/>
            </section>
            <div v-if="error" class="min-h-fit px-1 text-red-700 text-sm" v-text="error ?? '&nbsp;'"></div>
        </section>
    </section>
</template>

<style scoped lang="postcss">

</style>
