<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Entity;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

/**
 * Interface InvoiceInterface
 *
 * @package BeHappy\SyliusInvoicePlugin\Entity
 */
interface InvoiceInterface extends ResourceInterface, TimestampableInterface
{
    /**
     * @return null|string
     */
    public function getNumber(): ?string;
    
    /**
     * @param null|string $number
     */
    public function setNumber(?string $number): void;
    
    /**
     * @return InvoiceCompanyDataInterface
     */
    public function getCompanyData(): InvoiceCompanyDataInterface;
    
    /**
     * @param InvoiceCompanyDataInterface $companyData
     */
    public function setCompanyData(InvoiceCompanyDataInterface $companyData): void;
    
    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface;
    
    /**
     * @param OrderInterface $order
     */
    public function setOrder(OrderInterface $order): void;
}