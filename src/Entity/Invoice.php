<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Entity;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

/**
 * Class Invoice
 *
 * @package BeHappy\SyliusInvoicePlugin\Entity
 */
class Invoice implements InvoiceInterface
{
    use TimestampableTrait;
    
    /** @var int */
    protected $id;
    /** @var string */
    protected $number;
    /** @var InvoiceCompanyDataInterface */
    protected $companyData;
    /** @var OrderInterface */
    protected $order;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @return null|string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }
    
    /**
     * @param null|string $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }
    
    /**
     * @return InvoiceCompanyDataInterface
     */
    public function getCompanyData(): InvoiceCompanyDataInterface
    {
        return $this->companyData;
    }
    
    /**
     * @param InvoiceCompanyDataInterface $companyData
     */
    public function setCompanyData(InvoiceCompanyDataInterface $companyData): void
    {
        $this->companyData = $companyData;
    }
    
    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface
    {
        return $this->order;
    }
    
    /**
     * @param OrderInterface $order
     */
    public function setOrder(OrderInterface $order): void
    {
        $this->order = $order;
    }
}