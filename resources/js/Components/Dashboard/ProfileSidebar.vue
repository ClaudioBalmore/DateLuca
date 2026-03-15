<script setup>
defineProps({
    user: {
        type: Object,
        required: true,
    },
});

defineEmits(['open-links']);

const handleImageError = (event) => {
    const img = event.target;

    if (!img || img.src?.endsWith('/logo.png')) {
        return;
    }

    img.src = '/logo.png';
};
</script>

<template>
    <div class="overflow-hidden rounded-3xl border border-green-100 bg-white shadow-sm lg:sticky lg:top-8">
        <div class="h-14 bg-gradient-to-r from-green-100 via-primary-50 to-green-100 sm:h-16" />

        <div class="-mt-8 px-5 pb-5 sm:-mt-10 sm:px-6 sm:pb-6">
            <div class="flex flex-col items-center text-center">
                <div class="relative z-10 mx-auto flex h-28 w-28 items-center justify-center rounded-full bg-white p-1.5 shadow-sm ring-4 ring-white sm:h-32 sm:w-32">
                    <img
                        :src="user.profile_image || '/logo.png'"
                        @error="handleImageError"
                        alt="Foto de perfil"
                        class="h-full w-full rounded-full bg-white object-cover"
                    />
                </div>

                <div class="mt-3 w-full">
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 break-words sm:text-3xl">
                        {{ user.name }}
                    </h1>
                    <p class="text-xs font-semibold text-primary-700 sm:text-sm">
                        @{{ user.slug }}
                    </p>
                </div>
            </div>

            <p class="mt-5 line-clamp-3 text-sm leading-relaxed text-gray-700">
                {{ user.bio || "Date una Luca po'" }}
            </p>

            <button
                type="button"
                class="mt-5 w-full rounded-xl border border-primary-200 bg-primary-50 px-4 py-2.5 text-sm font-semibold text-primary-700 shadow-sm transition hover:bg-primary-100"
                @click="$emit('open-links')"
            >
                Ver links
            </button>
        </div>
    </div>
</template>
