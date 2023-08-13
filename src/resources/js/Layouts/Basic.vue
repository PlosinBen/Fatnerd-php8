<script setup>
import Footer from "@/Layouts/Components/Footer.vue";
import Header from "@/Layouts/Components/Header.vue";
import Sidebar from "@/Layouts/Components/Sidebar.vue";
</script>

<template>
    <section class="layout">
        <Header/>
        <section class="flex-grow">
            <Sidebar class="w-56"/>
            <section class="flex-grow flex flex-col">
                <main class="flex-grow">
                    <slot/>
                </main>
                <Footer/>
            </section>
        </section>
    </section>
</template>

<style scoped lang="postcss">
.layout {
    @apply flex flex-col h-screen;

    section {
        @apply flex;
    }
}
</style>
