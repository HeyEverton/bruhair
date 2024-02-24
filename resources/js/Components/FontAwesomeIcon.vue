<template>

     <font-awesome-icon :icon="`fas ${props.icon}`" />
</template>

<script setup lang="ts">
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
interface Props {
    icon: string;
}
const props = defineProps<Props>();
</script>
