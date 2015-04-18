<?php namespace Pantono\Contacts;

use Pantono\Contacts\Entity\Repository\ContactRepository;

class Contact
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function createContactFromData($data)
    {
        if (isset($data['id'])) {

        }
    }
}