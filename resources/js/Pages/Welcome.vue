<script setup>
import { Head } from '@inertiajs/vue3';
import AppLogo from '@/Components/AppLogo.vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import { link_to } from '@/composables/use_link';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const features = [
    {
        title: 'Single sign-on',
        description: 'One APLink account signs you in to every connected application.',
        icon: 'sym_r_key',
    },
    {
        title: 'Secure by default',
        description: 'Industry-standard OAuth 2.0 keeps your password with us, never with third parties.',
        icon: 'sym_r_shield_lock',
    },
    {
        title: 'You stay in control',
        description: 'See which apps can access your account and revoke them at any time.',
        icon: 'sym_r_tune',
    },
];
</script>

<template>
    <Head title="Welcome" />

    <q-layout view="hHh lpR fFf">
        <q-header class="app-header">
            <q-toolbar class="max-width-xl q-mx-auto q-px-md" style="min-height: 64px">
                <AppLogo height="36px" />
                <q-space />
                <ThemeToggle />

                <template v-if="canLogin">
                    <q-btn
                        v-if="$page.props.auth.user"
                        color="primary"
                        unelevated
                        no-caps
                        label="Dashboard"
                        class="q-ml-sm"
                        v-bind="link_to(route('dashboard'))"
                    />
                    <template v-else>
                        <q-btn flat no-caps label="Log in" class="q-ml-sm" v-bind="link_to(route('login'))" />
                        <q-btn
                            v-if="canRegister"
                            color="primary"
                            unelevated
                            no-caps
                            label="Get started"
                            class="q-ml-sm gt-xs"
                            v-bind="link_to(route('register'))"
                        />
                    </template>
                </template>
            </q-toolbar>
        </q-header>

        <q-page-container>
            <q-page class="app-glow">
                <section class="max-width-xl q-mx-auto q-px-md text-center" style="padding-top: 12vh; padding-bottom: 10vh">
                    <q-chip outline color="primary" icon="sym_r_bolt" label="OAuth 2.0 identity provider" />

                    <h1 class="hero-title text-weight-bolder q-mt-md q-mb-md">
                        One account.<br />
                        <span class="text-gradient">Every app.</span>
                    </h1>

                    <p class="text-h6 text-weight-regular text-muted q-mx-auto" style="max-width: 620px">
                        APLink lets you sign in to all your favourite services securely, with a single account you fully control.
                    </p>

                    <div v-if="canLogin && !$page.props.auth.user" class="row justify-center q-gutter-md q-mt-lg">
                        <q-btn
                            v-if="canRegister"
                            color="primary"
                            unelevated
                            no-caps
                            size="lg"
                            label="Create free account"
                            icon-right="sym_r_arrow_forward"
                            v-bind="link_to(route('register'))"
                        />
                        <q-btn outline no-caps size="lg" label="Log in" v-bind="link_to(route('login'))" />
                    </div>
                </section>

                <section class="max-width-xl q-mx-auto q-px-md q-pb-xl">
                    <div class="row q-col-gutter-lg">
                        <div v-for="feature in features" :key="feature.title" class="col-12 col-md-4">
                            <q-card flat class="app-card full-height">
                                <q-card-section class="q-pa-lg">
                                    <q-avatar rounded color="primary" text-color="white" size="44px">
                                        <q-icon :name="feature.icon" size="24px" />
                                    </q-avatar>
                                    <div class="text-h6 text-weight-bold q-mt-md">{{ feature.title }}</div>
                                    <div class="text-body2 text-muted q-mt-xs">{{ feature.description }}</div>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                </section>

                <footer class="text-center text-caption text-muted q-py-lg">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </q-page>
        </q-page-container>
    </q-layout>
</template>
