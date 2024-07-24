<?php

namespace App\Services\Math;

final readonly class Math
{
    public function calculate(string $expression): float
    {
        $tokens = $this->tokenize(
            $this->sanitize($expression)
        );

        return number_format($this->evaluateRPN($this->infixToRPN($tokens)), 2);
    }

    public function sanitize(string $expression): string
    {
        return preg_replace('/\s+/', '', $expression);
    }

    public function tokenize(string $expression): array
    {
        // Regular expression to match numbers (including signed), operators, and parentheses
        $pattern = "/(\d+|(?<!\d)-\d+|[\+\-\*\/\(\)])/";

        // Use preg_match_all to tokenize the expression
        preg_match_all($pattern, $expression, $matches);

        return $matches[0];
    }

    public function infixToRPN(array $tokens): array
    {
        $output = [];
        $operators = new \SplStack();
        $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2];

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $output[] = $token;
            } elseif ($token === '(') {
                $operators->push($token);
            } elseif ($token === ')') {
                while (! $operators->isEmpty() && $operators->top() !== '(') {
                    $output[] = $operators->pop();
                }
                $operators->pop();
            } elseif (isset($precedence[$token])) {
                while (
                    ! $operators->isEmpty() &&
                    $operators->top() !== '(' &&
                    $precedence[$operators->top()] >= $precedence[$token]
                ) {
                    $output[] = $operators->pop();
                }
                $operators->push($token);
            }
        }

        while (! $operators->isEmpty()) {
            $output[] = $operators->pop();
        }

        return $output;
    }

    public function evaluateRPN(array $rpn): float
    {
        $stack = new \SplStack();

        foreach ($rpn as $token) {
            if (is_numeric($token)) {
                $stack->push((float) $token);
            } else {
                $b = $stack->pop();
                $a = $stack->pop();
                $stack->push(
                    match ($token) {
                        '+' => $a + $b,
                        '-' => $a - $b,
                        '*' => $a * $b,
                        '/' => $a / $b
                    }
                );
            }
        }

        return $stack->top();
    }
}
