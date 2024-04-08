<?php

namespace App\Form;

use App\Entity\PageAccueil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('img1')
            ->add('img2')
            ->add('img3');
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PageAccueil::class,
            'ajouter' => false,
            'modifier' => false,

        ]);
    }
}
