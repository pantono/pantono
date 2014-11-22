<?php
namespace SilEcom\Products\Entity;

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
     * @OneToOne(targetEntity="SilEcom\Products\Entity\Draft")
     */
    protected $draft;
    /**
     * @OneToOne(targetEntity="SilEcom\Products\Entity\Status")
     */
    protected $status;
}