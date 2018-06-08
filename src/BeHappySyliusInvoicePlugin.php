<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BeHappySyliusInvoicePlugin extends Bundle
{
    use SyliusPluginTrait;
}