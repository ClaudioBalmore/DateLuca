<script setup>
defineProps({
    user: {
        type: Object,
        required: true,
    },
});

defineEmits(['open-links']);
</script>

<template>
    <div class="space-y-5 rounded-2xl border border-green-100 bg-white p-6 shadow-sm lg:sticky lg:top-8">
        <div class="flex items-center gap-4">
            <img
                :src="user.profile_image || '/logo.png'"
                alt="Foto de perfil"
                class="h-20 w-20 rounded-full object-cover ring-2 ring-green-100"
            />
            <div class="min-w-0">
                <h1 class="truncate text-2xl font-bold text-gray-900">
                    {{ user.name }}
                </h1>
                <p class="text-sm font-medium text-primary-700">
                    @{{ user.slug }}
                </p>
            </div>
        </div>

        <p class="text-sm leading-relaxed text-gray-700">
            {{ user.bio || "Date una Luca po'" }}
        </p>

        <button
            type="button"
            class="w-full rounded-lg border border-primary-200 bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-700 transition hover:bg-primary-100"
            @click="$emit('open-links')"
        >
            Ver links
        </button>
    </div>
</template>
