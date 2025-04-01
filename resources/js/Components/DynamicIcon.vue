<script setup>
import {computed} from 'vue';

const props = defineProps({
    icon: {
        type: String,
        required: true,
        validator: v => ['fas-', 'far-', 'fab-'].some(p => v.startsWith(p))
    },
    size: {
        type: String,
        default: 'md'
    }
});

const iconParts = computed(() => {
    const [prefix, ...name] = props.icon.split('-');
    return [prefix, name.join('-')];
});

const sizeClass = computed(() => ({
    'text-xs': props.size === 'xs',
    'text-sm': props.size === 'sm',
    'text-base': props.size === 'md',
    'text-lg': props.size === 'lg',
    'text-xl': props.size === 'xl'
}));
</script>

<template>
    <font-awesome-icon
        :icon="iconParts"
        :class="sizeClass"
        v-if="iconParts"
    />
</template>
