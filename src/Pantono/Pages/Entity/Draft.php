<?php

namespace Pantono\Pages\Entity;

/**
 * Class Draft
 *
 * @package Pantono\Pages\Entity
 * @Entity
 * @Table(name="page_draft")
 */
class Draft
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Pages\Entity\Page")
     */
    protected $page;
    /**
     * @Column(type="string")
     */
    protected $title;
    /**
     * @Column(type="text")
     */
    protected $content;
    /**
     * @OneToOne(targetEntity="Pantono\Core\Entity\Metadata")
     */
    protected $metadata;
}
