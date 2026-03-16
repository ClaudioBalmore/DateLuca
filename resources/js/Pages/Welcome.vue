<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
</script>

<template>
    <Head title="DateLuca - Apoya a tus creadores favoritos" />

    <PublicLayout>

        <!-- Hero Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-center bg-white border border-white shadow-md rounded-lg p-4">
                <h1 class="mb-6">
                    <span class="block text-2xl md:text-5xl font-bold text-gray-900">
                        Apoya a tus creadores favoritos
                    </span>
                    <span class="block text-4xl md:text-6xl font-bold text-primary-600">
                        Date una Luca po'
                    </span>
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
                        Imagina Ko-fi, pero con más terremoto, cueca y "po'" al final de cada oración.
                        Una plataforma 100% chilena para que apoyes a tus ídolos sin complicaciones.
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-primary-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">👥</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Para Creadores</h3>
                        <p class="text-gray-600">Crea tu perfil @tu-nickname, comparte tu bio y recibe Lucas directos de tu comunidad.</p>
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
                            <h3 class="text-xl font-semibold mb-2">Recibe Lucas</h3>
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
                        <div class="text-primary-600 font-semibold">Recibió 150 Lucas este mes</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-2xl">🎵</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">@CantorDeCuecas</h3>
                        <p class="text-gray-600 mb-4">"Canto cuecas que hacen bailar hasta a los pingüinos. ¡Apoya la música nacional!"</p>
                        <div class="text-primary-600 font-semibold">Recibió 89 Lucas este mes</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <div class="w-20 h-20 bg-primary-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-2xl">💻</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">@ProgramadorPo</h3>
                        <p class="text-gray-600 mb-4">"Codeo apps que sobreviven a los terremotos. Apoya mi café digital."</p>
                        <div class="text-primary-600 font-semibold">Recibió 234 Lucas este mes</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Final -->
        <section class="py-16 bg-primary-600 text-white">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-4">¿Listo para recibir Lucas?</h2>
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
    </PublicLayout>
</template>
