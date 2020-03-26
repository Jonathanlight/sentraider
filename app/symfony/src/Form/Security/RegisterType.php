<?php

namespace App\Form\Security;

use App\Entity\User;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null,
            'is_new' => false,
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genre', ChoiceType::class, [
                'label' => '',
                'required'=>true,
                'expanded' => false,
                'placeholder' => false,
                'choices'  => [
                    'form.user.genre.title' => '',
                    'form.user.genre.man' => User::STATUS_MAN,
                    'form.user.genre.woman' => User::STATUS_WOMAN,
                ],
                'attr' => [
                    'class' => 'mdb-select md-form',
                    'placeholder' => 'Types',
                ]
            ])
            /* Disabled input role
            ->add('role', ChoiceType::class, [
                'label' => '',
                'required'=>true,
                'expanded' => false,
                'placeholder' => false,
                'choices'  => [
                    'form.user.role.title' => null,
                    'form.user.role.user' => User::ROLE_USER,
                    'form.user.role.teacher' => User::ROLE_TEACHER,
                ],
                'attr' => [
                    'class' => 'mdb-select md-form',
                    'placeholder' => 'Types',
                ]
            ])*/
            ->add('nom', TextType::class, [
                'label' => 'form.user.last_name',
                'attr' => [
                    'placeholder' => 'form.user.last_name',
                    'class' => 'form-control',
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'form.user.first_name',
                'attr' => [
                    'placeholder' => 'form.user.first_name',
                    'class' => 'form-control',
                ],
            ])
            ->add('hasValidatedCGU', CheckboxType::class, [
                'required'=>true,
                'label' => 'form.user.hasValidatedCGU',
                'label_attr' => [
                    'class' => 'custom-control-label'
                ],
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.action.email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'form.action.email',
                ]
            ])
            ->add('numero', TextType::class, [
                'label' => 'form.action.phone',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'form.action.phone',
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'form.action.adresse',
                'attr' => [
                    'required' => false,
                    'placeholder' => 'form.action.adresse',
                    'class' => 'form-control autocomplete',
                ],
            ])
            ->add('city', HiddenType::class, [
                'attr' => [
                    'class' => 'form-control locality',
                ],
            ])
            ->add('country', HiddenType::class, [
                'attr' => [
                    'class' => 'form-control country',
                ],
            ])
            ->add('department', HiddenType::class, [
                'attr' => [
                    'class' => 'administrative_area_level_2',
                ],
            ])
            ->add('latitude', HiddenType::class, [
                'attr' => [
                    'class' => 'latitude',
                ],
            ])
            ->add('longitude', HiddenType::class, [
                'attr' => [
                    'class' => 'longitude',
                ],
            ])
            ->add('postal_code', HiddenType::class, [
                'attr' => [
                    'class' => 'form-control postal_code',
                ],
            ])
            ->add('region', HiddenType::class, [
                'attr' => [
                    'class' => 'administrative_area_level_1',
                ],
            ])
            ->add('street_name', HiddenType::class, [
                'attr' => [
                    'class' => 'route',
                ],
            ])
            ->add('street_number', HiddenType::class, [
                'attr' => [
                    'class' => 'street_number',
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
            ->add('recaptcha', EWZRecaptchaType::class, array(
                'attr' => [
                    'options' => [
                        'theme' => 'light',
                        'type'  => 'image',
                        'size'  => 'normal',
                    ],
                ],
                'mapped' => false,
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'form.action.submit',
                'attr' => [
                    'class' => 'btn green-own',
                ]
            ])
        ;
    }
}
