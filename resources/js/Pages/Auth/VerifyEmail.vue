<script setup>
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const log_out = () => router.post(route('logout'));

const verification_link_sent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout title="Verify your email">
        <Head title="Email Verification" />

        <div class="text-body2 text-muted q-mb-md">
            Thanks for signing up! Before getting started, please verify your email address by clicking
            the link we just emailed to you. If you didn't receive the email, we'll gladly send you another.
        </div>

        <q-banner v-if="verification_link_sent" rounded class="bg-positive text-white q-mb-md">
            A new verification link has been sent to the email address you provided during registration.
        </q-banner>

        <q-form @submit="submit">
            <div class="row items-center justify-between q-gutter-y-sm">
                <q-btn
                    type="submit"
                    color="primary"
                    label="Resend verification email"
                    no-caps
                    unelevated
                    :loading="form.processing"
                />
                <q-btn flat no-caps label="Log out" @click="log_out" />
            </div>
        </q-form>
    </GuestLayout>
</template>
