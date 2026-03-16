<script setup>
defineProps({
    isAuthenticated: {
        type: Boolean,
        default: false,
    },
    donorName: {
        type: String,
        default: '',
    },
    message: {
        type: String,
        default: '',
    },
    lucas: {
        type: Number,
        default: 1,
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits([
    'update:donorName',
    'update:message',
    'update:lucas',
    'continue',
]);
</script>

<template>
    <div>
        <h3 class="text-lg font-semibold text-gray-900">
            Configura tu donacion
        </h3>
        <p class="mt-1 text-sm text-gray-600">
            Indica cuantas Lucas quieres donar y deja un mensaje opcional para el creador.
        </p>

        <form class="mt-5 space-y-4" @submit.prevent="emit('continue')">
            <div>
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                    Nombre
                </label>

                <input
                    v-if="!isAuthenticated"
                    :value="donorName"
                    type="text"
                    maxlength="255"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                    placeholder="Tu nombre"
                    @input="emit('update:donorName', $event.target.value)"
                >

                <input
                    v-else
                    :value="donorName"
                    type="text"
                    disabled
                    class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-600"
                >

                <p v-if="isAuthenticated" class="mt-1 text-xs text-gray-500">
                    Tu nombre se usa automaticamente porque ya iniciaste sesion.
                </p>
                <p v-if="errors.donor_name" class="mt-1 text-xs text-red-600">
                    {{ errors.donor_name }}
                </p>
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                    Mensaje (opcional)
                </label>
                <textarea
                    :value="message"
                    rows="3"
                    maxlength="50"
                    class="h-24 w-full resize-none rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                    placeholder="Gracias por tu contenido"
                    @input="emit('update:message', $event.target.value)"
                />
                <div class="mt-1 flex justify-between text-xs text-gray-500">
                    <span>Maximo 50 caracteres.</span>
                    <span>{{ message.length }}/50</span>
                </div>
                <p v-if="errors.message" class="mt-1 text-xs text-red-600">
                    {{ errors.message }}
                </p>
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                    Cantidad de Lucas
                </label>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                    <input
                        :value="lucas"
                        type="range"
                        min="1"
                        max="100"
                        step="1"
                        class="w-full accent-green-600"
                        @input="emit('update:lucas', $event.target.value)"
                    >
                    <div class="mt-2 flex items-center justify-between gap-3">
                        <input
                            :value="lucas"
                            type="number"
                            min="1"
                            max="100"
                            step="1"
                            class="w-24 rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                            @input="emit('update:lucas', $event.target.value)"
                        >
                        <p class="text-sm font-semibold text-green-700">
                            {{ lucas }} {{ lucas === 1 ? 'Luca' : 'Lucas' }}
                        </p>
                    </div>
                </div>
                <p v-if="errors.lucas" class="mt-1 text-xs text-red-600">
                    {{ errors.lucas }}
                </p>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700"
                >
                    Continuar al pago simulado
                </button>
            </div>
        </form>
    </div>
</template>
