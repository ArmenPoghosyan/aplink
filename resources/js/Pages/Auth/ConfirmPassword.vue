<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout
        title="Confirm your password"
        subtitle="This is a secure area of the application. Please confirm your password before continuing."
    >
        <Head title="Confirm Password" />

        <q-form class="q-gutter-y-md" @submit="submit">
            <q-input
                v-model="form.password"
                outlined
                type="password"
                label="Password"
                autocomplete="current-password"
                autofocus
                :error="!!form.errors.password"
                :error-message="form.errors.password"
            >
                <template #prepend><q-icon name="sym_r_lock" /></template>
            </q-input>

            <q-btn
                type="submit"
                color="primary"
                label="Confirm"
                size="lg"
                no-caps
                unelevated
                class="full-width"
                :loading="form.processing"
            />
        </q-form>
    </GuestLayout>
</template>
