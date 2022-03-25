<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = null): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'email :'
            ])
            ->add('objet', TextType::class, [
                'label' => 'objet :'
            ])
            ->add('message', TextType::class, [
                'label' => 'message :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
