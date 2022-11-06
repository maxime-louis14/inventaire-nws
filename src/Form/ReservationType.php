<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('email')
            ->add('rendered', DateTimeType::class, array(
                'widget' => 'single_text',
                'label' => 'date du rendu',
            ))

            // ->add('loandate', DateTimeType::class, array(
            //     'widget' => 'single_text',
            //     'label' => 'date de prêt',
            //     '' => ''
            // ))
            ->add('product')
            ->add('isrenderd', CheckboxType::class, [
                'label' => 'Rendu',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
