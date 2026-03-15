<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const mobileMenuOpen = ref(false);

const canLogin = computed(() => page.props.canLogin ?? false);
const canRegister = computed(() => page.props.canRegister ?? false);
const authenticatedUser = computed(() => page.props.auth?.user ?? null);

const closeMobileMenu = () => {
    mobileMenuOpen.value = false;
};
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-green-100 bg-white shadow-sm md:static">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center">
                    <Link href="/" class="flex items-center justify-center gap-2">
                        <img src="/logo.png" alt="Logo DateLuca" class="h-[100px] w-[100px] object-contain" style="width: 80px; height: auto;" />
                        <span class="ml-2 text-xl font-bold text-gray-900">DateLuca</span>
                    </Link>
                </div>

                <nav class="hidden items-center space-x-4 gap-2 md:flex">
                    <Link
                        v-if="canLogin && !authenticatedUser"
                        :href="route('login')"
                        class="text-gray-600 transition hover:text-primary-600"
                    >
                        Iniciar sesión
                    </Link>
                    <Link
                        v-if="canRegister && !authenticatedUser"
                        :href="route('register')"
                        class="rounded-lg bg-primary-600 px-4 py-2 text-white transition hover:bg-primary-700"
                    >
                        Registrarse
                    </Link>
                    <details v-if="authenticatedUser" class="relative">
                        <summary class="list-none cursor-pointer select-none text-gray-600 transition hover:text-primary-600">
                            <span class="inline-flex items-center gap-1">
                                {{ authenticatedUser.name }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </summary>
                        <div class="absolute right-0 z-10 mt-2 w-48 rounded-lg border border-green-100 bg-white py-2 shadow-lg">
                            <Link
                                :href="route('dashboard.slug', { slug: authenticatedUser.slug })"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-primary-700"
                            >
                                Mi Panel
                            </Link>
                            <Link
                                :href="route('profile.edit')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-primary-700"
                            >
                                Editar perfil
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-green-50 hover:text-primary-700"
                            >
                                Cerrar sesión
                            </Link>
                        </div>
                    </details>
                </nav>

                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg border border-green-100 p-2 text-gray-600 transition hover:bg-green-50 hover:text-primary-600 md:hidden"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    :aria-expanded="mobileMenuOpen"
                    aria-label="Abrir menú de navegación"
                >
                    <svg v-if="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div v-if="mobileMenuOpen" class="border-t border-green-100 pb-4 pt-3 md:hidden">
                <nav class="flex flex-col gap-3">
                    <Link
                        v-if="canLogin && !authenticatedUser"
                        :href="route('login')"
                        class="text-gray-600 transition hover:text-primary-600"
                        @click="closeMobileMenu"
                    >
                        Iniciar sesión
                    </Link>
                    <Link
                        v-if="canRegister && !authenticatedUser"
                        :href="route('register')"
                        class="rounded-lg bg-primary-600 px-4 py-2 text-center text-white transition hover:bg-primary-700"
                        @click="closeMobileMenu"
                    >
                        Registrarse
                    </Link>
                    <Link
                        v-if="authenticatedUser"
                        :href="route('dashboard.slug', { slug: authenticatedUser.slug })"
                        class="text-gray-600 transition hover:text-primary-600"
                        @click="closeMobileMenu"
                    >
                        Mi Panel
                    </Link>
                    <Link
                        v-if="authenticatedUser"
                        :href="route('profile.edit')"
                        class="text-gray-600 transition hover:text-primary-600"
                        @click="closeMobileMenu"
                    >
                        Editar perfil
                    </Link>
                    <Link
                        v-if="authenticatedUser"
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-left text-gray-600 transition hover:text-primary-600"
                        @click="closeMobileMenu"
                    >
                        Cerrar sesión
                    </Link>
                </nav>
            </div>
        </div>
    </header>
</template>
