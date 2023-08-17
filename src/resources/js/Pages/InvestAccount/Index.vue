<script setup>
import {route} from "@/helper/index.js";
import Basic from "@/Layouts/Basic.vue"
import {FormField, FormRow} from "@/Components/Form/index.js";
import {Head, Link, useForm} from "@inertiajs/vue3"

defineProps({
    accountPaginatedList: Object
})

const creatAccountForm = useForm({
    alias: ''
})

const createAccount = () => {
    creatAccountForm.post(route('invest.account.store'), {
        preserveScroll: true,
        onSuccess: () => creatAccountForm.reset(),
    })
}

defineOptions({layout: Basic})
</script>

<template>
    <section class="mb-4">
        {{ accountPaginatedList }}
    </section>
    <section class="w-full max-w-md">
        <h5>新增投資帳號</h5>
        <FormRow :error="creatAccountForm.errors.alias">
            <template #head>
                <div class="px-2 py-1">帳號暱稱</div>
            </template>
            <FormField>
                <input class="flex-grow" type="text" v-model="creatAccountForm.alias" @keydown.enter="createAccount">
            </FormField>
        </FormRow>
        <section class="w-full max-w-lg flex justify-center py-2 px-1.5">
            <button class="button-green" @click="createAccount">送出</button>
        </section>
    </section>
</template>

<style scoped lang="postcss">

</style>
