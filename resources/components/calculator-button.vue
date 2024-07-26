<script setup lang="ts">
import { ref } from 'vue'
import type { ButtonVariant } from '../types/global'

const props = withDefaults(defineProps<{
  sign: string
  operator: string
  variant: ButtonVariant
}>(), {
  variant: 'numeric',
})
const emits = defineEmits(['update:calculator'])

const pressed = ref(false)
onKeyStroke(props.operator, (e) => {
  if (e.key === props.operator) {
    pressed.value = true
    setTimeout(() => pressed.value = false, 100)

    emits('update:calculator', { sign: props.operator, variant: props.variant })
  }
}, { target: document })
</script>

<template>
  <button
    class="w-full h-16 outline-none focus:outline-none hover:bg-indigo-700 hover:bg-opacity-20 text-white  text-xl font-light"
    :class="[
      pressed ? 'bg-indigo-900 opacity-80' : '',
      variant === 'numeric' ? 'bg-black/90  text-opacity-90' : 'bg-indigo-800 bg-opacity-20 text-opacity-80',
    ]"
    @click="$emit('update:calculator', { sign: operator, variant })"
  >
    {{ sign }}
  </button>
</template>
