<?php

namespace App\Form;

use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Session;
 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut',DateType::class)
            ->add('dateFin',DateType::class)
            ->add('nbrPlaces')
            
            ->add('formateur',EntityType::class,[
                'class' => Formateur::class,
                'choice_label' => 'nom'
            ])
            ->add('titre',EntityType::class,[
                'class' => Formation::class,
                'choice_label' => 'titre',
               
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
