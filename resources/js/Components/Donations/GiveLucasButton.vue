<script setup>
defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['click']);
</script>

<template>
    <button
        type="button"
        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 sm:w-auto disabled:cursor-not-allowed disabled:opacity-60"
        :disabled="disabled"
        @click="emit('click')"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.9"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="h-5 w-5"
        >
            <rect x="3" y="7" width="18" height="12" rx="2.4" />
            <circle cx="12" cy="13" r="2.3" />
            <path d="M12 11.8v2.4" />
            <path d="M10.8 13h2.4" />
            <path d="M6.3 10.1h.01" />
            <path d="M17.7 15.9h.01" />
        </svg>
        Dar Lucas
    </button>
</template>
