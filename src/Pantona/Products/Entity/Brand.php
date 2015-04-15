<?php

namespace Pantona\Products\Entity;

/**
 * Class Brand
 *
 * @package Pantona\Products\Entity
 * @Entity
 * @Table(name="product_brand")
 */
class Brand
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
    protected $name;
    /**
     * @OneToOne(targetEntity="Pantona\Assets\Entity\Asset")
     */
    protected $logo;
}
