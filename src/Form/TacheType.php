<?php

namespace App\Form;

use App\Entity\Tache;
use App\Entity\Liste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class)
            ->add('Statut', ChoiceType::class, [
                'choices' => [
                    'A Faire' => 'A Faire',
                    'En Cours' => 'En Cours',
                    'Terminé' => 'Terminé',
                ]
            ])
            ->add('Liste', EntityType::class, [
                'class' => Liste::class,
                'choice_label' => 'Nom',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add("Sauvegarder", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
