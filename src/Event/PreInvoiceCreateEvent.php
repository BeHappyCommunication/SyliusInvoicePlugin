<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Event;

use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PreInvoiceCreateEvent
 *
 * @package BeHappy\SyliusInvoicePlugin\Event
 */
class PreInvoiceCreateEvent extends Event
{
    const NAME = 'behappy_invoice_plugin.event.invoice.pre_create';
    
    /** @var OrderInterface */
    protected $order;
    
    /**
     * PreInvoiceCreateEvent constructor.
     *
     * @param OrderInterface $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }
    
    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface
    {
        return $this->order;
    }
}