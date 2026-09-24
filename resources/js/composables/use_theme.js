import { computed, ref } from 'vue';
import { Dark, LocalStorage } from 'quasar';

// Theme preference: 'light', 'dark' or 'auto' (follow the operating system).
const storage_key = 'aplink.theme';
const theme_options = [
    { value: 'light', label: 'Light', icon: 'sym_r_light_mode' },
    { value: 'dark', label: 'Dark', icon: 'sym_r_dark_mode' },
    { value: 'auto', label: 'System', icon: 'sym_r_contrast' },
];

const theme_mode = ref('auto');

function apply_theme(mode) {
    theme_mode.value = mode;
    Dark.set(mode === 'auto' ? 'auto' : mode === 'dark');
}

// Called once on boot to restore the saved preference.
export function init_theme() {
    const saved_mode = LocalStorage.getItem(storage_key);
    const is_valid = theme_options.some((option) => option.value === saved_mode);

    apply_theme(is_valid ? saved_mode : 'auto');
}

export function use_theme() {
    const current_option = computed(() =>
        theme_options.find((option) => option.value === theme_mode.value),
    );

    const set_theme = (mode) => {
        apply_theme(mode);
        LocalStorage.set(storage_key, mode);
    };

    return { theme_mode, theme_options, current_option, set_theme };
}
