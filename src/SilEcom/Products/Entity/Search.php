<?php

namespace SilEcom\Products\Entity;

class Search
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $name;
    protected $date_created;
    protected $items;
}
