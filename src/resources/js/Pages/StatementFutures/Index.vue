<script setup>
import Basic from "@/Layouts/Basic.vue"
import {Link} from "@inertiajs/vue3"
import {route} from "../../helper/index.js";

defineProps({
    futuresPaginatedList: Object
})

defineOptions({layout: Basic})
</script>

<template>
    {{ futuresPaginatedList }}
    <div>
        <Link class="button-green" :href="route('statement.futures.create')">新增對帳單</Link>
    </div>
</template>

<style scoped lang="postcss">

</style>
