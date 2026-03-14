<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-green-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <div class="flex shrink-0 items-center">
                                <Link href="/">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-primary-700" />
                                </Link>
                            </div>
                        </div>
                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <div class="ms-3">
                                <Link
                                    v-if="$page.props.auth.user"
                                    :href="route('dashboard.slug', { slug: $page.props.auth.user.slug })"
                                    class="rounded-md text-sm text-primary-700 underline hover:text-primary-900"
                                >
                                    Mi Panel
                                </Link>
                                <Link
                                    v-else
                                    :href="route('login')"
                                    class="rounded-md text-sm text-primary-700 underline hover:text-primary-900"
                                >
                                    Iniciar sesión
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <header v-if="$slots.header" class="bg-white shadow">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>