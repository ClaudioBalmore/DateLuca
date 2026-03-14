<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    links: Array,
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
                        <div class="flex items-center space-x-4 mb-4">
                            <img v-if="user.profile_image" :src="user.profile_image" alt="Foto de perfil" class="w-16 h-16 rounded-full object-cover" />
                            <div>
                                <h3 class="text-lg font-medium">{{ user.name }}</h3>
                                <p class="text-sm text-gray-600">@{{ user.slug }}</p>
                            </div>
                        </div>
                        <p v-if="user.bio" class="text-gray-700 mb-4">{{ user.bio }}</p>
                        <div v-if="links && links.length > 0" class="space-y-2">
                            <h4 class="font-semibold">Enlaces:</h4>
                            <div v-for="link in links" :key="link.id">
                                <a :href="link.url" target="_blank" class="block bg-primary-100 hover:bg-primary-200 text-primary-800 px-4 py-2 rounded-lg transition">
                                    {{ link.title }}
                                </a>
                            </div>
                        </div>
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
                        <div v-if="isOwner" class="mt-4 space-y-2">
                            <a :href="route('profile.edit')" class="text-primary-600 hover:text-primary-900 block">Editar perfil</a>
                            <a :href="route('links.index')" class="text-primary-600 hover:text-primary-900 block">Gestionar Links</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
