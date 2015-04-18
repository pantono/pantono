<?php

namespace Pantono\Products\Entity;

/**
 * Class Brand
 *
 * @package Pantono\Products\Entity
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
     * @OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $logo;
}
