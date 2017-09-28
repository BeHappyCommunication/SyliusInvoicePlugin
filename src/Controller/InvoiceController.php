<?php

namespace BHC\InvoicePlugin\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoiceController extends Controller
{
    /**
     * @param Request $request
     *
     * @return PdfResponse
     */
    public function renderPdfAction(Request $request): PdfResponse
    {
        if(!empty($request->get('id'))){
            $orderId = (int)$request->get('id');
            $order = $this->container->get('sylius.repository.order')->find($orderId);
        }elseif(!empty($request->get('number'))){
            $orderNumber = $request->get('number');
            $order = $this->container->get('sylius.repository.order')->findOneBy(['number' => $orderNumber]);
        }else{
            throw new BadRequestHttpException('Missing mandatory parameter');
        }
        if(!$order instanceof Order)
            throw new NotFoundHttpException('The "order" has not been found');
    
        if($order->getState() !== OrderInterface::STATE_FULFILLED)
            throw new BadRequestHttpException('Order not fulfilled');
    
        $html = $this->renderView('BHCInvoice:Invoice:pdf.html.twig', [
            'order' => $order
        ]);
        
        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'invoice.pdf'
        );
    }
    
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function renderAction(Request $request): Response
    {
        if(!empty($request->get('id'))){
            $orderId = (int)$request->get('id');
            $order = $this->container->get('sylius.repository.order')->find($orderId);
        }elseif(!empty($request->get('number'))){
            $orderNumber = $request->get('number');
            $order = $this->container->get('sylius.repository.order')->findOneBy(['number' => $orderNumber]);
        }else{
            throw new BadRequestHttpException('Missing mandatory parameter');
        }
        if(!$order instanceof Order)
            throw new NotFoundHttpException('The "order" has not been found');
    
        if($order->getState() !== OrderInterface::STATE_FULFILLED)
            throw new BadRequestHttpException('Order not fulfilled');
    
        return $this->render('BHCInvoice:Invoice:pdf.html.twig', [
            'order' => $order
        ]);
    }
}