<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    link: Object,
});

const form = useForm({
    title: props.link.title,
    url: props.link.url,
});

const submit = () => {
    form.put(route('links.update', props.link.id), {
        onSuccess: () => {
            // Redirect handled by controller
        },
    });
};
</script>

<template>
    <Head title="Editar Link" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar Link
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                                <input
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                    required
                                />
                                <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</div>
                            </div>

                            <div class="mb-4">
                                <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                                <input
                                    id="url"
                                    v-model="form.url"
                                    type="text"
                                    inputmode="url"
                                    autocapitalize="none"
                                    spellcheck="false"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="enlace.com o https://enlace.com"
                                    required
                                />
                                <div v-if="form.errors.url" class="text-red-600 text-sm mt-1">{{ form.errors.url }}</div>
                            </div>

                            <div class="flex items-center justify-between">
                                <Link :href="route('links.index')" class="text-gray-600 hover:text-gray-900">Cancelar</Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 disabled:opacity-50"
                                >
                                    Actualizar Link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>