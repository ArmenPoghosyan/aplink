<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

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
    <GuestLayout title="Authorize application">
        <Head title="Authorize Application" />

        <div class="row items-center no-wrap q-gutter-x-md q-mb-md">
            <q-avatar rounded color="primary" text-color="white" size="48px">
                {{ client.name.charAt(0).toUpperCase() }}
            </q-avatar>
            <div class="text-body2">
                <strong>{{ client.name }}</strong> is requesting permission to access your APLink account
                <span class="text-muted">({{ user.email }})</span>.
            </div>
        </div>

        <div v-if="scopes.length > 0">
            <div class="text-subtitle2 q-mb-xs">This application will be able to:</div>
            <q-list dense>
                <q-item v-for="scope in scopes" :key="scope.id" class="q-px-none">
                    <q-item-section avatar style="min-width: 32px">
                        <q-icon name="sym_r_check_circle" color="positive" />
                    </q-item-section>
                    <q-item-section>{{ scope.description }}</q-item-section>
                </q-item>
            </q-list>
        </div>

        <!--
            These are plain (non-Inertia) form submissions on purpose.
            Passport responds to approval/denial with a 302 redirect to the
            third-party client's own redirect_uri (an external origin), and
            that must be a full browser navigation. An Inertia/XHR request
            would follow the redirect internally and never navigate the
            browser away, so it must not be intercepted with JS here.
        -->
        <div class="row justify-end q-gutter-sm q-mt-lg">
            <form method="POST" action="/oauth/authorize">
                <input type="hidden" name="_token" :value="csrfToken" />
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="state" :value="state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />

                <q-btn type="submit" flat no-caps label="Cancel" />
            </form>

            <form method="POST" action="/oauth/authorize">
                <input type="hidden" name="_token" :value="csrfToken" />
                <input type="hidden" name="state" :value="state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />

                <q-btn type="submit" color="primary" unelevated no-caps label="Authorize" />
            </form>
        </div>
    </GuestLayout>
</template>
