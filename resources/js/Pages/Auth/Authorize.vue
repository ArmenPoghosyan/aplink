<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    client: Object,
    user: Object,
    scopes: Array,
    authToken: String,
    state: String,
    csrfToken: String,
});
</script>

<template>
    <GuestLayout>
        <Head title="Authorize Application" />

        <div class="mb-4 text-sm text-gray-600">
            <strong>{{ client.name }}</strong> is requesting permission to
            access your APLink account (<strong>{{ user.email }}</strong>).
        </div>

        <div v-if="scopes.length > 0" class="mb-4">
            <p class="mb-2 text-sm font-medium text-gray-700">
                This application will be able to:
            </p>
            <ul class="list-inside list-disc space-y-1 text-sm text-gray-600">
                <li v-for="scope in scopes" :key="scope.id">
                    {{ scope.description }}
                </li>
            </ul>
        </div>

        <!--
            These are plain (non-Inertia) form submissions on purpose.
            Passport responds to approval/denial with a 302 redirect to the
            third-party client's own redirect_uri (an external origin), and
            that must be a full browser navigation. An Inertia/XHR request
            would follow the redirect internally and never navigate the
            browser away, so it must not be intercepted with JS here.
        -->
        <div class="mt-4 flex justify-end gap-3">
            <form method="POST" action="/oauth/authorize">
                <input type="hidden" name="_token" :value="csrfToken" />
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="state" :value="state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />

                <SecondaryButton type="submit">Cancel</SecondaryButton>
            </form>

            <form method="POST" action="/oauth/authorize">
                <input type="hidden" name="_token" :value="csrfToken" />
                <input type="hidden" name="state" :value="state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />

                <PrimaryButton type="submit">Authorize</PrimaryButton>
            </form>
        </div>
    </GuestLayout>
</template>
