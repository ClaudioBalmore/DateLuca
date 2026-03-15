<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    links: {
        type: Array,
        default: () => [],
    },
    donations: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const isOwner = computed(() => page.props.auth?.user?.id === props.user?.id);
const showLinktreeModal = ref(false);
const editingLinkId = ref(null);

const newLinkForm = useForm({
    title: '',
    url: '',
    redirect_to: '',
});

const editLinkForm = useForm({
    title: '',
    url: '',
    redirect_to: '',
});

const deleteLinkForm = useForm({
    redirect_to: '',
});

const profilePath = computed(() => `/@${props.user.slug}`);

const sortedDonations = computed(() => {
    return [...(props.donations ?? [])].sort((a, b) => {
        const dateA = new Date(a.donation_date ?? a.created_at ?? 0).getTime();
        const dateB = new Date(b.donation_date ?? b.created_at ?? 0).getTime();

        return dateB - dateA;
    });
});

const formatDate = (value) => {
    if (!value) {
        return 'Fecha no disponible';
    }

    const parsedDate = new Date(value);

    if (Number.isNaN(parsedDate.getTime())) {
        return 'Fecha no disponible';
    }

    return new Intl.DateTimeFormat('es-CL', {
        dateStyle: 'medium',
    }).format(parsedDate);
};

const formatAmount = (value) => {
    const amount = Number(value ?? 0);

    return new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: 'CLP',
        maximumFractionDigits: 0,
    }).format(Number.isNaN(amount) ? 0 : amount);
};

const openLinktreeModal = () => {
    showLinktreeModal.value = true;
};

const closeLinktreeModal = () => {
    showLinktreeModal.value = false;
    editingLinkId.value = null;
    editLinkForm.reset();
    editLinkForm.clearErrors();
};

const createLink = () => {
    newLinkForm.redirect_to = profilePath.value;

    newLinkForm.post(route('links.store'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            newLinkForm.reset('title', 'url');
            newLinkForm.clearErrors();
        },
    });
};

const startEditLink = (link) => {
    editingLinkId.value = link.id;
    editLinkForm.title = link.title ?? '';
    editLinkForm.url = link.url ?? '';
    editLinkForm.clearErrors();
};

const cancelEditLink = () => {
    editingLinkId.value = null;
    editLinkForm.reset();
    editLinkForm.clearErrors();
};

const updateLink = (linkId) => {
    editLinkForm.redirect_to = profilePath.value;

    editLinkForm.put(route('links.update', linkId), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            cancelEditLink();
        },
    });
};

const removeLink = (linkId) => {
    if (!confirm('Quieres eliminar este link?')) {
        return;
    }

    deleteLinkForm.redirect_to = profilePath.value;

    deleteLinkForm.delete(route('links.destroy', linkId), {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="`Perfil de ${user.name}`" />

    <PublicLayout>
        <div class="py-8 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <aside class="lg:col-span-1">
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
                                {{ user.bio || "Date una Luca po' 💵🐷" }}
                            </p>

                            <button
                                type="button"
                                class="w-full rounded-lg border border-primary-200 bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-700 transition hover:bg-primary-100"
                                @click="openLinktreeModal"
                            >
                                Ver linktree
                            </button>
                        </div>
                    </aside>

                    <section class="lg:col-span-2">
                        <div class="rounded-2xl border border-green-100 bg-white p-6 shadow-sm">
                            <h2 class="text-2xl font-bold text-gray-900">
                                Donaciones recibidas
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Revisa el apoyo que esta recibiendo este perfil.
                            </p>

                            <div
                                v-if="sortedDonations.length === 0"
                                class="mt-6 rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500"
                            >
                                Aun no hay donaciones registradas.
                            </div>

                            <div v-else class="mt-6 space-y-3">
                                <article
                                    v-for="donation in sortedDonations"
                                    :key="donation.id"
                                    class="rounded-xl border border-gray-100 bg-gray-50 p-4"
                                >
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ donation.donor_name || 'Anonimo' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ formatDate(donation.donation_date || donation.created_at) }}
                                            </p>
                                        </div>
                                        <p class="rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700">
                                            {{ formatAmount(donation.amount) }}
                                        </p>
                                    </div>
                                    <p class="mt-3 text-sm leading-relaxed text-gray-700">
                                        {{ donation.message || 'Sin mensaje.' }}
                                    </p>
                                </article>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div
            v-if="showLinktreeModal"
            class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/60 p-4"
            @click.self="closeLinktreeModal"
        >
            <div class="max-h-[85vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white p-6 shadow-xl">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">
                        Linktree de @{{ user.slug }}
                    </h3>
                    <button
                        type="button"
                        class="rounded-md p-1 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                        @click="closeLinktreeModal"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div v-if="isOwner" class="mb-5 rounded-xl border border-green-100 bg-green-50/40 p-4">
                    <h4 class="text-sm font-semibold text-gray-900">
                        Gestiona tus links aquí
                    </h4>
                    <form class="mt-3 space-y-3" @submit.prevent="createLink">
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
                        <button
                            type="submit"
                            class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-700 disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="newLinkForm.processing"
                        >
                            Agregar link
                        </button>
                    </form>
                </div>

                <div
                    v-if="links.length === 0"
                    class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500"
                >
                    <span v-if="isOwner">Aun no tienes links publicados. Agrega el primero en el formulario de arriba.</span>
                    <span v-else>Este usuario aun no tiene links publicados.</span>
                </div>

                <div v-else class="space-y-2">
                    <article
                        v-for="link in links"
                        :key="link.id"
                        class="rounded-lg border border-gray-200 bg-white p-3"
                    >
                        <form
                            v-if="isOwner && editingLinkId === link.id"
                            class="space-y-3"
                            @submit.prevent="updateLink(link.id)"
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
                            <div class="flex flex-wrap gap-2">
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
                                    @click="cancelEditLink"
                                >
                                    Cancelar
                                </button>
                            </div>
                        </form>

                        <template v-else>
                            <a
                                :href="link.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between rounded-lg px-1 py-1 text-sm text-gray-700 transition hover:text-primary-700"
                            >
                                <span class="truncate font-medium">{{ link.title }}</span>
                                <span class="ml-3 text-xs text-gray-500">Abrir</span>
                            </a>

                            <div v-if="isOwner" class="mt-3 flex flex-wrap gap-2">
                                <button
                                    type="button"
                                    class="rounded-lg border border-primary-300 px-3 py-2 text-xs font-semibold text-primary-700 transition hover:bg-primary-50"
                                    @click="startEditLink(link)"
                                >
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    class="rounded-lg border border-red-300 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    :disabled="deleteLinkForm.processing"
                                    @click="removeLink(link.id)"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </template>
                    </article>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
