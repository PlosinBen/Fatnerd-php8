<script setup>
import Footer from "@/Layouts/Components/Footer.vue";
import Header from "@/Layouts/Components/Header.vue";
import Sidebar from "@/Layouts/Components/Sidebar.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {ref} from "vue";

let displaySidebar = ref(false)

</script>

<template>
    <section class="layout">
        <Header>
            <FontAwesomeIcon icon="bars" @click="displaySidebar=!displaySidebar"/>
        </Header>
        <section class="flex-grow">
            <section
                class="absolute md:static flex right-0 top-0 h-screen md:h-auto w-screen md:w-auto" :class="{'': displaySidebar, 'collapse md:visible': !displaySidebar}">
                <Sidebar class="w-80 md:w-72 max-w-full bg-slate-900"/>
                <div class="bg-gray-100 flex-grow opacity-90 md:hidden"></div>
            </section>
            <section class="flex-grow flex flex-col">
                <main class="flex-grow bg-slate-800">
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
