<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Factory;

use BeHappy\SyliusInvoicePlugin\Entity\InvoiceInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * Interface InvoiceFactoryInterface
 *
 * @package BeHappy\SyliusInvoicePlugin\Factory
 */
interface InvoiceFactoryInterface extends FactoryInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return InvoiceInterface
     */
    public function createFromOrder(OrderInterface $order): InvoiceInterface;
}