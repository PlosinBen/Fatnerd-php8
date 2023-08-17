<script setup>
import {Head, Link} from '@inertiajs/vue3'
import {route} from "@/helper/index.js";
import Basic from "@/Layouts/Basic.vue"
import {FormField} from "@/Components/Form/index.js";

defineOptions({layout: Basic})
</script>

<template>
    <Head title="新增投資帳號"/>
    <section class="w-full max-w-lg flex py-2 px-1.5">
        <section class="flex flex-col justify-center">
            <div class="px-3 py-1">帳號暱稱</div>
        </section>
        <div class="flex-grow">
            <FormField>
                <input class="flex-grow" type="text">
            </FormField>
        </div>
    </section>
    <section class="w-full max-w-lg flex justify-center py-2 px-1.5">
        <div class="space-x-10">
            <button class="button-green" type="submit">送出</button>
            <button class="button-red" type="submit">回上頁</button>
        </div>
    </section>
</template>

<style scoped lang="postcss">

</style>
