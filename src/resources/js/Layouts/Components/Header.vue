<script setup>

</script>

<template>
    <header>
        <section>
            <div>
                123
            </div>
        </section>
        <section>
            <button type="button">
                <slot></slot>
            </button>
        </section>
    </header>
</template>

<style scoped lang="postcss">
header {
    @apply p-2 flex justify-between border-b border-slate-700;
    section {
        @apply flex flex-col justify-center;
    }

    button {
        @apply p-2;
    }
}
</style>
