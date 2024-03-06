<script lang="ts">
import {computed, watch} from 'vue'
import {useCurrencyInput} from 'vue-currency-input'
import VTextField from 'vuetify'
export default {
    name: 'MoneyInput',
    props: {
        modelValue: Number,
        options: Object,
    },
    setup(props: any) {
        const {
            inputRef,
            formattedValue,
            numberValue,
            setValue,
        } = useCurrencyInput(props.options)

        const maxValue = props.options?.valueRange?.max ?? 0

        const errorMessage = computed(() =>
            numberValue.value <= maxValue ? `Valor máximo é de R$ ${maxValue}` : undefined,
        )

        watch(
            () => props.modelValue,
            value => {
                if (maxValue > 0 && value >= maxValue)
                    setValue(maxValue)
                else
                    setValue(value)
            },
        )

        return {
            inputRef,
            formattedValue,
            errorMessage,
        }
    },
}
</script>

<template>
    <VTextField
        ref="inputRef"
        v-model="formattedValue"
    />
</template>
