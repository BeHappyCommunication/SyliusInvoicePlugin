<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Repository;

use BeHappy\SyliusInvoicePlugin\Entity\InvoiceInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * Interface InvoiceRepositoryInterface
 *
 * @package BeHappy\SyliusInvoicePlugin\Repository
 */
interface InvoiceRepositoryInterface extends RepositoryInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return InvoiceInterface[]|array
     */
    public function findByOrder(OrderInterface $order): array;
    
    /**
     * @return InvoiceInterface|null
     */
    public function findLatest(): ?InvoiceInterface;
}