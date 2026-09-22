<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    connectedApplications: Array,
});

const revoke = (tokenId) => {
    if (confirm('Revoke this application\'s access to your account?')) {
        router.delete(route('connected-applications.destroy', tokenId), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Connected Applications
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                These are the third-party services you've authorized to sign
                in with your APLink account. Revoke access for any
                application you no longer use or recognize.
            </p>
        </header>

        <p
            v-if="connectedApplications.length === 0"
            class="text-sm text-gray-500"
        >
            You haven't connected any third-party applications yet.
        </p>

        <ul v-else class="divide-y divide-gray-200 rounded-md border border-gray-200">
            <li
                v-for="app in connectedApplications"
                :key="app.token_id"
                class="flex items-center justify-between gap-4 px-4 py-3"
            >
                <div>
                    <div class="text-sm font-medium text-gray-900">
                        {{ app.client_name }}
                    </div>
                    <div
                        v-if="app.scopes.length"
                        class="text-xs text-gray-500"
                    >
                        Scopes: {{ app.scopes.join(', ') }}
                    </div>
                </div>

                <DangerButton @click="revoke(app.token_id)">
                    Revoke
                </DangerButton>
            </li>
        </ul>
    </section>
</template>
