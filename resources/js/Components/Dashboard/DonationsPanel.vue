<script setup>
import GiveLucasButton from '@/Components/Donations/GiveLucasButton.vue';
import { computed } from 'vue';

const props = defineProps({
    donations: {
        type: Array,
        default: () => [],
    },
    canDonate: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['open-donate']);

const resolveDonationDate = (donation) => {
    return donation?.created_at ?? donation?.donation_date ?? null;
};

const sortedDonations = computed(() => {
    return [...(props.donations ?? [])].sort((a, b) => {
        const dateA = new Date(resolveDonationDate(a) ?? 0).getTime();
        const dateB = new Date(resolveDonationDate(b) ?? 0).getTime();

        return dateB - dateA;
    });
});

const pluralize = (value, singular, plural) => {
    return `${value} ${value === 1 ? singular : plural}`;
};

const formatDate = (value) => {
    if (!value) {
        return 'Fecha no disponible';
    }

    const parsedDate = new Date(value);

    if (Number.isNaN(parsedDate.getTime())) {
        return 'Fecha no disponible';
    }

    const now = new Date();
    const diffMs = Math.max(0, now.getTime() - parsedDate.getTime());
    const minutes = Math.floor(diffMs / (1000 * 60));

    if (minutes < 60) {
        const visibleMinutes = Math.max(1, minutes);
        return `hace ${pluralize(visibleMinutes, 'minuto', 'minutos')}`;
    }

    const hours = Math.floor(minutes / 60);

    if (hours < 24) {
        const visibleHours = Math.max(1, hours);
        return `hace ${pluralize(visibleHours, 'hora', 'horas')}`;
    }

    const days = Math.floor(hours / 24);

    if (days <= 6) {
        return `hace ${pluralize(days, 'día', 'días')}`;
    }

    if (days < 28) {
        const weeks = Math.floor(days / 7);
        return `hace ${pluralize(weeks, 'semana', 'semanas')}`;
    }

    let totalMonths =
        (now.getFullYear() - parsedDate.getFullYear()) * 12 +
        (now.getMonth() - parsedDate.getMonth());

    if (now.getDate() < parsedDate.getDate()) {
        totalMonths -= 1;
    }

    totalMonths = Math.max(0, totalMonths);

    if (totalMonths < 12) {
        const months = Math.max(1, totalMonths);
        return `hace ${pluralize(months, 'mes', 'meses')}`;
    }

    const years = Math.floor(totalMonths / 12);
    const remainingMonths = totalMonths % 12;

    if (remainingMonths === 0) {
        return `hace ${pluralize(years, 'año', 'años')}`;
    }

    return `hace ${pluralize(years, 'año', 'años')} y ${pluralize(remainingMonths, 'mes', 'meses')}`;
};

const formatLucas = (value) => {
    const amount = Number(value ?? 0);
    const normalizedAmount = Number.isNaN(amount) ? 0 : amount;
    const lucas = Math.max(0, Math.round(normalizedAmount / 1000));

    return `${lucas} ${lucas === 1 ? 'Luca' : 'Lucas'}`;
};
</script>

<template>
    <div class="rounded-2xl border border-green-100 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Lucas recibidas
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Ayúdame a llenar el chanchito 🐷💰
                </p>
            </div>

            <div v-if="canDonate" class="w-full sm:w-auto sm:shrink-0 sm:pt-1">
                <GiveLucasButton @click="emit('open-donate')" />
            </div>
        </div>

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
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <p class="flex min-w-0 flex-wrap items-center gap-x-2 gap-y-1 text-sm">
                        <span class="font-semibold text-gray-900">
                            {{ donation.donor_name || 'Anónimo' }}
                        </span>
                        <span aria-hidden="true" class="h-1 w-1 rounded-full bg-gray-300" />
                        <span class="text-xs text-gray-500">
                            {{ formatDate(resolveDonationDate(donation)) }}
                        </span>
                    </p>

                    <p class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.9"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-4 w-4"
                        >
                            <rect x="3" y="7" width="18" height="10" rx="2.1" />
                            <path d="M6 7c0 1.6-1.4 3-3 3" />
                            <path d="M21 10c-1.6 0-3-1.4-3-3" />
                            <path d="M6 17c0-1.6-1.4-3-3-3" />
                            <path d="M21 14c-1.6 0-3 1.4-3 3" />
                            <circle cx="12" cy="12" r="2" />
                        </svg>
                        {{ formatLucas(donation.amount) }}
                    </p>
                </div>
                <p class="mt-3 text-sm leading-relaxed text-gray-700">
                    {{ donation.message || 'Sin mensaje.' }}
                </p>
            </article>
        </div>
    </div>
</template>
