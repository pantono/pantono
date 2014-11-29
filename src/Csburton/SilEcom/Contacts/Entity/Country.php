<?php

namespace Csburton\SilEcom\Contacts\Entity;

/**
 * Class Country
 *
 * @package SilEcom\Contacts\Entity
 * @Entity
 * @Table(name="country")
 */
class Country
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $full_name;
    /**
     * @Column(type="string", length=2)
     */
    protected $iso_2_letter;
    /**
     * @Column(type="string", length=3)
     */
    protected $iso_3_letter;
}
