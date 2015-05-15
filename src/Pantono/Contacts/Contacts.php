<?php namespace Pantono\Contacts;

use Pantono\Contacts\Entity\Repository\ContactRepository;

class Contacts
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getSingleContact($id)
    {
        return $this->getContactRepository()->find($id);
    }

    /**
     * @return ContactRepository
     */
    private function getContactRepository()
    {
        return $this->contactRepository;
    }
}
