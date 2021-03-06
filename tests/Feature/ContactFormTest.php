<?php

namespace Tests\Feature;

use App\Http\Livewire\ContactForm;
use App\Mail\ContactFormMailable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function main_page_contains_contact_form_livewire_component()
    {
        $this->get('/')
            ->assertSeeLivewire('contact-form');
    }


    /** @test */
    public function contact_form_sends_out_an_email()
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'Andre')
            ->set('email', 'some@guy.com')
            ->set('phone', '123456789')
            ->set('message', 'This is my message.')
            ->call('submitForm')
            ->assertSee('We received your message successfully and will get back to you shortly!');

        Mail::assertSent(function(ContactFormMailable $mail){
            $mail->build();

            return $mail->hasTo('tamo.gagniashvili@gmail.com') &&
                $mail->hasFrom('some@guy.com') &&
                $mail->subject === 'Contact Form Submission';
        });
    }

    /** @test */
    public function contact_form_name_field_is_required()
    {
        Livewire::test(ContactForm::class)
            ->set('email', 'some@guy.com')
            ->set('phone', '123456789')
            ->set('message', 'This is my message.')
            ->call('submitForm')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function contact_form_message_field_is_has_minimum_characters()
    {
        Livewire::test(ContactForm::class)
            ->set('message', 'abc')
            ->call('submitForm')
            ->assertHasErrors(['message' => 'min']);
    }
}
