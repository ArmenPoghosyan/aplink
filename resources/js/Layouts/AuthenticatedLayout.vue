<script setup>
import { computed, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AppLogo from '@/Components/AppLogo.vue';
import ThemeToggle from '@/Components/ThemeToggle.vue';
import { link_to } from '@/composables/use_link';

defineProps({
    title: {
        type: String,
        default: '',
    },
    subtitle: {
        type: String,
        default: '',
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user);
const user_initial = computed(() => user.value.name.charAt(0).toUpperCase());

const drawer_open = ref(false);

const nav_items = [
    { label: 'Dashboard', icon: 'sym_r_space_dashboard', route_name: 'dashboard' },
    { label: 'Profile', icon: 'sym_r_person', route_name: 'profile.edit' },
];

const log_out = () => router.post(route('logout'));
</script>

<template>
    <q-layout view="hHh lpR fFf">
        <q-header class="app-header">
            <q-toolbar class="max-width-xl q-mx-auto q-px-md" style="min-height: 64px">
                <q-btn
                    flat
                    round
                    icon="sym_r_menu"
                    class="lt-sm q-mr-sm"
                    aria-label="Open menu"
                    @click="drawer_open = !drawer_open"
                />

                <a v-bind="link_to(route('dashboard'))" style="text-decoration: none; color: inherit">
                    <AppLogo height="36px" />
                </a>

                <q-tabs
                    shrink
                    no-caps
                    inline-label
                    indicator-color="primary"
                    active-color="primary"
                    class="gt-xs q-ml-xl"
                    :model-value="route().current()"
                >
                    <q-tab
                        v-for="item in nav_items"
                        :key="item.route_name"
                        :name="item.route_name"
                        :icon="item.icon"
                        :label="item.label"
                        @click="router.visit(route(item.route_name))"
                    />
                </q-tabs>

                <q-space />

                <ThemeToggle />

                <q-btn flat no-caps class="q-ml-sm q-px-sm">
                    <q-avatar size="32px" color="primary" text-color="white">{{ user_initial }}</q-avatar>
                    <span class="gt-xs q-ml-sm">{{ user.name }}</span>
                    <q-icon name="sym_r_expand_more" size="20px" class="q-ml-xs" />

                    <q-menu anchor="bottom right" self="top right" :offset="[0, 8]">
                        <q-list style="min-width: 220px">
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-weight-medium">{{ user.name }}</q-item-label>
                                    <q-item-label caption>{{ user.email }}</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-separator />
                            <q-item v-close-popup clickable v-bind="link_to(route('profile.edit'))">
                                <q-item-section avatar><q-icon name="sym_r_person" /></q-item-section>
                                <q-item-section>Profile</q-item-section>
                            </q-item>
                            <q-item v-close-popup clickable @click="log_out">
                                <q-item-section avatar><q-icon name="sym_r_logout" /></q-item-section>
                                <q-item-section>Log out</q-item-section>
                            </q-item>
                        </q-list>
                    </q-menu>
                </q-btn>
            </q-toolbar>
        </q-header>

        <!-- Mobile navigation -->
        <q-drawer v-model="drawer_open" overlay behavior="mobile" :width="260">
            <div class="q-pa-md">
                <AppLogo height="36px" />
            </div>
            <q-list padding>
                <q-item
                    v-for="item in nav_items"
                    :key="item.route_name"
                    clickable
                    :active="route().current(item.route_name)"
                    active-class="text-primary"
                    v-bind="link_to(route(item.route_name))"
                >
                    <q-item-section avatar><q-icon :name="item.icon" /></q-item-section>
                    <q-item-section>{{ item.label }}</q-item-section>
                </q-item>
                <q-separator spaced />
                <q-item clickable @click="log_out">
                    <q-item-section avatar><q-icon name="sym_r_logout" /></q-item-section>
                    <q-item-section>Log out</q-item-section>
                </q-item>
            </q-list>
        </q-drawer>

        <q-page-container>
            <q-page class="q-px-md q-py-xl">
                <div class="max-width-xl q-mx-auto">
                    <div v-if="title" class="q-mb-lg">
                        <div class="text-h4 text-weight-bold">{{ title }}</div>
                        <div v-if="subtitle" class="text-body1 text-muted q-mt-xs">{{ subtitle }}</div>
                    </div>

                    <slot />
                </div>
            </q-page>
        </q-page-container>
    </q-layout>
</template>
