<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMailable;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $successMessage;

    protected $rules=[
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'message' => 'required|min:5',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        $contact = $this->validate();

        $contact['name'] = $this->name;
        $contact['email'] = $this->email;
        $contact['phone'] = $this->phone;
        $contact['message'] = $this->message;

        sleep(1);
        Mail::to('tamo.gagniashvili@gmail.com')->send(new ContactFormMailable($contact));
            
        $this->successMessage = 'We received your message successfully and will get back to you shortly!';

        $this->resetForm();

    // session()->flash('success_message', 'We received your message successfully and will get back to you shortly!');
    
    // return back()->with('success_message', 'We received your message successfully and will get back to you shortly!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
