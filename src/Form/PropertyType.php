<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('shortdescription', TextareaType::class, [
                'attr' => [
                    'class' => 'ckeditor',
                    'rows' => 3,
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'ckeditor',
                    'rows' => 7,
                ],
            ])
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices(),
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
            // ->add('save', ButtonType::class, [
            //     'attr' => ['class' => 'save'],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = array_flip($choices);

        return $output;
    }
}
