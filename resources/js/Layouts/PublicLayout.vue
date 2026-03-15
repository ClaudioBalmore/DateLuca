<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const canLogin = page.props.canLogin ?? false;
const canRegister = page.props.canRegister ?? false;
const authenticatedUser = page.props.auth?.user ?? null;
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-white">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white shadow-sm border-b border-green-100 md:static">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <Link href="/" class="flex items-center gap-2 justify-center">
                            <img src="/logo.png" alt="Logo DateLuca" class="w-[100px] h-[100px] object-contain" style="width: 80px; height: auto;" />
                            <span class="ml-2 text-xl font-bold text-gray-900">DateLuca</span>
                        </Link>
                    </div>
                    <nav class="flex items-center space-x-4 gap-2">
                        <Link v-if="canLogin && !authenticatedUser" :href="route('login')" class="text-gray-600 hover:text-primary-600 transition">
                            Iniciar sesión
                        </Link>
                        <Link v-if="canRegister && !authenticatedUser" :href="route('register')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                            Registrarse
                        </Link>
                        <details v-if="authenticatedUser" class="relative">
                            <summary class="list-none cursor-pointer text-gray-600 hover:text-primary-600 transition select-none">
                                <span class="inline-flex items-center gap-1">
                                    {{ authenticatedUser.name }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </summary>
                            <div class="absolute right-0 mt-2 w-48 rounded-lg border border-green-100 bg-white py-2 shadow-lg">
                                <Link :href="route('dashboard.slug', { slug: authenticatedUser.slug })" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-primary-700">
                                    Mi Panel
                                </Link>
                                <Link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-primary-700">
                                    Editar perfil
                                </Link>
                                <Link :href="route('logout')" method="post" as="button" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-green-50 hover:text-primary-700">
                                    Cerrar sesión
                                </Link>
                            </div>
                        </details>
                    </nav>
                </div>
            </div>
        </header>

        <main>
            <slot />
        </main>
    </div>
</template>