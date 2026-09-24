<script setup>
import { router, useForm, usePage } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import SectionCard from '@/Components/SectionCard.vue';

defineProps({
    must_verify_email: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const $q = useQuasar();
const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const save_profile = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => $q.notify({ type: 'positive', message: 'Profile saved.' }),
    });
};

const resend_verification = () => {
    router.post(route('verification.send'), {}, { preserveScroll: true });
};
</script>

<template>
    <SectionCard
        title="Profile information"
        description="Update your account's profile information and email address."
        icon="sym_r_person"
    >
        <q-form class="q-gutter-y-sm" @submit="save_profile">
            <q-input
                v-model="form.name"
                outlined
                label="Name"
                autocomplete="name"
                :error="!!form.errors.name"
                :error-message="form.errors.name"
            />

            <q-input
                v-model="form.email"
                outlined
                type="email"
                label="Email"
                autocomplete="username"
                :error="!!form.errors.email"
                :error-message="form.errors.email"
            />

            <q-banner v-if="must_verify_email && user.email_verified_at === null" rounded class="bg-warning text-dark">
                <template #avatar><q-icon name="sym_r_warning" /></template>
                Your email address is unverified.
                <template #action>
                    <q-btn flat no-caps label="Re-send verification email" @click="resend_verification" />
                </template>
            </q-banner>

            <q-banner v-if="status === 'verification-link-sent'" rounded class="bg-positive text-white">
                A new verification link has been sent to your email address.
            </q-banner>

            <div>
                <q-btn type="submit" color="primary" unelevated no-caps label="Save" :loading="form.processing" />
            </div>
        </q-form>
    </SectionCard>
</template>
