<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Factory;

use BeHappy\SyliusCompanyDataPlugin\Entity\CompanyDataInterface;
use BeHappy\SyliusInvoicePlugin\Entity\InvoiceCompanyDataInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * Class InvoiceCompanyDataFactory
 *
 * @package BeHappy\SyliusInvoicePlugin\Factory
 */
final class InvoiceCompanyDataFactory implements InvoiceCompanyDataFactoryInterface
{
    /** @var FactoryInterface */
    private $factory;
    
    /**
     * InvoiceCompanyDataFactory constructor.
     *
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory) {
        $this->factory = $factory;
    }
    
    /**
     * @return InvoiceCompanyDataInterface|object
     */
    public function createNew(): InvoiceCompanyDataInterface
    {
        return $this->factory->createNew();
    }
    
    /**
     * @param CompanyDataInterface $companyData
     *
     * @return InvoiceCompanyDataInterface
     */
    public function createFromCompanyData(CompanyDataInterface $companyData): InvoiceCompanyDataInterface
    {
        $invoiceCompanyData = $this->createNew();
        $invoiceCompanyData->setName($companyData->getName());
        $invoiceCompanyData->setAddressNumber($companyData->getAddressNumber());
        $invoiceCompanyData->setAddressStreet($companyData->getAddressStreet());
        $invoiceCompanyData->setAddressStreetExtension($companyData->getAddressStreetExtension());
        $invoiceCompanyData->setAddressZipCode($companyData->getAddressZipCode());
        $invoiceCompanyData->setAddressCountry($companyData->getAddressCountry());
        $invoiceCompanyData->setVatNumber($companyData->getVatNumber());
        $invoiceCompanyData->setSiret($companyData->getSiret());
        $invoiceCompanyData->setInformation($companyData->getInformation());
        foreach ($companyData->getChannels() as $channel) {
            $invoiceCompanyData->addChannel($channel);
        }
        
        return $invoiceCompanyData;
    }
}