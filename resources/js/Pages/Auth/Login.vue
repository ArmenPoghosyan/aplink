<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { link_to } from '@/composables/use_link';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const show_password = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout title="Welcome back" subtitle="Sign in to your account to continue.">
        <Head title="Log in" />

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

            <q-input
                v-model="form.password"
                outlined
                :type="show_password ? 'text' : 'password'"
                label="Password"
                autocomplete="current-password"
                :error="!!form.errors.password"
                :error-message="form.errors.password"
            >
                <template #prepend><q-icon name="sym_r_lock" /></template>
                <template #append>
                    <q-icon
                        :name="show_password ? 'sym_r_visibility_off' : 'sym_r_visibility'"
                        class="cursor-pointer"
                        @click="show_password = !show_password"
                    />
                </template>
            </q-input>

            <div class="row items-center justify-between">
                <q-checkbox v-model="form.remember" label="Remember me" dense />
                <q-btn
                    v-if="canResetPassword"
                    flat
                    dense
                    no-caps
                    color="primary"
                    label="Forgot password?"
                    v-bind="link_to(route('password.request'))"
                />
            </div>

            <q-btn
                type="submit"
                color="primary"
                label="Log in"
                size="lg"
                no-caps
                unelevated
                class="full-width"
                :loading="form.processing"
            />
        </q-form>

        <template #footer>
            <span class="text-muted">Don't have an account?</span>
            <q-btn flat dense no-caps color="primary" label="Create one" v-bind="link_to(route('register'))" />
        </template>
    </GuestLayout>
</template>
