<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    client: Object,
    user: Object,
    scopes: Array,
    authToken: String,
    state: String,
});

const approveForm = useForm({
    state: props.state,
    client_id: props.client.id,
    auth_token: props.authToken,
});

const denyForm = useForm({
    state: props.state,
    client_id: props.client.id,
    auth_token: props.authToken,
});

const approve = () => approveForm.post('/oauth/authorize');
const deny = () => denyForm.delete('/oauth/authorize');
</script>

<template>
    <GuestLayout>
        <Head title="Authorize Application" />

        <div class="mb-4 text-sm text-gray-600">
            <strong>{{ client.name }}</strong> is requesting permission to
            access your APLink account (<strong>{{ user.email }}</strong>).
        </div>

        <div v-if="scopes.length > 0" class="mb-4">
            <p class="mb-2 text-sm font-medium text-gray-700">
                This application will be able to:
            </p>
            <ul class="list-inside list-disc space-y-1 text-sm text-gray-600">
                <li v-for="scope in scopes" :key="scope.id">
                    {{ scope.description }}
                </li>
            </ul>
        </div>

        <div class="mt-4 flex justify-end gap-3">
            <form @submit.prevent="deny">
                <SecondaryButton :disabled="denyForm.processing">
                    Cancel
                </SecondaryButton>
            </form>

            <form @submit.prevent="approve">
                <PrimaryButton :disabled="approveForm.processing">
                    Authorize
                </PrimaryButton>
            </form>
        </div>
    </GuestLayout>
</template>
