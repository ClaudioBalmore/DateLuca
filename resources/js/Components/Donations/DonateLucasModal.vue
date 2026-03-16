<script setup>
import Modal from '@/Components/Modal.vue';
import DonationDetailsStep from '@/Components/Donations/DonationDetailsStep.vue';
import DonationPaymentStep from '@/Components/Donations/DonationPaymentStep.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, reactive, ref, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    profileUser: {
        type: Object,
        required: true,
    },
    isAuthenticated: {
        type: Boolean,
        default: false,
    },
    authenticatedUser: {
        type: Object,
        default: null,
    },
    isOwner: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const currentStep = ref('details');
const closeTimerId = ref(null);

const clientErrors = reactive({
    donor_name: '',
    message: '',
    lucas: '',
    card_number: '',
    card_expiry: '',
    card_cvv: '',
});

const donationForm = useForm({
    donor_name: '',
    message: '',
    lucas: 1,
    card_number: '',
    card_expiry: '',
    card_cvv: '',
});

const mergedErrors = computed(() => {
    return {
        donor_name: clientErrors.donor_name || donationForm.errors.donor_name || '',
        message: clientErrors.message || donationForm.errors.message || '',
        lucas: clientErrors.lucas || donationForm.errors.lucas || '',
        card_number: clientErrors.card_number || donationForm.errors.card_number || '',
        card_expiry: clientErrors.card_expiry || donationForm.errors.card_expiry || '',
        card_cvv: clientErrors.card_cvv || donationForm.errors.card_cvv || '',
    };
});

const clearCloseTimer = () => {
    if (closeTimerId.value !== null) {
        window.clearTimeout(closeTimerId.value);
        closeTimerId.value = null;
    }
};

const clearClientErrors = (fields = Object.keys(clientErrors)) => {
    fields.forEach((field) => {
        clientErrors[field] = '';
    });
};

const resetModalState = () => {
    clearCloseTimer();
    currentStep.value = 'details';
    donationForm.clearErrors();
    clearClientErrors();

    donationForm.donor_name = props.isAuthenticated ? String(props.authenticatedUser?.name ?? '') : '';
    donationForm.message = '';
    donationForm.lucas = 1;
    donationForm.card_number = '';
    donationForm.card_expiry = '';
    donationForm.card_cvv = '';
};

watch(
    () => props.show,
    (isOpen) => {
        if (isOpen) {
            resetModalState();
        } else {
            clearCloseTimer();
        }
    },
);

watch(
    () => props.authenticatedUser?.name,
    (name) => {
        if (props.show && props.isAuthenticated) {
            donationForm.donor_name = String(name ?? '');
        }
    },
);

const normalizeLucas = (value) => {
    const parsed = Number.parseInt(String(value), 10);

    if (Number.isNaN(parsed)) {
        return 1;
    }

    return Math.min(100, Math.max(1, parsed));
};

const updateDonorName = (value) => {
    donationForm.donor_name = String(value ?? '').slice(0, 255);
};

const updateMessage = (value) => {
    donationForm.message = String(value ?? '').slice(0, 50);
};

const updateLucas = (value) => {
    donationForm.lucas = normalizeLucas(value);
};

const updateCardNumber = (value) => {
    donationForm.card_number = String(value ?? '');
};

const updateCardExpiry = (value) => {
    donationForm.card_expiry = String(value ?? '');
};

const updateCardCvv = (value) => {
    donationForm.card_cvv = String(value ?? '');
};

const validateDetailsStep = () => {
    clearClientErrors(['donor_name', 'message', 'lucas']);

    const donorName = donationForm.donor_name.trim();

    if (!props.isAuthenticated && donorName === '') {
        clientErrors.donor_name = 'Debes indicar tu nombre para donar.';
    }

    if (donationForm.message.length > 50) {
        clientErrors.message = 'El mensaje no puede superar 50 caracteres.';
    }

    const lucas = normalizeLucas(donationForm.lucas);
    donationForm.lucas = lucas;

    if (lucas < 1 || lucas > 100) {
        clientErrors.lucas = 'Puedes donar entre 1 y 100 Lucas.';
    }

    return !clientErrors.donor_name && !clientErrors.message && !clientErrors.lucas;
};

const validatePaymentStep = () => {
    clearClientErrors(['card_number', 'card_expiry', 'card_cvv']);

    if (!/^\d{16}$/.test(donationForm.card_number)) {
        clientErrors.card_number = 'La tarjeta debe tener 16 digitos numericos.';
    }

    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(donationForm.card_expiry)) {
        clientErrors.card_expiry = 'El vencimiento debe tener formato MM/AA.';
    }

    if (!/^\d{3}$/.test(donationForm.card_cvv)) {
        clientErrors.card_cvv = 'El CVV debe tener 3 digitos.';
    }

    return !clientErrors.card_number && !clientErrors.card_expiry && !clientErrors.card_cvv;
};

const goToPaymentStep = () => {
    if (!validateDetailsStep()) {
        return;
    }

    clearClientErrors(['card_number', 'card_expiry', 'card_cvv']);
    donationForm.clearErrors('card_number', 'card_expiry', 'card_cvv');
    currentStep.value = 'payment';
};

const goToDetailsStep = () => {
    currentStep.value = 'details';
};

const closeModal = () => {
    if (donationForm.processing) {
        return;
    }

    clearCloseTimer();
    emit('close');
};

const submitDonation = () => {
    if (!validateDetailsStep()) {
        currentStep.value = 'details';
        return;
    }

    if (!validatePaymentStep()) {
        currentStep.value = 'payment';
        return;
    }

    if (props.isOwner) {
        currentStep.value = 'details';
        clientErrors.lucas = 'No puedes donar a tu propio perfil.';
        return;
    }

    donationForm.post(route('donations.public.store', { slug: props.profileUser.slug }), {
        preserveScroll: true,
        onSuccess: () => {
            currentStep.value = 'success';
            clearCloseTimer();
            closeTimerId.value = window.setTimeout(() => {
                closeModal();
            }, 1400);
        },
        onError: () => {
            if (donationForm.errors.donor_name || donationForm.errors.message || donationForm.errors.lucas) {
                currentStep.value = 'details';
            }
        },
    });
};

onBeforeUnmount(() => {
    clearCloseTimer();
});
</script>

<template>
    <Modal :show="show" max-width="lg" :center-desktop="true" @close="closeModal">
        <div class="p-6 sm:p-7">
            <div class="mb-4 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Dar Lucas a @{{ profileUser.slug }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Cada Luca equivale a CLP$1.000.
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-md p-1 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                    :disabled="donationForm.processing"
                    @click="closeModal"
                >
                    <span class="sr-only">Cerrar modal</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div
                v-if="isOwner"
                class="rounded-xl border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800"
            >
                No puedes donar a tu propio perfil.
            </div>

            <div
                v-else-if="currentStep === 'success'"
                class="rounded-xl border border-green-200 bg-green-50 p-4"
            >
                <p class="text-sm font-semibold text-green-800">
                    Pago simulado exitoso. Tu donacion fue registrada correctamente.
                </p>
                <p class="mt-1 text-xs text-green-700">
                    Cerrando modal...
                </p>
            </div>

            <DonationDetailsStep
                v-else-if="currentStep === 'details'"
                :is-authenticated="isAuthenticated"
                :donor-name="donationForm.donor_name"
                :message="donationForm.message"
                :lucas="Number(donationForm.lucas)"
                :errors="mergedErrors"
                @update:donor-name="updateDonorName"
                @update:message="updateMessage"
                @update:lucas="updateLucas"
                @continue="goToPaymentStep"
            />

            <DonationPaymentStep
                v-else
                :lucas="Number(donationForm.lucas)"
                :card-number="donationForm.card_number"
                :card-expiry="donationForm.card_expiry"
                :card-cvv="donationForm.card_cvv"
                :errors="mergedErrors"
                :processing="donationForm.processing"
                @update:card-number="updateCardNumber"
                @update:card-expiry="updateCardExpiry"
                @update:card-cvv="updateCardCvv"
                @back="goToDetailsStep"
                @submit="submitDonation"
            />
        </div>
    </Modal>
</template>
