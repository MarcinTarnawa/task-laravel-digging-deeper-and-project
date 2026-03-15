<?php

namespace Tests\Feature;

use App\Mail\InvoicePdfMail;
use App\Models\CustomerData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_pdfCreator_page(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pdf');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_pdfCreator_page(): void
    {
        $response = $this->get('/pdf');

        $response->assertRedirect('/login');
    }
      public function test_sending_email(): void
    {
        Mail::fake();

        $customerData = new CustomerData();
        Mail::to('6VY5c@example.com')->send(new InvoicePdfMail($customerData));

        Mail::assertSent(InvoicePdfMail::class, function ($mail) {
        return $mail->hasTo('6VY5c@example.com');
        });
    }
}