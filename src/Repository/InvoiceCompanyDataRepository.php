<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Repository;

use BeHappy\SyliusCompanyDataPlugin\Entity\CompanyDataInterface;
use BeHappy\SyliusInvoicePlugin\Entity\InvoiceCompanyDataInterface;
use Doctrine\ORM\NonUniqueResultException;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Class InvoiceCompanyDataRepository
 *
 * @package BeHappy\SyliusInvoicePlugin\Repository
 */
final class InvoiceCompanyDataRepository extends EntityRepository implements InvoiceCompanyDataRepositoryInterface
{
    /**
     * @param CompanyDataInterface $companyData
     *
     * @return InvoiceCompanyDataInterface|null
     */
    public function findFromCompanyData(CompanyDataInterface $companyData): ?InvoiceCompanyDataInterface
    {
        $qb = $this->createQueryBuilder('icd');
        
        $qb->andWhere('icd.name = :name')
            ->andWhere('icd.addressNumber = :addressNumber')
            ->andWhere('icd.addressStreet = :addressStreet')
            ->andWhere('icd.addressStreetExtension = :addressStreetExtension')
            ->andWhere('icd.addressZipCode = :addressZipCode')
            ->andWhere('icd.addressCountry = :addressCountry')
            ->andWhere('icd.vatNumber = :vatNumber')
            ->andWhere('icd.siret = :siret')
            ->andWhere('icd.information = :information')
            ->join('icd.channels', 'channels')
            ->andWhere('channels.id IN (:channels)')
            ->setParameters([
                'name' => $companyData->getName(),
                'addressNumber' => $companyData->getAddressNumber(),
                'addressStreet' => $companyData->getAddressStreet(),
                'addressStreetExtension' => $companyData->getAddressStreetExtension(),
                'addressZipCode' => $companyData->getAddressZipCode(),
                'addressCountry' => $companyData->getAddressCountry(),
                'vatNumber' => $companyData->getVatNumber(),
                'siret' => $companyData->getSiret(),
                'information' => $companyData->getInformation(),
                'channels' => [$companyData->getChannels()]
            ])
            ->setMaxResults(1)
        ;
        
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            return null;
        }
    }
}