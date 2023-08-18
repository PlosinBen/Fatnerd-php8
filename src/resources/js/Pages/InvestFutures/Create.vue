<script setup>
import Basic from "@/Layouts/Basic.vue"
import {route} from "@/helper/index.js"
import {FormRow, FormField} from "@/Components/Form"
import {Head, Link, useForm} from "@inertiajs/vue3"

const createFuturesRequest = useForm({
    group: '',
    period: '',
    commitment: '',
    write_off_profit: '',
    open_profit: '',
    deposit: '',
    withdraw: ''
})

defineOptions({layout: Basic})
</script>

<template>
    <div class="max-w-sm">
        <FormRow :error="createFuturesRequest.errors.group">
            <template #head>
                <div class="w-28 px-2 sm:px-2 sm:text-center">帳號</div>
            </template>
            <FormField>
                <input class="flex-grow" type="text" v-model="createFuturesRequest.group">
            </FormField>
        </FormRow>
        <FormRow :error="createFuturesRequest.errors.period">
            <template #head>
                <div class="w-28 px-2 sm:px-2 sm:text-center">期別</div>
            </template>
            <FormField>
                <input class="flex-grow" type="text" v-model="createFuturesRequest.period">
            </FormField>
        </FormRow>
        <FormRow :error="createFuturesRequest.errors.commitment">
            <template #head>
                <div class="w-28 px-2 sm:text-center">期末權益</div>
            </template>
            <FormField>
                <input class="flex-grow" type="number" v-model="createFuturesRequest.commitment">
            </FormField>
        </FormRow>
        <FormRow :error="createFuturesRequest.errors.write_off_profit">
            <template #head>
                <div class="w-28 px-2 sm:text-center">沖銷損益</div>
            </template>
            <FormField>
                <input class="flex-grow" type="number" v-model="createFuturesRequest.write_off_profit">
            </FormField>
        </FormRow>
        <FormRow :error="createFuturesRequest.errors.open_profit">
            <template #head>
                <div class="w-28 px-2 sm:text-center">未平倉損益</div>
            </template>
            <FormField>
                <input class="flex-grow" type="number" v-model="createFuturesRequest.open_profit">
            </FormField>
        </FormRow>
        <FormRow :error="createFuturesRequest.errors.deposit">
            <template #head>
                <div class="w-28 px-2 sm:text-center">入金</div>
            </template>
            <FormField>
                <input class="flex-grow" type="number" v-model="createFuturesRequest.deposit">
            </FormField>
        </FormRow>
        <FormRow :error="createFuturesRequest.errors.withdraw">
            <template #head>
                <div class="w-28 px-2 sm:text-center">出金</div>
            </template>
            <FormField>
                <input class="flex-grow" type="number" v-model="createFuturesRequest.withdraw">
            </FormField>
        </FormRow>


        <section class="w-full max-w-lg flex justify-center py-2 px-1.5 space-x-5">
            <button class="button-green" @click="createFuturesRequest.post(route('invest.futures.store'))">送出</button>
            <Link class="button-red" :href="route('invest.futures.index')">取消</Link>
        </section>
    </div>
</template>

<style scoped lang="postcss">

</style>
