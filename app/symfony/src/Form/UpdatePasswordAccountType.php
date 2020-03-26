<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePasswordAccountType extends AbstractType
{
    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'user_delete';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'cascade_validation' => true,
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password_old', PasswordType::class, [
                'label' => 'form.action.password_old',
                'attr' => [
                    'placeholder' => 'form.action.password_old',
                    'class' => 'form-control',
                ],
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'help' => 'form.action.password.help',
                'first_options'  => array(
                    'label' => 'form.action.password'
                ),
                'second_options' => array(
                    'label' => 'form.action.newPassword'
                ),
                'attr' => array(
                    'min' => 6,
                    'max' => 20
                )
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'form.action.submit',
                'attr' => [
                    'class' => 'btn green-own btn-sm',
                ]
            ])
        ;
    }
}
