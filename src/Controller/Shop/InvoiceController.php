<?php

declare(strict_types = 1);

namespace BeHappy\SyliusInvoicePlugin\Controller\Shop;

use BeHappy\SyliusInvoicePlugin\Entity\InvoiceInterface;
use BeHappy\SyliusInvoicePlugin\Entity\Order;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class InvoiceController
 *
 * @package BeHappy\SyliusInvoicePlugin\Controller\Admin
 */
class InvoiceController extends Controller
{
    /**
     * @param int $id
     * @param int $invoiceId
     *
     * @return Response
     */
    public function readAction(int $id, int $invoiceId): Response
    {
        $translator = $this->container->get('translator');
        $customer = $this->container->get('sylius.context.customer')->getCustomer();
        
        /** @var OrderInterface|Order|null $order */
        $order = $this->container->get('sylius.repository.order')->find($id);
        if (!$order instanceof OrderInterface) {
            throw new NotFoundHttpException($translator->trans('behappy_invoice_plugin.errors.order_not_found'));
        }
        
        if (!$order->getCustomer() === $customer) {
            throw new BadRequestHttpException($translator->trans('behappy_invoice_plugin.errors.order_not_for_customer'));
        }
        
        /** @var InvoiceInterface $invoice */
        $invoice = $this->container->get('behappy_invoice_plugin.repository.invoice')->find($invoiceId);
        if (!$invoice instanceof InvoiceInterface) {
            throw new NotFoundHttpException($translator->trans('behappy_invoice_plugin.errors.invoice_not_found'));
        }
        
        if (!$order->getInvoices()->contains($invoice)) {
            throw new BadRequestHttpException($translator->trans('behappy_invoice_plugin.errors.invoice_not_for_order'));
        }
        
        return $this->render('@BeHappySyliusInvoicePlugin/Invoice/Admin/read.html.twig', ['resource' => $invoice]);
    }
    
    /**
     * @param string $number
     * @param string $invoiceNumber
     *
     * @return PdfResponse
     */
    public function viewPdfAction(string $number, string $invoiceNumber): PdfResponse
    {
        $translator = $this->container->get('translator');
        $customer = $this->container->get('sylius.context.customer')->getCustomer();
    
        /** @var OrderInterface|Order|null $order */
        $order = $this->container->get('sylius.repository.order')->findOneBy(['number' => $number]);
        if (!$order instanceof OrderInterface) {
            throw new NotFoundHttpException($translator->trans('behappy_invoice_plugin.errors.order_not_found'));
        }
    
        if (!$order->getCustomer() === $customer) {
            throw new BadRequestHttpException($translator->trans('behappy_invoice_plugin.errors.order_not_for_customer'));
        }
    
        /** @var InvoiceInterface $invoice */
        $invoice = $this->container->get('behappy_invoice_plugin.repository.invoice')->findOneBy(['number' => $invoiceNumber]);
        if (!$invoice instanceof InvoiceInterface) {
            throw new NotFoundHttpException($translator->trans('behappy_invoice_plugin.errors.invoice_not_found'));
        }
    
        if (!$order->getInvoices()->contains($invoice)) {
            throw new BadRequestHttpException($translator->trans('behappy_invoice_plugin.errors.invoice_not_for_order'));
        }
    
        $html = $this->renderView('@BeHappySyliusInvoicePlugin/Invoice/pdf.html.twig', [
            'invoice' => $invoice
        ]);
    
        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'invoice.pdf'
        );
    }
}