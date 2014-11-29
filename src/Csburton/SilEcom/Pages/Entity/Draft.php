<?php

namespace Csburton\SilEcom\Pages\Entity;

/**
 * Class Draft
 *
 * @package SilEcom\Pages\Entity
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
     * @ManyToOne(targetEntity="Csburton\SilEcom\Pages\Entity\Page")
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
     * @OneToOne(targetEntity="Csburton\SilEcom\Core\Entity\Metadata")
     */
    protected $metadata;
}
