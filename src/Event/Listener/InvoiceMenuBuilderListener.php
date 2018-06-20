<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Event\Listener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class InvoiceMenuBuilderListener
{
    public function addInvoiceItem(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();
        
        $menu->getChild('sales')
            ->addChild('invoices', ['route' => 'behappy_invoice_plugin_admin_invoice_index'])
            ->setLabel('behappy_invoice_plugin.ui.menu.invoices')
            ->setLabelAttribute('icon', 'file pdf');
    }
}