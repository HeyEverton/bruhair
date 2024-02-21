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
    variant?: string;
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
    <VBtn v-else v-bind="{ ...$attrs }">
        <FontAwesomeIcon icon="fas fa-user" />
        <!-- <i :icon="props.icon" /> -->
        {{ buttonText ?? "Clique" }}
    </VBtn>
</template>
