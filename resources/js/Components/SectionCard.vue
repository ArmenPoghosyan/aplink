<script setup>
// Card with a title + description header, used for settings sections.
defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
    icon: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <q-card flat class="app-card">
        <q-card-section class="row items-start no-wrap q-gutter-x-md">
            <q-avatar v-if="icon" rounded color="primary" text-color="white" size="40px">
                <q-icon :name="icon" size="22px" />
            </q-avatar>
            <div>
                <div class="text-subtitle1 text-weight-bold">{{ title }}</div>
                <div v-if="description" class="text-body2 text-muted">{{ description }}</div>
            </div>
        </q-card-section>

        <q-card-section class="q-pt-none">
            <slot />
        </q-card-section>
    </q-card>
</template>
