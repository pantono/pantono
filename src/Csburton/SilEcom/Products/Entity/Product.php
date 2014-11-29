<?php
namespace Csburton\SilEcom\Products\Entity;

/**
 * Class Product
 *
 * @package SilEcom\Products\Entity
 * @Entity
 * @Table(name="products")
 */
class Product
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Products\Entity\Draft")
     */
    protected $draft;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Products\Entity\Status")
     */
    protected $status;
}