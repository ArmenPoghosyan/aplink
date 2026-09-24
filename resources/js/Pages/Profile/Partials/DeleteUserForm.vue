<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import SectionCard from '@/Components/SectionCard.vue';

const confirming_deletion = ref(false);
const password_input = ref(null);

const form = useForm({
    password: '',
});

const delete_user = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => close_dialog(),
        onError: () => password_input.value.focus(),
        onFinish: () => form.reset(),
    });
};

const close_dialog = () => {
    confirming_deletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <SectionCard
        title="Delete account"
        description="Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain."
        icon="sym_r_delete"
    >
        <q-btn color="negative" unelevated no-caps label="Delete account" @click="confirming_deletion = true" />

        <q-dialog v-model="confirming_deletion" @hide="close_dialog">
            <q-card class="app-card" style="width: 100%; max-width: 520px">
                <q-card-section>
                    <div class="text-h6 text-weight-bold">Are you sure you want to delete your account?</div>
                    <div class="text-body2 text-muted q-mt-sm">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                        Please enter your password to confirm you would like to permanently delete your account.
                    </div>
                </q-card-section>

                <q-card-section class="q-pt-none">
                    <q-input
                        ref="password_input"
                        v-model="form.password"
                        outlined
                        autofocus
                        type="password"
                        label="Password"
                        :error="!!form.errors.password"
                        :error-message="form.errors.password"
                        @keyup.enter="delete_user"
                    />
                </q-card-section>

                <q-card-actions align="right" class="q-px-md q-pb-md">
                    <q-btn flat no-caps label="Cancel" @click="close_dialog" />
                    <q-btn
                        color="negative"
                        unelevated
                        no-caps
                        label="Delete account"
                        :loading="form.processing"
                        @click="delete_user"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </SectionCard>
</template>
