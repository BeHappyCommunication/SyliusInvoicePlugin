<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * Class Order
 *
 * @package BeHappy\SyliusInvoicePlugin\Entity
 */
class Order extends BaseOrder
{
    /** @var ArrayCollection|InvoiceInterface[] */
    protected $invoices;
    
    /**
     * Order constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->invoices = new ArrayCollection();
    }
    
    /**
     * @return Collection
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }
    
    /**
     * @param InvoiceInterface $invoice
     *
     * @return bool
     */
    public function addInvoice(InvoiceInterface $invoice): bool
    {
        if (!$this->getInvoices()->contains($invoice)) {
            $this->invoices->add($invoice);
        }
        
        return true;
    }
    
    /**
     * @param InvoiceInterface $invoice
     *
     * @return bool
     */
    public function removeInvoice(InvoiceInterface $invoice): bool
    {
        return $this->invoices->removeElement($invoice);
    }
}