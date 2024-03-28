<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Oeuvre;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                "label" => "Titre du produit*",
                "required" => false,
               
                "attr" => [
                    "placeholder" => "Saisir un titre",
                    "class" => "border border-danger bg-light",

                ],
                "label_attr" => [
                    "class" => "text-primary"
                ],
                "row_attr" => [
                    "id" => "titreBlock"
                ],
            ] )
            ->add('description', TextareaType::class, [
                "help" => "Description facultative",
                "required" => false,
                "attr" => [
                    "rows" => 8,
                    "class" => "border border-info bg-light",
                    "style" => "margin:1rem"
                ],
                "label_attr" => [
                    "class" => "text-danger"
                ]
            ])
           
            ->add('theme', EntityType::class, [
                "class" => Theme::class,
                "choice_label" => "name",
                "placeholder" => "Sélectionner un theme",
                "required" => false,
                "label" => "theme",
             
                //  "multiple" => true,
                //  "expanded" => true, // radio/checkbox

            ])
            ->add('categorie', EntityType::class, [
                "class" => Categorie::class,
                "choice_label" => "name",
                "placeholder" => "Sélectionner une catégorie",
                "required" => false,
                "label" => "Catégorie*",
             
                //  "multiple" => true,
                //  "expanded" => true, // radio/checkbox

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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
            'ajouter' => false,
            'modifier' => false,
        ]);
    }
}
