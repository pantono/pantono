<?php

namespace Pantona\Products\Entity;

/**
 * Class File
 *
 * @package Pantona\Products\Entity
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
     * @OneToOne(targetEntity="Pantona\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @ManyToOne(targetEntity="Pantona\Products\Entity\Draft")
     */
    protected $productDraft;
    /**
     * @Column(type="integer")
     */
    protected $displayOrder;
}
