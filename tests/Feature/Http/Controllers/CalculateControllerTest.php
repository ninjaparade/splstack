<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class CalculateControllerTest extends TestCase
{
    public function test_can_get_calculations_for_addition()
    {
        $response = $this->postJson(route('calculate'), [
            'calculation' => '(5+5)',
        ]);

        $response->assertSuccessful();

        $this->assertSame(10, $response->json('result'));
    }

    public function test_can_get_calculations_for_complex_addition()
    {
        $response = $this->postJson(route('calculate'), [
            'calculation' => '((5+5) * 2)',
        ]);

        $response->assertSuccessful();

        $this->assertSame(20, $response->json('result'));
    }

    public function test_can_get_multiple_calculations_for_addition()
    {
        $response = $this->postJson(route('calculate'), [
            'calculation' => '((5+5)+(5+5))',
        ]);

        $this->assertSame(20, $response->json('result'));
    }

    public function test_can_get_multiple_calculations_for_addition_with_extra_whitespace()
    {
        //prepareForValidation will fix this to ensure validation passes
        $response = $this->postJson(route('calculate'), [
            'calculation' => '(   (5+    5  )   +  ( 5 +     5    ))',
        ]);

        $this->assertSame(20, $response->json('result'));
    }

    public function test_can_get_calculations_for_subtraction()
    {
        $response = $this->postJson(route('calculate'), [
            'calculation' => '(5-5)',
        ]);

        $this->assertSame(0, $response->json('result'));
    }

    public function test_can_get_calculations_for_subtraction_for_multiple_calculations()
    {
        $response = $this->postJson(route('calculate'), [
            'calculation' => '((10-5) - 5)',
        ]);

        $this->assertSame(0, $response->json('result'));
    }

    public function test_can_get_calculations_for_subtraction_for_multiple_calculations_can_return_negative_value()
    {
        $response = $this->postJson(route('calculate'), [
            'calculation' => '((5-10) - 5)',
        ]);

        $this->assertSame(-10, $response->json('result'));
    }

    public function test_can_get_calculations_for_subtraction_for_multiple_calculations_grouped_into_several_operations()
    {
        $response = $this->postJson(route('calculate'), [
            'calculation' => '((5-10) - 5) + ((5-10) - 5)',
        ]);

        $this->assertSame(-20, $response->json('result'));
        $response = $this->postJson(route('calculate'), [
            'calculation' => '((5-10) - 5) - ((5-10) - 5)',
        ]);

        $this->assertSame(0, $response->json('result'));
    }
}
