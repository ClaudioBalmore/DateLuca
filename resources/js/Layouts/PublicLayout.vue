<script setup>
import SiteHeader from '@/Components/SiteHeader.vue';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-white">
        <SiteHeader />

        <main>
            <slot />
        </main>
    </div>
</template>