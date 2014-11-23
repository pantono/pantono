<?php

namespace SilEcom\Products\Entity;

/**
 * Class Brand
 *
 * @package SilEcom\Products\Entity
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
     * @OneToOne(targetEntity="SilEcom\Assets\Entity\Asset")
     */
    protected $logo;
}
