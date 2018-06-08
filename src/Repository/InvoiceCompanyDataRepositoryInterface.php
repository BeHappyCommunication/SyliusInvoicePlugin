<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Repository;

use BeHappy\SyliusCompanyDataPlugin\Entity\CompanyDataInterface;
use BeHappy\SyliusInvoicePlugin\Entity\InvoiceCompanyDataInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * Interface InvoiceCompanyDataRepositoryInterface
 *
 * @package BeHappy\SyliusInvoicePlugin\Repository
 */
interface InvoiceCompanyDataRepositoryInterface extends RepositoryInterface
{
    /**
     * @param CompanyDataInterface $companyData
     *
     * @return InvoiceCompanyDataInterface|null
     */
    public function findFromCompanyData(CompanyDataInterface $companyData): ?InvoiceCompanyDataInterface;
}