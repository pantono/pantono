<?php

namespace SilEcom\Suppliers\Entity;

class Contact
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $supplier;
    protected $contact;
    protected $billing_contact = 0;
    protected $main_contact = 0;
}
