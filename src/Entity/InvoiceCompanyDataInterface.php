<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Entity;

use BeHappy\SyliusCompanyDataPlugin\Entity\CompanyDataInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Interface InvoiceCompanyDataInterface
 *
 * @package BeHappy\SyliusInvoicePlugin\Entity
 */
interface InvoiceCompanyDataInterface extends CompanyDataInterface
{
    /**
     * @return Collection|InvoiceInterface[]|ArrayCollection
     */
    public function getInvoices(): Collection;
    
    /**
     * @param InvoiceInterface $invoice
     *
     * @return bool
     */
    public function addInvoice(InvoiceInterface $invoice): bool;
    
    /**
     * @param InvoiceInterface $invoice
     *
     * @return bool
     */
    public function removeInvoice(InvoiceInterface $invoice): bool;
}