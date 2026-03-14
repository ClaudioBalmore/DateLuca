<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    url: '',
});

const submit = () => {
    form.post(route('links.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Agregar Link" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Agregar Nuevo Link
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
                                    type="url"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"
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
                                    Agregar Link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>