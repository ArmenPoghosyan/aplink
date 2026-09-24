<script setup>
import { use_theme } from '@/composables/use_theme';

const { theme_mode, theme_options, current_option, set_theme } = use_theme();
</script>

<template>
    <q-btn flat round :icon="current_option.icon" aria-label="Change theme">
        <q-tooltip>Theme: {{ current_option.label }}</q-tooltip>

        <q-menu anchor="bottom right" self="top right" :offset="[0, 8]">
            <q-list style="min-width: 160px">
                <q-item
                    v-for="option in theme_options"
                    :key="option.value"
                    v-close-popup
                    clickable
                    :active="theme_mode === option.value"
                    active-class="text-primary"
                    @click="set_theme(option.value)"
                >
                    <q-item-section avatar>
                        <q-icon :name="option.icon" />
                    </q-item-section>
                    <q-item-section>{{ option.label }}</q-item-section>
                    <q-item-section v-if="theme_mode === option.value" side>
                        <q-icon name="sym_r_check" color="primary" />
                    </q-item-section>
                </q-item>
            </q-list>
        </q-menu>
    </q-btn>
</template>
