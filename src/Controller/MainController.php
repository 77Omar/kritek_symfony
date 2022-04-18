<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\InvoiceLines;
use App\Form\InvoiceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
         $em = $doctrine->getManager();
         $TVA = 20;
         $invoce = new Invoice();
         $line = new InvoiceLines();
         $invoce->getInvoiceLines()->add($line);
         $form = $this->createForm(InvoiceType::class, $invoce);

         if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
             $lines = $invoce->getInvoiceLines();

             $last_id_record = $em->getRepository(Invoice::class)->findOneBy([], ['id'=>'desc']);
             $invoce->setNumberInvoice($last_id_record ? (int)$last_id_record->getId() +1 : 1);
             $em->persist($invoce);
             foreach ($lines as $singleLine){
                 $amount_without_vat = $singleLine->getQuantity() * $singleLine->getAmount();
                 $amount_vat = ($amount_without_vat * $TVA) /100;
                 $total = $amount_vat + $amount_without_vat;
                 $singleLine->setTotal($total);
                 $singleLine->setVatAmount($amount_vat);
                 $singleLine->setInvoice($invoce);
                 $em->persist($singleLine);
             }
             $em->flush();
             unset($form);
             unset($invoce);
             unset($line);
             $invoce = new Invoice();
             $line = new InvoiceLines();
             $invoce->getInvoiceLines()->add($line);
             $form = $this->createForm(InvoiceType::class, $invoce);
         }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
