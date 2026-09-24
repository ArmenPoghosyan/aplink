<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { link_to } from '@/composables/use_link';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout title="Create your account" subtitle="One account for every connected app.">
        <Head title="Register" />

        <q-form class="q-gutter-y-md" @submit="submit">
            <q-input
                v-model="form.name"
                outlined
                label="Name"
                autocomplete="name"
                autofocus
                :error="!!form.errors.name"
                :error-message="form.errors.name"
            >
                <template #prepend><q-icon name="sym_r_badge" /></template>
            </q-input>

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
                label="Password"
                autocomplete="new-password"
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
                label="Create account"
                size="lg"
                no-caps
                unelevated
                class="full-width"
                :loading="form.processing"
            />
        </q-form>

        <template #footer>
            <span class="text-muted">Already registered?</span>
            <q-btn flat dense no-caps color="primary" label="Log in" v-bind="link_to(route('login'))" />
        </template>
    </GuestLayout>
</template>
