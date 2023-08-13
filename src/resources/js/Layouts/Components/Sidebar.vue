<script setup>
import route from "../../../../vendor/tightenco/ziggy/src/js/index.js";
</script>

<template>
    <aside>
        <nav>
            <h5>123</h5>
            <ul>
                <li>{{ route("index") }}</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
            </ul>
            <h5>123</h5>
            <ul>
                <li>BBBBBBB</li>
                <li class="active">AAAAAAA</li>
                <li>CCCCCC</li>
                <li>DDDDD</li>
            </ul>
        </nav>
    </aside>
</template>

<style scoped lang="postcss">
aside {
    @apply mx-3 my-1 text-sm;

    nav {
        h5 {
            @apply mt-3 mb-1 text-slate-200 font-semibold;
        }

        li {
            @apply py-1 pl-4 border-l border-gray-700;

            &.active {
                @apply font-medium text-sky-400 border-sky-400;
            }
        }
    }
}
</style>
