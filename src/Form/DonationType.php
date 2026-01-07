<?php

namespace App\Form;

use App\Entity\BloodCenter;
use App\Entity\Donation;
use App\Entity\DonorProfile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bloodType')
            ->add('quantity')
            ->add('donatedAt')
            ->add('status')
            ->add('donorProfile', EntityType::class, [
                'class' => DonorProfile::class,
                'choice_label' => 'id',
            ])
            ->add('bloodCenter', EntityType::class, [
                'class' => BloodCenter::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
