<?php

namespace Pantona\Pages\Entity;

/**
 * Class Page
 *
 * @package Pantona\Pages\Entity
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
     * @OneToMany(targetEntity="Pantona\Pages\Entity\Page", mappedBy="id")
     */
    protected $draft;
    /**
     * @Column(type="integer")
     */
    protected $status;
}
