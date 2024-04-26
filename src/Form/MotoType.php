<?php

namespace App\Form;

use App\Entity\Moto;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class MotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom de la moto'
                ])
            ->add('marque', TextType::class,[
                'label' => 'Marque de la moto'
                ])
            ->add('couleur', TextType::class,[
                'label' => 'Couleur de la moto'
                ])
            ->add('annee', TextType::class,[
                'label' => 'Année de production'
                ])
            ->add('prix', TextType::class,[
                'label' => 'Prix de la moto'
                ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer'
                ])
            // ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...))

        ;
    }

    // public function autoSlug(PreSubmitEvent $event): void {
    //     $data = $event->getData() ;
    //     if (empty($data[ 'nom' ])){
    //     $slugger = new AsciiSlugger();
    //     $data[ 'nom'] = strtolower ($slugger->slug($data[ 'nom']));
    //     $event->setData($data);
    //     }
    // }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moto::class,
        ]);
    }
}
