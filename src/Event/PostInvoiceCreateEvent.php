<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Event;

use BeHappy\SyliusInvoicePlugin\Entity\InvoiceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PostInvoiceCreateEvent
 *
 * @package BeHappy\SyliusMailPlugin\Event
 */
class PostInvoiceCreateEvent extends Event
{
    const NAME = 'behappy_invoice_plugin.event.invoice.post_create';
    
    /** @var InvoiceInterface */
    protected $invoice;
    
    /**
     * PostInvoiceCreateEvent constructor.
     *
     * @param InvoiceInterface $invoice
     */
    public function __construct(InvoiceInterface $invoice)
    {
        $this->invoice = $invoice;
    }
    
    /**
     * @return InvoiceInterface
     */
    public function getInvoice(): InvoiceInterface
    {
        return $this->invoice;
    }
}