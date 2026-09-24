<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ConnectedApplications from './Partials/ConnectedApplications.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    connectedApplications: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout title="Profile" subtitle="Manage your account settings and connected applications.">
        <div class="max-width-lg q-gutter-y-lg">
            <UpdateProfileInformationForm :must_verify_email="mustVerifyEmail" :status="status" />
            <UpdatePasswordForm />
            <ConnectedApplications id="connected-applications" :connected_applications="connectedApplications" />
            <DeleteUserForm />
        </div>
    </AuthenticatedLayout>
</template>
