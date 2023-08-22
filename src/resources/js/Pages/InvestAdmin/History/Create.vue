<script setup>
import Basic from "@/Layouts/Basic.vue"
import {Link, useForm} from "@inertiajs/vue3"
import {route} from "@/helper/index.js"
import {FormRow, FormField, FormFooter} from "@/Components/Form"
import moment from "moment"

const props = defineProps({
    investAccounts: Array,
    typeOptions: Object
})

const form = useForm({
    invest_account: props.investAccounts[0].id,
    deal_at: moment().format("YYYY-MM-DD"),
    type: Object.keys(props.typeOptions)[0],
    amount: undefined,
    note: '',
})

defineOptions({layout: Basic})
</script>

<template>
    <section class="max-w-sm">
        <FormRow :error="form.errors.invest_account">
            <template #head>
                <div class="w-28 px-2 sm:px-2 sm:text-center">交易日</div>
            </template>
            <FormField>
                <select v-model="form.invest_account">
                    <option v-for="investAccount in investAccounts" :value="investAccount.id" v-text="investAccount.alias"></option>
                </select>
            </FormField>
        </FormRow>
        <FormRow :error="form.errors.deal_at">
            <template #head>
                <div class="w-28 px-2 sm:px-2 sm:text-center">交易日</div>
            </template>
            <FormField>
                <input class="flex-grow" type="text" v-model="form.deal_at">
            </FormField>
        </FormRow>
        <FormRow :error="form.errors.type">
            <template #head>
                <div class="w-28 px-2 sm:px-2 sm:text-center">交易類型</div>
            </template>
            <FormField>
                <select v-model="form.type">
                    <option v-for="(k, v) in typeOptions" :value="v" v-text="k"></option>
                </select>
            </FormField>
        </FormRow>
        <FormRow :error="form.errors.amount">
            <template #head>
                <div class="w-28 px-2 sm:px-2 sm:text-center">金額</div>
            </template>
            <FormField>
                <input class="flex-grow" type="number" v-model="form.amount">
            </FormField>
        </FormRow>
        <FormRow :error="form.errors.note">
            <template #head>
                <div class="w-28 px-2 sm:px-2 sm:text-center">備註</div>
            </template>
            <FormField>
                <input class="flex-grow" type="text" v-model="form.note">
            </FormField>
        </FormRow>
        <FormFooter>
            <button class="button-green" @click="form.post(route('invest_admin.history.store'))">送出</button>
            <Link class="button-red" :href="route('invest_admin.history.index')">取消</Link>
        </FormFooter>
    </section>
</template>

<style scoped lang="postcss">

</style>
