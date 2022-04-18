<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('dateInvoice', DateType::class, [
                        'attr' => [
                        'class' => 'form-control'
                        ],
                         'label' => 'date Invoice',
                                        'label_attr' => [
                                            'class' => 'form-label mt-4'
                                        ],
                                         'constraints' => [
                                                            new Assert\NotBlank()
                                                        ]
                        ])
            ->add('customerId', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'customer Id',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('invoiceLines', CollectionType::class, [
                           'entry_type' => InvoiceLinesType::class,
                           'entry_options' => ['label' => false],
                           'allow_add' => true,
                       ])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn-primary'], 'label' => 'Create invoce'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
