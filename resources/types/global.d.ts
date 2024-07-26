export type ButtonVariant = 'numeric' | 'operator'

export interface CalculatorUpdateEvent {
  sign: string
  variant: ButtonVariant
}

export interface PaginatedData<T> {
  data: [T]

}
