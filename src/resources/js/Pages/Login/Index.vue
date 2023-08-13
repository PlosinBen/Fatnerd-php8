<script setup>
import {useForm} from '@inertiajs/vue3'
import Unauthenticate from "@/Layouts/Unauthenticate.vue";
import {FormField} from "@/Components/Form";

const form = useForm({
    account: null,
    password: null,
})

function submit() {
    form.post('/login')
}
</script>

<template>
    <Unauthenticate>
        <form class="form w-80 max-w-full pb-10" @submit.prevent="submit">
            <div class="h1">
                <h1 class="text-center">使用者登入</h1>
            </div>
            <section class="row">
                <FormField :error="form.errors.account">
                    <font-awesome-icon icon="user"/>
                    <input type="text" v-model="form.account">
                </FormField>
            </section>
            <section class="row">
                <FormField :error="form.errors.password">
                    <font-awesome-icon icon="lock"/>
                    <input type="password" v-model="form.password">
                </FormField>
            </section>
            <section class="row">
                <input type="submit" class="button-lime w-full" value="登入">
            </section>
        </form>
    </Unauthenticate>
</template>

<style scoped lang="postcss">

</style>
