<script setup>
import Modal from '@/Components/Modal.vue';

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    user: {
        type: Object,
        required: true,
    },
    links: {
        type: Array,
        default: () => [],
    },
    isOwner: {
        type: Boolean,
        default: false,
    },
    editingLinkId: {
        type: Number,
        default: null,
    },
    newLinkForm: {
        type: Object,
        required: true,
    },
    editLinkForm: {
        type: Object,
        required: true,
    },
    deleteLinkForm: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits([
    'close',
    'create-link',
    'start-edit-link',
    'cancel-edit-link',
    'update-link',
    'remove-link',
]);
</script>

<template>
    <Modal :show="show" max-width="2xl" :center-desktop="true" @close="emit('close')">
        <div class="max-h-[85vh] overflow-y-auto p-6">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">
                    Links de @{{ user.slug }}
                </h3>
                <button
                    type="button"
                    class="rounded-md p-1 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                    @click="emit('close')"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div v-if="isOwner" class="mb-5 rounded-xl border border-green-100 bg-green-50/40 p-4">
                <h4 class="text-sm font-semibold text-gray-900">
                    Gestiona tus links aqui
                </h4>
                <form class="mt-3 space-y-3" @submit.prevent="emit('create-link')">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                                Titulo
                            </label>
                            <input
                                v-model="newLinkForm.title"
                                type="text"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-200"
                                placeholder="Instagram, Twitch, YouTube..."
                            >
                            <p v-if="newLinkForm.errors.title" class="mt-1 text-xs text-red-600">
                                {{ newLinkForm.errors.title }}
                            </p>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                                URL
                            </label>
                            <input
                                v-model="newLinkForm.url"
                                type="text"
                                inputmode="url"
                                autocapitalize="none"
                                spellcheck="false"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-200"
                                placeholder="enlace.com o https://enlace.com"
                            >
                            <p v-if="newLinkForm.errors.url" class="mt-1 text-xs text-red-600">
                                {{ newLinkForm.errors.url }}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="newLinkForm.processing"
                        >
                            Agregar link
                        </button>
                    </div>
                </form>
            </div>

            <div
                v-if="links.length === 0"
                class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500"
            >
                <span v-if="isOwner">Aún no tienes links publicados. Agrega el primero en el formulario de arriba.</span>
                <span v-else>Este usuario aun no tiene links publicados.</span>
            </div>

            <div v-else class="space-y-2">
                <article
                    v-for="link in links"
                    :key="link.id"
                    class="rounded-lg border border-gray-200 bg-white p-3 transition hover:border-green-200 hover:bg-green-50"
                >
                    <form
                        v-if="isOwner && editingLinkId === link.id"
                        class="space-y-3"
                        @submit.prevent="emit('update-link', link.id)"
                    >
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                                    Titulo
                                </label>
                                <input
                                    v-model="editLinkForm.title"
                                    type="text"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-200"
                                >
                                <p v-if="editLinkForm.errors.title" class="mt-1 text-xs text-red-600">
                                    {{ editLinkForm.errors.title }}
                                </p>
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                                    URL
                                </label>
                                <input
                                    v-model="editLinkForm.url"
                                    type="text"
                                    inputmode="url"
                                    autocapitalize="none"
                                    spellcheck="false"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-200"
                                    placeholder="enlace.com o https://enlace.com"
                                >
                                <p v-if="editLinkForm.errors.url" class="mt-1 text-xs text-red-600">
                                    {{ editLinkForm.errors.url }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-end gap-2">
                            <button
                                type="submit"
                                class="rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-60"
                                :disabled="editLinkForm.processing"
                            >
                                Guardar
                            </button>
                            <button
                                type="button"
                                class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-100"
                                @click="emit('cancel-edit-link')"
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>

                    <template v-else>
                        <div class="flex items-center justify-between gap-3">
                            <a
                                :href="link.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex min-w-0 flex-1 items-center rounded-lg px-3 py-2 text-sm text-gray-700 transition hover:bg-green-100 hover:text-green-700"
                            >
                                <span class="truncate font-medium">{{ link.title }}</span>
                            </a>

                            <div v-if="isOwner" class="flex shrink-0 items-center gap-2">
                            <button
                                type="button"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-green-300 text-green-600 transition hover:border-green-400 hover:bg-green-200 hover:text-green-800"
                                aria-label="Editar link"
                                title="Editar link"
                                @click="emit('start-edit-link', link)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a2.121 2.121 0 013 3L10.93 16.418a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897l8.584-8.584z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.875 4.5" />
                                </svg>
                            </button>
                            <button
                                type="button"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-300 text-red-600 transition hover:border-red-400 hover:bg-red-100 hover:text-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                                :disabled="deleteLinkForm.processing"
                                aria-label="Eliminar link"
                                title="Eliminar link"
                                @click="emit('remove-link', link.id)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 6V4a1 1 0 011-1h6a1 1 0 011 1v2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6M14 11v6" />
                                </svg>
                            </button>
                            </div>
                        </div>
                    </template>
                </article>
            </div>
        </div>
    </Modal>
</template>
