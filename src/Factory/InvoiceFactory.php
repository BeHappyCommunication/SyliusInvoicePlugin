<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Factory;

use BeHappy\SyliusCompanyDataPlugin\Entity\CompanyDataInterface;
use BeHappy\SyliusCompanyDataPlugin\Repository\CompanyDataRepositoryInterface;
use BeHappy\SyliusInvoicePlugin\Entity\InvoiceCompanyDataInterface;
use BeHappy\SyliusInvoicePlugin\Entity\InvoiceInterface;
use BeHappy\SyliusInvoicePlugin\Repository\InvoiceCompanyDataRepositoryInterface;
use BeHappy\SyliusInvoicePlugin\Repository\InvoiceRepositoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class InvoiceFactory
 *
 * @package BeHappy\SyliusInvoicePlugin\Factory
 */
final class InvoiceFactory implements InvoiceFactoryInterface
{
    /** @var FactoryInterface */
    private $factory;
    /** @var InvoiceRepositoryInterface */
    private $invoiceRepository;
    /** @var CompanyDataRepositoryInterface */
    private $companyDataRepository;
    /** @var InvoiceCompanyDataRepositoryInterface */
    private $invoiceCompanyDataRepository;
    /** @var InvoiceCompanyDataFactoryInterface */
    private $invoiceCompanyDataFactory;
    /** @var int */
    private $invoicesNumberLength;
    
    /**
     * InvoiceFactory constructor.
     *
     * @param FactoryInterface                      $factory
     * @param InvoiceRepositoryInterface            $invoiceRepository
     * @param CompanyDataRepositoryInterface        $companyDataRepository
     * @param InvoiceCompanyDataRepositoryInterface $invoiceCompanyDataRepository
     * @param InvoiceCompanyDataFactoryInterface    $invoiceCompanyDataFactory
     * @param int                                   $invoicesNumberLength
     */
    public function __construct(FactoryInterface $factory,
                                   InvoiceRepositoryInterface $invoiceRepository,
                                   CompanyDataRepositoryInterface $companyDataRepository,
                                   InvoiceCompanyDataRepositoryInterface $invoiceCompanyDataRepository,
                                   InvoiceCompanyDataFactoryInterface $invoiceCompanyDataFactory, int $invoicesNumberLength) {
        $this->factory = $factory;
        $this->invoiceRepository = $invoiceRepository;
        $this->companyDataRepository = $companyDataRepository;
        $this->invoiceCompanyDataRepository = $invoiceCompanyDataRepository;
        $this->invoiceCompanyDataFactory = $invoiceCompanyDataFactory;
        $this->invoicesNumberLength = $invoicesNumberLength;
    }
    
    /**
     * @return InvoiceInterface|object
     */
    public function createNew(): InvoiceInterface
    {
        return $this->factory->createNew();
    }
    
    /**
     * @param OrderInterface $order
     *
     * @return InvoiceInterface
     */
    public function createFromOrder(OrderInterface $order): InvoiceInterface
    {
        $channel = $order->getChannel();
        /** @var CompanyDataInterface|null $companyData */
        $companyData = $this->companyDataRepository->findOneByChannel($channel);
        if (!$companyData instanceof CompanyDataInterface) {
            throw new NotFoundHttpException('behappy_invoice_plugin.errors.impossible_to_find_company_data');
        }
        $invoiceCompanyData = $this->invoiceCompanyDataRepository->findFromCompanyData($companyData);
        if (!$invoiceCompanyData instanceof InvoiceCompanyDataInterface) {
            $invoiceCompanyData = $this->invoiceCompanyDataFactory->createFromCompanyData($companyData);
        }
        
        $invoice = $this->createNew();
        $invoice->setCompanyData($invoiceCompanyData);
        $invoice->setOrder($order);
        $invoice->setNumber($this->getNextNumber());
        
        return $invoice;
    }
    
    /**
     * @return string
     */
    public function getNextNumber(): string
    {
        $latestInvoice = $this->invoiceRepository->findLatest();
        if (!$latestInvoice instanceof InvoiceInterface) {
            $nextNumber = 1;
        } else {
            $nextNumber = (int)$latestInvoice->getNumber() + 1;
        }
        
        return str_pad((string)$nextNumber, $this->invoicesNumberLength, '0', STR_PAD_LEFT);
    }
}