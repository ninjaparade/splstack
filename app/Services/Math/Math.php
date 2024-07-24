<?php

namespace App\Services\Math;

final readonly class Math
{
    public function calculate(string $expression): float
    {
        $tokens = $this->tokenize($expression);

        return number_format($this->evaluateRPN($this->infixToRPN($tokens)), 2);
    }

    public function tokenize(string $expression): array
    {
        return preg_split(
            "/([\+\-\*\/\(\)])/",
            preg_replace("/\s+/", '', $expression),
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
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
