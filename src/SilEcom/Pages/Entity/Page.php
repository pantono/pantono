<?php

namespace SilEcom\Pages\Entity;

class Page
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $draft;
    protected $status;
}
