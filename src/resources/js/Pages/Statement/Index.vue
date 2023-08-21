<script setup>
import Basic from "@/Layouts/Basic.vue"
import {Link} from "@inertiajs/vue3";

defineProps({
    statementPaginatedList: Object
})

defineOptions({layout: Basic})
</script>

<template>
    <template v-for="statement in statementPaginatedList.data">
        <div>
            {{ statement }}
        </div>
    </template>
</template>

<style scoped lang="postcss">

</style>
