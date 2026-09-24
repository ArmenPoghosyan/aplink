<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout title="Reset password" subtitle="Choose a new, strong password for your account.">
        <Head title="Reset Password" />

        <q-form class="q-gutter-y-md" @submit="submit">
            <q-input
                v-model="form.email"
                outlined
                type="email"
                label="Email"
                autocomplete="username"
                :error="!!form.errors.email"
                :error-message="form.errors.email"
            >
                <template #prepend><q-icon name="sym_r_mail" /></template>
            </q-input>

            <q-input
                v-model="form.password"
                outlined
                type="password"
                label="New password"
                autocomplete="new-password"
                autofocus
                :error="!!form.errors.password"
                :error-message="form.errors.password"
            >
                <template #prepend><q-icon name="sym_r_lock" /></template>
            </q-input>

            <q-input
                v-model="form.password_confirmation"
                outlined
                type="password"
                label="Confirm password"
                autocomplete="new-password"
                :error="!!form.errors.password_confirmation"
                :error-message="form.errors.password_confirmation"
            >
                <template #prepend><q-icon name="sym_r_lock" /></template>
            </q-input>

            <q-btn
                type="submit"
                color="primary"
                label="Reset password"
                size="lg"
                no-caps
                unelevated
                class="full-width"
                :loading="form.processing"
            />
        </q-form>
    </GuestLayout>
</template>
