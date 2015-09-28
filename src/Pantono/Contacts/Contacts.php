<?php namespace Pantono\Contacts;

use Pantono\Contacts\Entity\Repository\ContactRepository;

/**
 * Main class for managing contacts
 *
 * @package Pantono\Contacts
 * @author  Chris Burton <csburton@gmail.com>
 */
class Contacts
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Gets a single contact by its ID
     *
     * @param int $id ID to search for
     *
     * @return null|object
     */
    public function getSingleContact($id)
    {
        return $this->getContactRepository()->find($id);
    }

    /**
     * Gets contact repository
     *
     * @return ContactRepository
     */
    private function getContactRepository()
    {
        return $this->contactRepository;
    }
}
