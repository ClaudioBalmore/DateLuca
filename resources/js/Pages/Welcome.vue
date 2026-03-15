<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';

const mobileMenuOpen = ref(false);
const page = usePage();
const authenticatedUser = page.props.auth?.user ?? null;

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="DateLuca - Apoya a tus creadores favoritos" />

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
                    <nav class="hidden items-center space-x-4 gap-2 md:flex">
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
                            <div class="absolute right-0 mt-2 w-48 rounded-lg border border-green-100 bg-white py-2 shadow-lg z-10">
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
                            class="text-gray-600 hover:text-primary-600 transition"
                            @click="mobileMenuOpen = false"
                        >
                            Iniciar sesión
                        </Link>
                        <Link
                            v-if="canRegister && !authenticatedUser"
                            :href="route('register')"
                            class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition text-center"
                            @click="mobileMenuOpen = false"
                        >
                            Registrarse
                        </Link>
                        <Link
                            v-if="authenticatedUser"
                            :href="route('dashboard.slug', { slug: authenticatedUser.slug })"
                            class="text-gray-600 hover:text-primary-600 transition"
                            @click="mobileMenuOpen = false"
                        >
                            Mi Panel
                        </Link>
                        <Link
                            v-if="authenticatedUser"
                            :href="route('profile.edit')"
                            class="text-gray-600 hover:text-primary-600 transition"
                            @click="mobileMenuOpen = false"
                        >
                            Editar perfil
                        </Link>
                        <Link
                            v-if="authenticatedUser"
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="text-left text-gray-600 hover:text-primary-600 transition"
                            @click="mobileMenuOpen = false"
                        >
                            Cerrar sesión
                        </Link>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-center bg-white border border-white shadow-md rounded-lg p-4">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Apoya a tus creadores favoritos
                    <span class="block text-primary-600">Date una Luca po'</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    DateLuca es la plataforma chilena para apoyar a artistas, youtubers, programadores y creadores de contenido.
                    Recibe donaciones, comparte tu perfil y conecta con tu comunidad. ¡Todo con un toque de humor nacional!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link :href="route('register')" class="bg-primary-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-primary-700 transition">
                        Crear mi perfil
                    </Link>
                    <Link :href="route('login')" class="border-2 border-primary-600 text-primary-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-primary-50 transition">
                        Iniciar sesión
                    </Link>
                </div>
            </div>
        </section>

        <!-- ¿Qué es DateLuca? -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">¿Qué es DateLuca?</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Imagina Ko-fi, pero con más terremoto, cueca y "po" al final de cada oración.
                        Una plataforma 100% chilena para que apoyes a tus ídolos sin complicaciones.
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-primary-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">👥</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Para Creadores</h3>
                        <p class="text-gray-600">Crea tu perfil @tu-nickname, comparte tu bio y recibe apoyos directos de tu comunidad.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-primary-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">❤️</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Para Fans</h3>
                        <p class="text-gray-600">Apoya a tus artistas favoritos con donaciones simples y directas. ¡Sin suscripciones complicadas!</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-primary-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🇨🇱</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">100% Chileno</h3>
                        <p class="text-gray-600">Hecho por y para chilenos. Con humor local, referencias culturales y un terremoto de funcionalidades.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cómo funciona -->
        <section class="py-16 bg-green-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">¿Cómo funciona?</h2>
                    <p class="text-lg text-gray-600">Más simple que pedir un completo en el centro.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-6 shadow-md h-full">
                            <div class="text-4xl font-bold text-primary-600 mb-4">1</div>
                            <h3 class="text-xl font-semibold mb-2">Regístrate</h3>
                            <p class="text-gray-600">Crea tu cuenta con un nickname único. ¡Elige algo creativo, como @ElPoetaDelSur!</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-6 shadow-md h-full">
                            <div class="text-4xl font-bold text-primary-600 mb-4">2</div>
                            <h3 class="text-xl font-semibold mb-2">Personaliza tu perfil</h3>
                            <p class="text-gray-600">Agrega tu bio, foto y enlaces. Comparte por qué mereces apoyo (o por qué no).</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-white rounded-lg p-6 shadow-md">
                            <div class="text-4xl font-bold text-primary-600 mb-4">3</div>
                            <h3 class="text-xl font-semibold mb-2">Recibe apoyos</h3>
                            <p class="text-gray-600">Comparte tu @nickname y recibe donaciones directas. ¡Sin intermediarios ni terremotos financieros!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ejemplos -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Creadores destacados</h2>
                    <p class="text-lg text-gray-600">Algunos ejemplos de perfiles que podrías crear.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-2xl">🎨</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">@LaArtistaDelSur</h3>
                        <p class="text-gray-600 mb-4">"Pinto cuadros que hacen llorar a los terremotos. Apoya mi arte chileno."</p>
                        <div class="text-primary-600 font-semibold">Recibió 150 apoyos este mes</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-2xl">🎵</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">@CantorDeCuecas</h3>
                        <p class="text-gray-600 mb-4">"Canto cuecas que hacen bailar hasta a los pingüinos. ¡Apoya la música nacional!"</p>
                        <div class="text-primary-600 font-semibold">Recibió 89 apoyos este mes</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-2xl">💻</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">@ProgramadorPo</h3>
                        <p class="text-gray-600 mb-4">"Codeo apps que sobreviven a los terremotos. Apoya mi café digital."</p>
                        <div class="text-primary-600 font-semibold">Recibió 234 apoyos este mes</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Final -->
        <section class="py-16 bg-primary-600 text-white">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-4">¿Listo para recibir apoyos?</h2>
                <p class="text-xl mb-8">Únete a la comunidad chilena de creadores. Es gratis, es fácil y tiene humor.</p>
                <Link :href="route('register')" class="bg-white text-primary-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition">
                    Crear mi perfil gratis
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <ApplicationLogo class="h-8 w-8 text-primary-400" />
                        <span class="ml-2 text-lg font-semibold">DateLuca</span>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-gray-400">Hecho con ❤️ en Chile.</p>
                        <p class="text-sm text-gray-500 mt-1">Resistente a terremotos de magnitud 8.8</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
