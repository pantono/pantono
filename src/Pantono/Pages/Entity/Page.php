<?php

namespace Pantono\Pages\Entity;

/**
 * Class Page
 *
 * @package Pantono\Pages\Entity
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
     * @OneToMany(targetEntity="Pantono\Pages\Entity\Page", mappedBy="id")
     */
    protected $draft;
    /**
     * @Column(type="integer")
     */
    protected $status;
}
