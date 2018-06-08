<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Factory;

use BeHappy\SyliusCompanyDataPlugin\Entity\CompanyDataInterface;
use BeHappy\SyliusInvoicePlugin\Entity\InvoiceCompanyDataInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * Interface InvoiceCompanyDataFactoryInterface
 *
 * @package BeHappy\SyliusInvoicePlugin\Factory
 */
interface InvoiceCompanyDataFactoryInterface extends FactoryInterface
{
    /**
     * @param CompanyDataInterface $companyData
     *
     * @return InvoiceCompanyDataInterface
     */
    public function createFromCompanyData(CompanyDataInterface $companyData): InvoiceCompanyDataInterface;
}