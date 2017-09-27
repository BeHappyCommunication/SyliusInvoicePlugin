<?php

namespace BHC\InvoicePlugin\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sylius\Component\Core\Model\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoiceController extends Controller
{
    
    public function renderPdfAction(Request $request)
    {
        $orderId = (int)$request->get('id');
        $order = $this->container->get('sylius.repository.order')->find($orderId);
        if(!$order instanceof Order)
            throw new NotFoundHttpException('The "order" has not been found');
        
        $html = $this->renderView('AppBundle:Invoice:pdf.html.twig', [
            'order' => $order
        ]);
        
        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'invoice.pdf'
        );
    }
    
    public function renderAction(Request $request)
    {
        $orderId = (int)$request->get('id');
        $order = $this->container->get('sylius.repository.order')->find($orderId);
        if(!$order instanceof Order)
            throw new NotFoundHttpException('The "order" has not been found');
        
        return $this->render('AppBundle:Invoice:pdf.html.twig', [
            'order' => $order
        ]);
    }
}