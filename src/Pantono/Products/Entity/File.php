<?php

namespace Pantono\Products\Entity;

/**
 * Class File
 *
 * @package Pantono\Products\Entity
 * @Entity
 * @Table(name="product_file")
 */
class File
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @ManyToOne(targetEntity="Pantono\Products\Entity\Draft")
     */
    protected $productDraft;
    /**
     * @Column(type="integer")
     */
    protected $displayOrder;
}
