<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { link_to } from '@/composables/use_link';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout
        title="Forgot your password?"
        subtitle="Enter your email and we'll send you a link to choose a new one."
    >
        <Head title="Forgot Password" />

        <q-banner v-if="status" rounded class="bg-positive text-white q-mb-md">
            {{ status }}
        </q-banner>

        <q-form class="q-gutter-y-md" @submit="submit">
            <q-input
                v-model="form.email"
                outlined
                type="email"
                label="Email"
                autocomplete="username"
                autofocus
                :error="!!form.errors.email"
                :error-message="form.errors.email"
            >
                <template #prepend><q-icon name="sym_r_mail" /></template>
            </q-input>

            <q-btn
                type="submit"
                color="primary"
                label="Email password reset link"
                size="lg"
                no-caps
                unelevated
                class="full-width"
                :loading="form.processing"
            />
        </q-form>

        <template #footer>
            <q-btn flat dense no-caps color="primary" icon="sym_r_arrow_back" label="Back to log in" v-bind="link_to(route('login'))" />
        </template>
    </GuestLayout>
</template>
