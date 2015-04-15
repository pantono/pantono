<?php

namespace Pantona\Assets\Entity;

/**
 * Class Type
 *
 * @package Pantona\Assets\Entity
 * @Entity
 * @Table(name="asset_type")
 */
class Type
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
    protected $type;
}
