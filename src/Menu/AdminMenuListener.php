<?php

namespace BHC\InvoicePlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();
        
        $orderSubMenu = $menu->getChild('sales');
        $orderSubMenu->addChild('test')
            ->setLabel('Test de menu');
    }
}