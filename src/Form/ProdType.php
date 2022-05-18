<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
            ->add('name')
            ->add('quantity')
            ->add('unitPrice')
            ->add('description')
            ->add('descriptiontwo')
            ->add('descriptionthree')
            ->add('descriptionfour')
            ->add('descriptionfive')
            ->add('descriptionsix')
            ->add('material')
            ->add('diameter')
            ->add('weight')
            ->add('gilding')
            ->add('chainLength')
            //On ajoute le champs image dans le formulaire
            //Il n'est pas lié à la BDD car mapped false)
            ->add('picture', FileType::class, [
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false
                ])
            
                
            ->add('category', EntityType::class,[
                'class'=>Category::class,
                'choice_label'=> 'name'
    //Quand il y many to one il faut faire entity type et category. Je demande à une table qu'elle me donne des chaines de caractères, elle ne donc comprend pas.
    //ca rentre en conflit donc il faut faire un entitytype et categorie class
                ])
            ->add('subCategory', EntityType::class,[
                'class'=>SubCategory::class,
                'choice_label'=> 'name'
                ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void{
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
