<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    links: Array,
});
</script>

<template>
    <Head title="Mis Links" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Mis Links
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Lista de Links</h3>
                            <Link :href="route('links.create')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                                Agregar Link
                            </Link>
                        </div>

                        <div v-if="links.length === 0" class="text-center py-8">
                            <p class="text-gray-500">No tienes links aún. <Link :href="route('links.create')" class="text-primary-600">Agrega uno</Link></p>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="link in links" :key="link.id" class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold">{{ link.title }}</h4>
                                    <a :href="link.url" target="_blank" class="text-primary-600 hover:underline">{{ link.url }}</a>
                                </div>
                                <div class="flex space-x-2">
                                    <Link :href="route('links.edit', link.id)" class="text-blue-600 hover:text-blue-900">Editar</Link>
                                    <form :action="route('links.destroy', link.id)" method="POST" @submit.prevent="confirmDelete(link)">
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    methods: {
        confirmDelete(link) {
            if (confirm(`¿Estás seguro de eliminar el link "${link.title}"?`)) {
                this.$el.querySelector(`form[action="${route('links.destroy', link.id)}"]`).submit();
            }
        }
    }
}
</script>