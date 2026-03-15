<script setup>
import { computed } from 'vue';

const props = defineProps({
    donations: {
        type: Array,
        default: () => [],
    },
});

const sortedDonations = computed(() => {
    return [...(props.donations ?? [])].sort((a, b) => {
        const dateA = new Date(a.donation_date ?? a.created_at ?? 0).getTime();
        const dateB = new Date(b.donation_date ?? b.created_at ?? 0).getTime();

        return dateB - dateA;
    });
});

const formatDate = (value) => {
    if (!value) {
        return 'Fecha no disponible';
    }

    const parsedDate = new Date(value);

    if (Number.isNaN(parsedDate.getTime())) {
        return 'Fecha no disponible';
    }

    return new Intl.DateTimeFormat('es-CL', {
        dateStyle: 'medium',
    }).format(parsedDate);
};

const formatAmount = (value) => {
    const amount = Number(value ?? 0);

    return new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: 'CLP',
        maximumFractionDigits: 0,
    }).format(Number.isNaN(amount) ? 0 : amount);
};
</script>

<template>
    <div class="rounded-2xl border border-green-100 bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900">
            Lucas recibidas
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Ayúdame a llenar el chanchito 🐷💰
        </p>

        <div
            v-if="sortedDonations.length === 0"
            class="mt-6 rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500"
        >
            Aún no hay donaciones registradas.
        </div>

        <div v-else class="mt-6 space-y-3">
            <article
                v-for="donation in sortedDonations"
                :key="donation.id"
                class="rounded-xl border border-gray-100 bg-gray-50 p-4"
            >
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="font-semibold text-gray-900">
                            {{ donation.donor_name || 'Anonimo' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ formatDate(donation.donation_date || donation.created_at) }}
                        </p>
                    </div>
                    <p class="rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700">
                        {{ formatAmount(donation.amount) }}
                    </p>
                </div>
                <p class="mt-3 text-sm leading-relaxed text-gray-700">
                    {{ donation.message || 'Sin mensaje.' }}
                </p>
            </article>
        </div>
    </div>
</template>
