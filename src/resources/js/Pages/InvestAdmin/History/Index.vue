<script setup>
import Basic from "@/Layouts/Basic.vue"
import {Link} from "@inertiajs/vue3"
import {route} from "@/helper/index.js";

defineProps({
    historyPaginatedList: Object
})

defineOptions({layout: Basic})
</script>

<template>
    <div>
        123
    </div>
    <div>
        <Link class="button-green" :href="route('invest_admin.history.create')">新增紀錄</Link>
    </div>
    <hr>
    {{ historyPaginatedList }}
</template>

<style scoped lang="postcss">

</style>
