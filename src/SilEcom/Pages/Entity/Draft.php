<?php

namespace SilEcom\Pages\Entity;

class Draft
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $page;
    protected $title;
    protected $content;
    protected $metadata;
    protected $blocks;
}
