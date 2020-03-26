<?php

namespace App\Form;

use App\Entity\User;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null,
            'admin' => null
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options["user"]->getId()) {
            $builder
                ->add('mediaProfil', MediaProfilType::class, [
                    'required' => false,
                    'label' => false,
                    'user' => $options['user']
                ])
                ->add('nom', TextType::class, [
                    'label' => 'Nom',
                    'attr' => [
                        'placeholder' => 'Nom',
                        'class' => 'form-control',
                    ],
                ])
                ->add('prenom', TextType::class, [
                    'label' => 'Prénom',
                    'attr' => [
                        'placeholder' => 'Prénom',
                        'class' => 'form-control',
                    ],
                ]);
                if ($options["user"]->getRole() == User::ROLE_TEACHER) {
                    $builder
                        ->add('siret', TextType::class, [
                            'label' => 'Siret',
                            'required' => false,
                            'attr' => [
                                'placeholder' => '362 521 879 00034',
                                'class' => 'form-control',
                                'maxlength' => 255
                            ],
                        ])
                    ;
                }
                if ($options["admin"]) {
                    $builder
                        ->add('role', ChoiceType::class, [
                            'label' => '',
                            'required'=>true,
                            'expanded' => false,
                            'placeholder' => false,
                            'choices'  => [
                                'Selectionnez un profil' => null,
                                'form.user.role.user' => User::ROLE_USER,
                                'form.user.role.coach' => User::ROLE_TEACHER,
                            ],
                            'attr' => [
                                'class' => 'mdb-select md-form',
                                'placeholder' => 'Types',
                            ]
                        ])
                    ;
                }
            $builder
                ->add('numero', TextType::class, [
                    'label' => 'Numéro',
                    'attr' => [
                        'placeholder' => 'Numéro',
                        'class' => 'form-control',
                    ],
                ])
                ->add('address', TextType::class, [
                    'label' => 'Adresse',
                    'attr' => [
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
                ->add('submit', SubmitType::class, [
                    'label' => 'form.action.submit',
                    'attr' => [
                        'class' => 'btn btn-sm green-own',
                    ]
                ])
            ;
        } else {
            $builder
                ->add('username')
                ->add('email')
                ->add('password')
                ->add('passwordReset')
                ->add('passwordResetDate')
                ->add('role', ChoiceType::class, [
                    'label' => '',
                    'required'=>true,
                    'expanded' => false,
                    'placeholder' => false,
                    'choices'  => [
                        'Selectionnez un profil' => null,
                        'form.user.role.user' => User::ROLE_USER,
                        'form.user.role.coach' => User::ROLE_TEACHER,
                    ],
                    'attr' => [
                        'class' => 'mdb-select md-form',
                        'placeholder' => 'Types',
                    ]
                ])
                ->add('types', ChoiceType::class, [
                    'label' => '',
                    'required'=>true,
                    'expanded' => false,
                    'placeholder' => false,
                    'choices'  => [
                        'Genre' => null,
                        'form.user.genre.man' => User::STATUS_MAN,
                        'form.user.genre.woman' => User::STATUS_WOMAN,
                    ],
                    'attr' => [
                        'class' => 'mdb-select md-form',
                        'placeholder' => 'Types',
                    ]
                ])
                ->add('hasValidatedCGU')
                ->add('reference')
                ->add('validated')
                ->add('active')
                ->add('etat')
                ->add('genre', ChoiceType::class, [
                    'label' => '',
                    'required'=>true,
                    'expanded' => false,
                    'placeholder' => false,
                    'choices'  => [
                        'Genre' => null,
                        'form.user.genre.man' => User::STATUS_MAN,
                        'form.user.genre.woman' => User::STATUS_WOMAN,
                    ],
                    'attr' => [
                        'class' => 'mdb-select md-form',
                        'placeholder' => 'Genre',
                    ]
                ])
            ;
        }
    }
}
