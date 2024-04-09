<?php

namespace App\Form;

use App\Entity\PageAccueil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageAccueilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        
        $builder
            ->add('texte',TextareaType::class,[
                "label" => "Texte page accueil",
                "required" => false,
               
                "attr" => [
                    "placeholder" => "Saisir un texte",
                    "class" => "border border-danger bg-light",

                ],
                "label_attr" => [
                    "class" => "text-primary"
                ],
                "row_attr" => [
                    "id" => "titreBlock"
                ],
            ] ) 
            ->add('img1', FileType::class, [
                'label' => 'Image 1',
                'required' => false,
                'mapped' => false, // Pas de mapping avec l'entité, à gérer manuellement
            ])
            ->add('img2', FileType::class, [
                'label' => 'Image 2',
                'required' => false,
                'mapped' => false, // Pas de mapping avec l'entité, à gérer manuellement
            ])
            ->add('img3', FileType::class, [
                'label' => 'Image 3',
                'required' => false,
                'mapped' => false, // Pas de mapping avec l'entité, à gérer manuellement
            ])
            ->add('img4', FileType::class, [
                'label' => 'Image 4',
                'required' => false,
                'mapped' => false, // Pas de mapping avec l'entité, à gérer manuellement
            ])
            ->add('img5', FileType::class, [
                'label' => 'Image 5',
                'required' => false,
                'mapped' => false, // Pas de mapping avec l'entité, à gérer manuellement
            ]);
            if ($options['ajouter']) {
                $builder->add('image', FileType::class, [
                    "required" => false,
                    "data_class" => null,
                    "attr" => [
                        'onchange' => "loadFile(event)"
                    ]
                ]);
            }
    
            if ($options['modifier']) {
                $builder->add('imageUpdate', FileType::class, [
                    "required" => false,
                    "mapped" => false, // qui n'est pas dans l'entity
                
                    "attr" => [
                        'onchange' => "loadFile(event)"
                    ]
                ]);
            }
        ;

        if ($options['images']) {
            foreach ($options['images'] as $fieldName => $imageName) {
                $builder->add($fieldName . '_existing', FileType::class, [
                    'data' => $imageName,
                    'mapped' => false,
                ]);
            }}



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PageAccueil::class,
            'ajouter' => false,
            'modifier' => false,
            'images' => [],

        ]);
    }
}
