<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Repository;

use BeHappy\SyliusInvoicePlugin\Entity\InvoiceInterface;
use Doctrine\ORM\NonUniqueResultException;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;

/**
 * Class InvoiceRepository
 *
 * @package BeHappy\SyliusInvoicePlugin\Repository
 */
final class InvoiceRepository extends EntityRepository implements InvoiceRepositoryInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return InvoiceInterface[]|array
     */
    public function findByOrder(OrderInterface $order): array
    {
        return $this->createQueryBuilder('invoice')
            ->where('invoice.order = :order')
            ->setParameter('order', $order)
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * @return InvoiceInterface|null
     */
    public function findLatest(): ?InvoiceInterface
    {
        $qb = $this->createQueryBuilder('invoice')
            ->addOrderBy('invoice.id', 'DESC')
            ->setMaxResults(1);
        
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            return null;
        }
    }
}