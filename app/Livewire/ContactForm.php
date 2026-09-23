<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|string|max:120')]
    public string $name = '';

    #[Validate('required|email|max:150')]
    public string $email = '';

    #[Validate('required|string|max:180')]
    public string $subject = '';

    #[Validate('required|string|max:2000')]
    public string $message = '';

    public bool $sent = false;

    public function submit(): void
    {
        $this->validate();

        $this->reset('name', 'email', 'subject', 'message');
        $this->sent = true;
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
