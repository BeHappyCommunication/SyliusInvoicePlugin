<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Event\Listener;

use BeHappy\SyliusInvoicePlugin\Event\PostInvoiceCreateEvent;
use BeHappy\SyliusInvoicePlugin\Event\PreInvoiceCreateEvent;
use BeHappy\SyliusInvoicePlugin\Factory\InvoiceFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class OrderListener
 *
 * @package BeHappy\SyliusInvoicePlugin\Event\Listener
 */
final class OrderListener
{
    /** @var InvoiceFactoryInterface */
    private $invoiceFactory;
    /** @var EntityManagerInterface */
    private $em;
    /** @var EventDispatcherInterface */
    private $dispatcher;
    
    /**
     * OrderListener constructor.
     *
     * @param EntityManagerInterface   $em
     * @param InvoiceFactoryInterface  $invoiceFactory
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManagerInterface $em, InvoiceFactoryInterface $invoiceFactory, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->invoiceFactory = $invoiceFactory;
        $this->dispatcher = $dispatcher;
    }
    
    /**
     * @param OrderInterface $order
     */
    public function onOrderPaid(OrderInterface $order): void
    {
        $preInvoiceCreateEvent = new PreInvoiceCreateEvent($order);
        $this->dispatcher->dispatch(PreInvoiceCreateEvent::NAME, $preInvoiceCreateEvent);
        
        $invoice = $this->invoiceFactory->createFromOrder($order);
        $this->em->persist($invoice);
        $this->em->flush();
    
        $postInvoiceCreateEvent = new PostInvoiceCreateEvent($invoice);
        $this->dispatcher->dispatch(PostInvoiceCreateEvent::NAME, $postInvoiceCreateEvent);
    }
}