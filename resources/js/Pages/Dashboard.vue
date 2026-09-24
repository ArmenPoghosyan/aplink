<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { link_to } from '@/composables/use_link';

const page = usePage();
const first_name = computed(() => page.props.auth.user.name.split(' ')[0]);

const quick_links = [
    {
        title: 'Profile',
        description: 'Update your name, email address and password.',
        icon: 'sym_r_person',
        url: route('profile.edit'),
    },
    {
        title: 'Connected apps',
        description: 'Review and revoke apps that sign in with your account.',
        icon: 'sym_r_apps',
        url: `${route('profile.edit')}#connected-applications`,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <q-card flat class="app-card app-glow q-mb-lg">
            <q-card-section class="q-pa-xl">
                <div class="text-overline text-primary">Dashboard</div>
                <div class="text-h4 text-weight-bold">Hi {{ first_name }}, you're logged in!</div>
                <div class="text-body1 text-muted q-mt-sm">
                    Your APLink account is ready. Use it to sign in to any connected application.
                </div>
            </q-card-section>
        </q-card>

        <div class="row q-col-gutter-lg">
            <div v-for="link in quick_links" :key="link.title" class="col-12 col-sm-6">
                <q-card flat class="app-card full-height">
                    <q-item clickable class="q-pa-lg" v-bind="link_to(link.url)">
                        <q-item-section avatar>
                            <q-avatar rounded color="primary" text-color="white">
                                <q-icon :name="link.icon" />
                            </q-avatar>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label class="text-subtitle1 text-weight-bold">{{ link.title }}</q-item-label>
                            <q-item-label caption>{{ link.description }}</q-item-label>
                        </q-item-section>
                        <q-item-section side>
                            <q-icon name="sym_r_arrow_forward" />
                        </q-item-section>
                    </q-item>
                </q-card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
