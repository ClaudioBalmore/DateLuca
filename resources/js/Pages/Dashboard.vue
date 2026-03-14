<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const page = usePage();
const isAuthenticated = !!page.props.auth?.user;
const isOwner = isAuthenticated && page.props.auth.user.id === props.user?.id;
</script>

<template>
    <Head :title="`Perfil de ${user.name}`" />

    <PublicLayout v-if="!isAuthenticated">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Perfil de {{ user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium">{{ user.name }}</h3>
                        <p class="text-sm text-gray-600">Slug: @{{ user.slug }}</p>
                        <p class="text-sm text-gray-600">Email: {{ user.email }}</p>
                        <!-- Aquí puedes agregar más campos como bio, foto, etc. -->
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>

    <AuthenticatedLayout v-else>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Panel
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 v-if="isOwner">¡Bienvenido a tu panel, {{ user.name }}!</h3>
                        <h3 v-else>Perfil de {{ user.name }}</h3>
                        <p class="text-sm text-gray-600">Slug: @{{ user.slug }}</p>
                        <p class="text-sm text-gray-600">Email: {{ user.email }}</p>
                        <!-- Opciones de edición si es owner -->
                        <div v-if="isOwner" class="mt-4">
                            <a :href="route('profile.edit')" class="text-primary-600 hover:text-primary-900">Editar perfil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
