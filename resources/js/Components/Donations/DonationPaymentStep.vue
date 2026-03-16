<script setup>
import { computed } from 'vue';

const props = defineProps({
    lucas: {
        type: Number,
        default: 1,
    },
    cardNumber: {
        type: String,
        default: '',
    },
    cardExpiry: {
        type: String,
        default: '',
    },
    cardCvv: {
        type: String,
        default: '',
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
    processing: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits([
    'update:cardNumber',
    'update:cardExpiry',
    'update:cardCvv',
    'back',
    'submit',
]);

const lucasAmount = computed(() => {
    const parsed = Number.parseInt(String(props.lucas), 10);
    if (Number.isNaN(parsed)) {
        return 1;
    }

    return Math.min(100, Math.max(1, parsed));
});

const lucasLabel = computed(() => (lucasAmount.value === 1 ? 'Luca' : 'Lucas'));

const totalAmount = computed(() => lucasAmount.value * 1000);

const formattedTotalAmount = computed(() => {
    return new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: 'CLP',
        maximumFractionDigits: 0,
    }).format(totalAmount.value);
});

const updateCardNumber = (event) => {
    const rawValue = String(event.target.value ?? '');
    emit('update:cardNumber', rawValue.replace(/\D/g, '').slice(0, 16));
};

const updateCardExpiry = (event) => {
    const rawValue = String(event.target.value ?? '');
    const digits = rawValue.replace(/\D/g, '').slice(0, 4);
    const month = digits.slice(0, 2);
    const year = digits.slice(2, 4);

    emit('update:cardExpiry', year.length > 0 ? `${month}/${year}` : month);
};

const updateCardCvv = (event) => {
    const rawValue = String(event.target.value ?? '');
    emit('update:cardCvv', rawValue.replace(/\D/g, '').slice(0, 3));
};
</script>

<template>
    <div>
        <h3 class="text-lg font-semibold text-gray-900">
            Pago simulado
        </h3>
        <p class="mt-1 text-sm text-gray-600">
            Esta es una simulacion de pago para pruebas. No se procesan cobros reales.
        </p>

        <div class="mt-4 rounded-xl border border-green-100 bg-green-50 p-4">
            <p class="text-sm text-gray-700">
                Donacion: <span class="font-semibold text-gray-900">{{ lucasAmount }} {{ lucasLabel }}</span>
            </p>
            <p class="mt-1 text-sm text-gray-700">
                Valor por Luca: <span class="font-semibold text-gray-900">CLP$1.000</span>
            </p>
            <p class="mt-2 text-base font-bold text-green-700">
                Total a pagar: {{ formattedTotalAmount }}
            </p>
        </div>

        <form class="mt-5 space-y-4" @submit.prevent="emit('submit')">
            <div>
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                    Numero de tarjeta
                </label>
                <input
                    :value="cardNumber"
                    type="text"
                    inputmode="numeric"
                    maxlength="16"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm tracking-[0.1em] focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                    placeholder="1234123412341234"
                    @input="updateCardNumber"
                >
                <p v-if="errors.card_number" class="mt-1 text-xs text-red-600">
                    {{ errors.card_number }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                        Vencimiento (MM/AA)
                    </label>
                    <input
                        :value="cardExpiry"
                        type="text"
                        inputmode="numeric"
                        maxlength="5"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                        placeholder="08/29"
                        @input="updateCardExpiry"
                    >
                    <p v-if="errors.card_expiry" class="mt-1 text-xs text-red-600">
                        {{ errors.card_expiry }}
                    </p>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-600">
                        CVV
                    </label>
                    <input
                        :value="cardCvv"
                        type="text"
                        inputmode="numeric"
                        maxlength="3"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                        placeholder="123"
                        @input="updateCardCvv"
                    >
                    <p v-if="errors.card_cvv" class="mt-1 text-xs text-red-600">
                        {{ errors.card_cvv }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap justify-end gap-2">
                <button
                    type="button"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                    :disabled="processing"
                    @click="emit('back')"
                >
                    Volver
                </button>
                <button
                    type="submit"
                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-60"
                    :disabled="processing"
                >
                    {{ processing ? 'Procesando...' : 'Pagar y donar' }}
                </button>
            </div>
        </form>
    </div>
</template>
