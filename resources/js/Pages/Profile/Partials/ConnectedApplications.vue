<script setup>
import { router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import SectionCard from '@/Components/SectionCard.vue';

defineProps({
    connected_applications: {
        type: Array,
        default: () => [],
    },
});

const $q = useQuasar();

const revoke_access = (app) => {
    $q.dialog({
        title: 'Revoke access',
        message: `Revoke ${app.client_name}'s access to your account?`,
        cancel: { flat: true, noCaps: true },
        ok: { label: 'Revoke', color: 'negative', unelevated: true, noCaps: true },
        persistent: true,
    }).onOk(() => {
        router.delete(route('connected-applications.destroy', app.token_id), {
            preserveScroll: true,
            onSuccess: () => $q.notify({ type: 'positive', message: `${app.client_name} access revoked.` }),
        });
    });
};
</script>

<template>
    <SectionCard
        title="Connected applications"
        description="Third-party services you've authorized to sign in with your APLink account. Revoke access for any application you no longer use or recognize."
        icon="sym_r_apps"
    >
        <div v-if="connected_applications.length === 0" class="text-center q-py-lg text-muted">
            <q-icon name="sym_r_link_off" size="40px" />
            <div class="q-mt-sm">You haven't connected any third-party applications yet.</div>
        </div>

        <q-list v-else bordered separator class="rounded-borders">
            <q-item v-for="app in connected_applications" :key="app.token_id" class="q-py-md">
                <q-item-section avatar>
                    <q-avatar rounded color="primary" text-color="white">
                        {{ app.client_name.charAt(0).toUpperCase() }}
                    </q-avatar>
                </q-item-section>
                <q-item-section>
                    <q-item-label class="text-weight-medium">{{ app.client_name }}</q-item-label>
                    <q-item-label v-if="app.scopes.length" caption>
                        Scopes: {{ app.scopes.join(', ') }}
                    </q-item-label>
                </q-item-section>
                <q-item-section side>
                    <q-btn outline color="negative" no-caps label="Revoke" @click="revoke_access(app)" />
                </q-item-section>
            </q-item>
        </q-list>
    </SectionCard>
</template>
