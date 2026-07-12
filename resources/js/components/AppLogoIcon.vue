<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
defineOptions({
    inheritAttrs: false,
});
type Props = {
    className?: HTMLAttributes['class'];
};
defineProps<Props>();
</script>
<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        :class="className"
        v-bind="$attrs"
    >
        <!-- Golf ball outline -->
        <circle
            cx="12"
            cy="12"
            r="9"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
        />
        <!-- Dimples: organic scatter, clipped to the ball -->
        <clipPath id="ballClip">
            <circle cx="12" cy="12" r="8.4" />
        </clipPath>
        <g fill="currentColor" clip-path="url(#ballClip)">
            <circle cx="9.4" cy="6.6" r="0.85" />
            <circle cx="13.1" cy="6.2" r="0.7" />
            <circle cx="6.6" cy="8.6" r="0.7" />
            <circle cx="10.6" cy="8.4" r="0.9" />
            <circle cx="14.6" cy="8.1" r="0.8" />
            <circle cx="17.2" cy="9.6" r="0.7" />
            <circle cx="8.2" cy="10.9" r="0.75" />
            <circle cx="12.3" cy="11.3" r="0.9" />
            <circle cx="16" cy="11.5" r="0.75" />
            <circle cx="6.2" cy="12.8" r="0.7" />
            <circle cx="9.8" cy="13.7" r="0.8" />
            <circle cx="13.7" cy="13.9" r="0.9" />
            <circle cx="17.4" cy="13.4" r="0.7" />
            <circle cx="7.4" cy="16.1" r="0.75" />
            <circle cx="11.2" cy="16.7" r="0.85" />
            <circle cx="15" cy="16.6" r="0.75" />
            <circle cx="9.6" cy="18.7" r="0.7" />
            <circle cx="13.4" cy="18.6" r="0.7" />
        </g>
    </svg>
</template>
