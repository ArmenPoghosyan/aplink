<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import SectionCard from '@/Components/SectionCard.vue';

const $q = useQuasar();
const password_input = ref(null);
const current_password_input = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const update_password = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            $q.notify({ type: 'positive', message: 'Password updated.' });
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                password_input.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                current_password_input.value.focus();
            }
        },
    });
};
</script>

<template>
    <SectionCard
        title="Update password"
        description="Ensure your account is using a long, random password to stay secure."
        icon="sym_r_lock"
    >
        <q-form class="q-gutter-y-sm" @submit="update_password">
            <q-input
                ref="current_password_input"
                v-model="form.current_password"
                outlined
                type="password"
                label="Current password"
                autocomplete="current-password"
                :error="!!form.errors.current_password"
                :error-message="form.errors.current_password"
            />

            <q-input
                ref="password_input"
                v-model="form.password"
                outlined
                type="password"
                label="New password"
                autocomplete="new-password"
                :error="!!form.errors.password"
                :error-message="form.errors.password"
            />

            <q-input
                v-model="form.password_confirmation"
                outlined
                type="password"
                label="Confirm password"
                autocomplete="new-password"
                :error="!!form.errors.password_confirmation"
                :error-message="form.errors.password_confirmation"
            />

            <div>
                <q-btn type="submit" color="primary" unelevated no-caps label="Save" :loading="form.processing" />
            </div>
        </q-form>
    </SectionCard>
</template>
