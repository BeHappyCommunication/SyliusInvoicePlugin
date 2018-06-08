<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Entity;

use BeHappy\SyliusCompanyDataPlugin\Entity\BaseCompanyData;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;

/**
 * Class InvoiceCompanyData
 *
 * @package BeHappy\SyliusInvoicePlugin\Entity
 */
class InvoiceCompanyData extends BaseCompanyData implements InvoiceCompanyDataInterface
{
    /** @var Collection|ArrayCollection|InvoiceInterface[] */
    protected $invoices;
    /** @var ArrayCollection|ChannelInterface[]|null */
    protected $channels = null;
    
    /**
     * CompanyData constructor.
     */
    public function __construct()
    {
        $this->channels = new ArrayCollection();
    }
    
    /**
     * @return Collection|ChannelInterface[]
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }
    
    /**
     * @param ArrayCollection|ChannelInterface[] $channels
     */
    public function setChannels(ArrayCollection $channels): void
    {
        $this->channels = $channels;
    }
    
    /**
     * @param ChannelInterface $channel
     *
     * @return bool
     */
    public function addChannel(ChannelInterface $channel): bool
    {
        if (!$this->getChannels()->contains($channel)) {
            $this->channels->add($channel);
        }
        
        return true;
    }
    
    /**
     * @param ChannelInterface $channel
     *
     * @return bool
     */
    public function removeChannel(ChannelInterface $channel): bool
    {
        return $this->channels->removeElement($channel);
    }
    
    /**
     * @return Collection
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }
    
    /**
     * @param InvoiceInterface $invoice
     *
     * @return bool
     */
    public function addInvoice(InvoiceInterface $invoice): bool
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
        }
        
        return true;
    }
    
    /**
     * @param InvoiceInterface $invoice
     *
     * @return bool
     */
    public function removeInvoice(InvoiceInterface $invoice): bool
    {
        return $this->invoices->removeElement($invoice);
    }
}