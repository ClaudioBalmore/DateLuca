<script setup>
import DonationsPanel from '@/Components/Dashboard/DonationsPanel.vue';
import LinktreeModal from '@/Components/Dashboard/LinktreeModal.vue';
import ProfileSidebar from '@/Components/Dashboard/ProfileSidebar.vue';
import DonateLucasModal from '@/Components/Donations/DonateLucasModal.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    links: {
        type: Array,
        default: () => [],
    },
    donations: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const isOwner = computed(() => page.props.auth?.user?.id === props.user?.id);
const authenticatedUser = computed(() => page.props.auth?.user ?? null);
const showLinktreeModal = ref(false);
const showDonateModal = ref(false);
const editingLinkId = ref(null);

const newLinkForm = useForm({
    title: '',
    url: '',
    redirect_to: '',
});

const editLinkForm = useForm({
    title: '',
    url: '',
    redirect_to: '',
});

const deleteLinkForm = useForm({
    redirect_to: '',
});

const profilePath = computed(() => `/@${props.user.slug}`);

const openLinktreeModal = () => {
    showLinktreeModal.value = true;
};

const openDonateModal = () => {
    showDonateModal.value = true;
};

const closeLinktreeModal = () => {
    showLinktreeModal.value = false;
    editingLinkId.value = null;
    editLinkForm.reset();
    editLinkForm.clearErrors();
};

const closeDonateModal = () => {
    showDonateModal.value = false;
};

const createLink = () => {
    newLinkForm.redirect_to = profilePath.value;

    newLinkForm.post(route('links.store'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            newLinkForm.reset('title', 'url');
            newLinkForm.clearErrors();
        },
    });
};

const startEditLink = (link) => {
    editingLinkId.value = link.id;
    editLinkForm.title = link.title ?? '';
    editLinkForm.url = link.url ?? '';
    editLinkForm.clearErrors();
};

const cancelEditLink = () => {
    editingLinkId.value = null;
    editLinkForm.reset();
    editLinkForm.clearErrors();
};

const updateLink = (linkId) => {
    editLinkForm.redirect_to = profilePath.value;

    editLinkForm.put(route('links.update', linkId), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            cancelEditLink();
        },
    });
};

const removeLink = (linkId) => {
    if (!confirm('Quieres eliminar este link?')) {
        return;
    }

    deleteLinkForm.redirect_to = profilePath.value;

    deleteLinkForm.delete(route('links.destroy', linkId), {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="`Perfil de ${user.name}`" />

    <PublicLayout>
        <div class="py-8 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <aside class="lg:col-span-1">
                        <ProfileSidebar
                            :user="user"
                            @open-links="openLinktreeModal"
                        />
                    </aside>

                    <section class="space-y-4 lg:col-span-2">
                        <DonationsPanel
                            :donations="donations"
                            :can-donate="!isOwner"
                            @open-donate="openDonateModal"
                        />
                    </section>
                </div>
            </div>
        </div>

        <LinktreeModal
            :show="showLinktreeModal"
            :user="user"
            :links="links"
            :is-owner="isOwner"
            :editing-link-id="editingLinkId"
            :new-link-form="newLinkForm"
            :edit-link-form="editLinkForm"
            :delete-link-form="deleteLinkForm"
            @close="closeLinktreeModal"
            @create-link="createLink"
            @start-edit-link="startEditLink"
            @cancel-edit-link="cancelEditLink"
            @update-link="updateLink"
            @remove-link="removeLink"
        />

        <DonateLucasModal
            :show="showDonateModal"
            :profile-user="user"
            :is-authenticated="Boolean(authenticatedUser)"
            :authenticated-user="authenticatedUser"
            :is-owner="isOwner"
            @close="closeDonateModal"
        />
    </PublicLayout>
</template>
