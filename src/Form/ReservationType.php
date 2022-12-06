<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('email', EmailType::class, array(
                'attr' => array('placeholder' => 'Votre adresse e-mail'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez fournir un email valide")),
                    new Email(array("message" => "Votre email ne semble pas valide")),
                )
            ))

            /**
             * Le format des données d' entrée - c'est-à-dire
             * le format dans lequel la date est stockée sur votre objet sous-jacent. Les valeurs valides sont :
             */
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
