<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Command;

use BeHappy\SyliusInvoicePlugin\Entity\Order;
use BeHappy\SyliusInvoicePlugin\Factory\InvoiceFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateInvoicesCommand extends ContainerAwareCommand
{
    use LockableTrait;
    
    public function configure(): void
    {
        $this->setName('behappy:invoice:generate');
        $this->setDescription('Generate invoices for orders that have been places before plugin install');
    }
    
    public function run(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');
        
            return 1;
        }
        
        $output->writeln(['Generating invoices', '==================']);
    
        $container = $this->getContainer();
        $this->em = $container->get('doctrine')->getManager();
        /** @var InvoiceFactoryInterface $invoiceFactory */
        $invoiceFactory = $container->get('behappy_invoice_plugin.factory.invoice');
        
        /** @var OrderInterface[]|Order[] $orders */
        $orders = $container->get('sylius.repository.order')->findBy(['state' => OrderInterface::STATE_FULFILLED]);
        foreach ($orders as $order) {
            if ($order->getInvoices()->isEmpty()) {
                $output->writeln('Generating invoice for order N°: '. $order->getNumber(), OutputInterface::VERBOSITY_VERBOSE);
                $invoice = $invoiceFactory->createFromOrder($order);
                $this->em->persist($invoice);
                $this->em->flush();
            }
        }
    
        $output->writeln(['Done']);
        
        $this->release();
        
        return 0;
    }
}