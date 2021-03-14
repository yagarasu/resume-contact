<?php
namespace App\Contact;

use App\Contact\ContactValidationException;

class ContactValidator {
  static public function validate(array $contact)
  {
    if (!isset($contact['name'])) {
      throw new ContactValidationException('Name is required');
    }
    if (!isset($contact['email'])) {
      throw new ContactValidationException('Email is required');
    }
    if (!isset($contact['message'])) {
      throw new ContactValidationException('Message is required');
    }
  }
}