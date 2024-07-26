<script setup lang="ts">
import { onMounted, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import CalculatorButton from '../components/calculator-button.vue'
import { useCalculator } from '../composables/use-calculator'
import type { PaginatedData } from '../types/global'

withDefaults(defineProps<{
  calculations: PaginatedData<App.Data.CalculationData>
}>(), {
  calculations: [{
    data: [],
  }],
})
const { handleInput, currentInput, operation, operations, submit } = useCalculator()

watch(operations.value, async (v) => {
  if (v.length >= 3) {
    await submit()
    loadCalculations()
  }
}, {

  deep: true,
})
function loadCalculations() {
  router.reload({ only: ['calculations'] })
}
function deleteCalculation(calculation: App.Data.CalculationDat) {
  router.delete(`/calculate/${calculation.id}`, {
    onSuccess: () => loadCalculations(),
  })
}

onMounted(() => router.reload({ only: ['calculations'] }))
</script>

<template>
  <div class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center px-5 py-5 space-x-3">
    <div class="w-full rounded-xl bg-gray-100 shadow-xl text-gray-800 relative overflow-hidden max-w-[350px]">
      <div class="w-full h-40 bg-gradient-to-b from-gray-800 to-gray-700 flex flex-col items-end text-right relative">
        <div class="w-full py-5 px-6 text-6xl text-white font-thin">
          {{ currentInput }}
        </div>
        <div class="w-full text-4xl text-white font-thin fixed-bottom text-left px-2 min-h-[10px]">
          {{ operation }}
        </div>
      </div>
      <div class="w-full bg-gradient-to-b from-indigo-400 to-indigo-500">
        <div class="flex w-full">
          <div class="w-1/4 border-r border-b border-indigo-900">
            <CalculatorButton operator="esc" sign="C" variant="operator" @update:calculator="handleInput" />
          </div>
          <div class="w-1/4 border-r border-b border-indigo-900">
            <CalculatorButton operator="+" sign="+" variant="operator" @update:calculator="handleInput" />
          </div>
          <div class="w-1/4 border-r border-b border-indigo-900">
            <CalculatorButton operator="-" sign="-" variant="operator" @update:calculator="handleInput" />
          </div>
          <div class="w-1/4 border-r border-b border-indigo-900">
            <CalculatorButton operator="*" sign="x" variant="operator" @update:calculator="handleInput" />
          </div>

          <div class="w-1/4 border-r border-b border-indigo-900">
            <CalculatorButton operator="/" sign="÷" variant="operator" @update:calculator="handleInput" />
          </div>
        </div>
        <div class="flex w-full">
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="7" sign="7" @update:calculator="handleInput" />
          </div>
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="8" sign="8" @update:calculator="handleInput" />
          </div>
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="9" sign="9" @update:calculator="handleInput" />
          </div>
        </div>
        <div class="flex w-full">
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="4" sign="4" @update:calculator="handleInput" />
          </div>
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="5" sign="5" @update:calculator="handleInput" />
          </div>
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="6" sign="6" @update:calculator="handleInput" />
          </div>
        </div>
        <div class="flex w-full">
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="1" sign="1" @update:calculator="handleInput" />
          </div>
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="2" sign="2" @update:calculator="handleInput" />
          </div>
          <div class="w-1/3 border-r border-b border-indigo-900">
            <CalculatorButton operator="3" sign="3" @update:calculator="handleInput" />
          </div>
        </div>
        <div class="flex w-full">
          <div class="w-1/3 border-r border-indigo-900">
            <CalculatorButton operator="0" sign="0" @update:calculator="handleInput" />
          </div>
          <div class="w-1/3 border-r border-indigo-900">
            <CalculatorButton operator="." sign="." @update:calculator="handleInput" />
          </div>
          <div class="w-2/4 border-r border-indigo-900">
            <CalculatorButton operator="=" sign="=" variant="operator" @update:calculator="handleInput" />
          </div>
        </div>
      </div>
    </div>
    <div class="w-full max-w-sm bg-black">
      <ul role="list" class="mt-3 grid grid-cols-1">
        <li v-for="calculation in calculations.data" :key="calculation.id" class="col-span-1 flex rounded-md shadow-sm">
          <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
            <div class="flex-1 truncate px-4 py-2 text-sm">
              <a href="#" class="font-medium text-gray-900 hover:text-gray-600">{{ calculation.expression }}</a>
              <p class="text-gray-500">
                {{ calculation.result }}
              </p>
            </div>
            <div class="flex-shrink-0 pr-2">
              <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="deleteCalculation(calculation)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                  <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
