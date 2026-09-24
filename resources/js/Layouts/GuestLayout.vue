<script setup>
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
</script>

<template>
    <q-layout view="hHh lpR fFf">
        <q-page-container>
            <q-page class="app-glow column items-center justify-center q-pa-md">
                <div class="absolute-top-right q-pa-md">
                    <ThemeToggle />
                </div>

                <a v-bind="link_to('/')" class="q-mb-lg" style="text-decoration: none; color: inherit">
                    <AppLogo height="56px" />
                </a>

                <q-card flat class="app-card max-width-sm">
                    <q-card-section v-if="title" class="q-pb-none q-pt-lg q-px-lg">
                        <div class="text-h5 text-weight-bold">{{ title }}</div>
                        <div v-if="subtitle" class="text-body2 text-muted q-mt-xs">{{ subtitle }}</div>
                    </q-card-section>

                    <q-card-section class="q-pa-lg">
                        <slot />
                    </q-card-section>
                </q-card>

                <div v-if="$slots.footer" class="q-mt-lg text-body2">
                    <slot name="footer" />
                </div>
            </q-page>
        </q-page-container>
    </q-layout>
</template>
