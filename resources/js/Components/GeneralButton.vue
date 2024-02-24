<script lang="ts" setup>
import FontAwesomeIcon from "./FontAwesomeIcon.vue";

interface Props {
    badge?: boolean;
    badgeContent?: number | string;
    icon?: string;
    color?: string;
    size?: string;
    disabled?: boolean;
    loading?: boolean;
    variant?: "flat" | "text" | "elevated" | "tonal" | "outlined" | "plain";
    type?: string;
    buttonText?: string;
}

const props = defineProps<Props>();
</script>
<template>
    <VBadge v-if="badge" color="primary" size="12px" :content="badgeContent">
        <VBtn
            :color="props.color"
            :disabled="props.disabled"
            :loading="props.loading"
            :size="props.size"
        >
            <i :icon="props.icon" />
            {{ buttonText ?? "Clique" }}
        </VBtn>
    </VBadge>
    <VBtn
        v-else
        :color="props.color"
        :disabled="props.disabled"
        :loading="props.loading"
        :size="props.size"
        :variant="props.variant || 'flat'"
    >
        <FontAwesomeIcon
            v-if="props.icon"
            :icon="props.icon"
            :class="props.icon && props.buttonText ? 'mr-2' : ''"
        />
        {{ buttonText ?? "" }}
    </VBtn>
</template>
