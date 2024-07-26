import {computed, ref} from 'vue'
import {slice, filter, last} from 'lodash-es'
import axios from 'axios'
import type {CalculatorUpdateEvent} from '../types/global'

const operations = ref<[string] | []>([]) /// all the values we want to send to the API
const operation = ref<string>('') // the current operation
const postOperation = ref<boolean>(false) // this is toggled when the operation is on the next value
const currentInput = ref<string>('0.0')
// const expression = ref<string>('')
const latestEntry = computed(() => last(operations.value))

export function useCalculator() {
    const _reset = () => {
        console.log('reset')
        operation.value = ''
        currentInput.value = '0.0'
        operations.value = []
        postOperation.value = false
    }
    const _filter = () => filter(operations.value, (item: string) => item.length > 0)
    const _handleNumericInput = (calculatorEvent: CalculatorUpdateEvent): void => {
        _filter()
        if (calculatorEvent.sign === '.') {
            // Ensure only one decimal point per number
            const lastNumber = currentInput.value.split(/[+\-*/]/).pop()
            if (lastNumber.includes('.')) {
                return
            }
        }
        if (currentInput.value === '0.0') {
            // operations.value.push('(', '(')
            currentInput.value = calculatorEvent.sign
            return
        }

        if (postOperation.value) {
            currentInput.value = ''
        }
        currentInput.value += calculatorEvent.sign
    }
    const _handleOperatorInput = (calculatorEvent: CalculatorUpdateEvent) => {
        _appendOperation(currentInput.value)
        _filter()
        if (!operations.value.length) // dont allow operators without numberic value inputs
            return
        if (['C', 'c'].includes(calculatorEvent.sign)) {
            _reset()
            return
        }

        if (['='].includes(calculatorEvent.sign)) {
            _appendOperation(currentInput.value)
            operation.value = ''
            submit()
            return
        }

        _appendOperation(calculatorEvent.sign)

        operation.value = calculatorEvent.sign
        postOperation.value = true
    }
    const _appendOperation = (item: string): void => {
        operations.value.push(item)
    }

    const handleInput = (calculatorEvent: CalculatorUpdateEvent) => {
        calculatorEvent.variant === 'numeric'
            ? _handleNumericInput(calculatorEvent)
            : _handleOperatorInput(calculatorEvent)
    }
    const _formatExpression = (): string => {
        const arr = [...operations.value]
        if (arr.length < 3) {
            return ''
        }
        return `(${arr[0]} ${arr[1]} ${arr[2]})`
    }
    const submit = async () => {
        if (operations.value.length >= 3) {
            const {data} = await axios<App.Data.CalculationData>.post('/calculate', {
                calculation: _formatExpression(),
            })
            console.log(latestEntry.value, data.result)

            operations.value = [
                data.result,
                latestEntry.value
            ];

            currentInput.value = data.result

            return data
        }
    }
    return {

        handleInput,
        operations,
        operation,
        currentInput,
        postOperation,
        latestEntry, submit,
        expression: computed(() =>
            _formatExpression(),
        ),

    }
}
