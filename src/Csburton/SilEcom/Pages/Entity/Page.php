<?php

namespace Csburton\SilEcom\Pages\Entity;

/**
 * Class Page
 *
 * @package SilEcom\Pages\Entity
 * @Entity
 * @Table(name="page")
 */
class Page
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToMany(targetEntity="Csburton\SilEcom\Pages\Entity\Page", mappedBy="id")
     */
    protected $draft;
    /**
     * @Column(type="integer")
     */
    protected $status;
}
