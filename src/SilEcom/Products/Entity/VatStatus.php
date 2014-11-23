<?php

namespace SilEcom\Products\Entity;

/**
 * Class Draft
 *
 * @package SilEcom\Products\Entity
 * @Entity
 * @Table(name="product_vat_status")
 */
class VatStatus
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
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $amount;
}
