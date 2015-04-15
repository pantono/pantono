<?php

namespace Pantona\Pages\Entity;

/**
 * Class Draft
 *
 * @package Pantona\Pages\Entity
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
     * @ManyToOne(targetEntity="Pantona\Pages\Entity\Page")
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
     * @OneToOne(targetEntity="Pantona\Core\Entity\Metadata")
     */
    protected $metadata;
}
