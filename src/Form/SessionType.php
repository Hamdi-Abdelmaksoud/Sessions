<?php

namespace App\Form;

use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('stagiaires')
            ->add('formateur',EntityType::class,[
                'class' => Formateur::class,
                'choice_label' => 'nom'
            ])
            ->add('titre',EntityType::class,[
                'class' => Formation::class,
                'choice_label' => 'titre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
