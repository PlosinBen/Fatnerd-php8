<script setup>
import {route} from "@/helper/index.js";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <aside>
        <nav>
            <h5>投資</h5>
            <ul>
                <li>{{ route("index") }}</li>
                <li>
                    帳務明細
                </li>
                <li>月對帳單</li>
                <li>4</li>
            </ul>

            <h5>對帳單</h5>
            <ul>
                <li>
                    <Link :href="route('invest.account.index')">投資帳號</Link>
                </li>
                <li>
                    分配明細
                </li>
                <li>
                    <Link :href="route('invest.futures.index')">期貨對帳單</Link>
                </li>
            </ul>

            <h5>記帳</h5>
            <ul>
                <li>帳本</li>
                <li class="active">消費統計</li>
                <li>CCCCCC</li>
                <li>DDDDD</li>
            </ul>
        </nav>
    </aside>
</template>

<style scoped lang="postcss">
aside {
    @apply px-4 py-2 text-sm;

    nav {
        h5 {
            @apply mt-3 mb-1 text-slate-200 font-semibold;
        }

        li {
            @apply py-1 pl-4 border-l border-gray-700;
        }
    }

    a {
        @apply inline-block w-full;

        &:hover {
            @apply text-gray-300 border-gray-300;
        }
    }
}
</style>
