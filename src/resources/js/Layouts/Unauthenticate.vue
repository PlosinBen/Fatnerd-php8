<script setup>
import Header from "@/Layouts/Components/Header.vue";
</script>

<template>
    <section class="ground">
        <Header/>
        <section class="flex-grow flex flex-col justify-center">
            <section class="flex justify-center">
                <slot/>
            </section>
        </section>
    </section>
</template>

<style scoped lang="postcss">
.ground {
    @apply h-screen flex flex-col;
}
</style>
