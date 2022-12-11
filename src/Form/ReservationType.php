<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Service\CallApiService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{

    private $collapiservice;

    public function __construct(CallApiService $collapiservice)
    {
        $this->collapiservice = $collapiservice;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $eleve = $this->collapiservice->getDataNws();
        $array = [];

        // dd($eleve);
        // pour chaque
        foreach ($eleve as $values)
        {
            // dd($values);
            foreach($values as $key => $value)
            {
                // dd($value);
                array_push($array, [$key, $value]);
                // echo '' . $key . ' ' . $value . "<br/>";
                // dd($values, $key, $value);

            }
        }

        
        // dd($array);
        
        // Je passe dans les tableaux pour recupérer tout les données id, nom, prenom, mail.
        // foreach ($eleve as $key => $value) {
        //     //  echo $key . '<br/>';
        //     if (is_array($value)) {
        //         foreach ($value as $key => $value) {
        //              dd($value, $key);
        //             //  echo '' . $key . ' ' . $value . "<br/>";
        //             array_push($array, [$value, $key]);
        //         //    dd($array);
        //         }
        //     }
        // };

        // dd($array);
        // J'ai toute les données dans le tableau array mais il ne sont ranger


        // array_map applique une function au element du tableau
        $array = array_map(function ($e) {
            return [
                'id' => $e['id']
            ];
        }, $eleve); // ici c'est bien le getDataNws

        //  dd($array);
        // le $array a bien les id de l'api
        // // Je veux envoyer c'est donner en bdd

        $builder
            ->add('name', ChoiceType::class, [
                'label' => 'Nom',
                'choices' => [
                    "j'ai pas réussi" => "j'ai pas réussi"
                ]
            ])

            ->add('email', ChoiceType::class, [
                'label' => 'email',
                'choices' => [
                    "j'ai pas réussi" => "j'ai pas réussi"
                ]
            ])

            // ->add('idapi',  ChoiceType::class, [
            //     'choices' => [
            //         'name' => 'id',
            //     ],
            // ])


            // ->add('email', EmailType::class, array(
            //     'attr' => array('placeholder' => 'Votre adresse e-mail'),
            //     'constraints' => array(
            //         new NotBlank(array("message" => "Veuillez fournir un email valide")),
            //         new Email(array("message" => "Votre email ne semble pas valide")),
            //     )
            // ))

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
