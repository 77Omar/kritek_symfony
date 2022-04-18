<?php

namespace App\Form;

use App\Entity\InvoiceLines;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InvoiceLinesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
            'attr' => [
            'class' => 'form-control'
            ],
             'label' => 'Description',
                            'label_attr' => [
                                'class' => 'form-label mt-4'
                            ],
                             'constraints' => [
                                                new Assert\NotBlank()
                                            ]

            ])
            ->add('quantity', NumberType::class, [
            'attr' => [
            'class' => 'form-control'
            ],
            'label' => 'Quantity',
                                       'label_attr' => [
                                            'class' => 'form-label mt-4'
                                        ],
                                         'constraints' => [
                                                   new Assert\NotBlank()
                                                                              ]
            ])
            ->add('amount', NumberType::class, [
            'attr' => ['class' => 'form-control'
            ],
                        'label' => 'Amount',
                                         'label_attr' => [
                                        'class' => 'form-label mt-4'
                                                                       ],
                               'constraints' => [
                                                   new Assert\NotBlank()
                                                                             ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLines::class,
        ]);
    }
}
