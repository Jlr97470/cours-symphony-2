<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\CallbackTransformer;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, options: [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'E-mail',
                "constraints" => [
                    new Assert\NotBlank([
                        "message" => "L'email est obligatoire."
                    ]),
                    new Assert\Email([
                        "message" => "L'email '{{ value }}' n'est pas un email valide."
                    ])
                ]
            ])
            ->add('roles',ChoiceType::class, options: [
                'attr' => [
                     'class' => 'form-control'
                ],
               'label' => 'Roles (séparés par des points-virgules)',
               "constraints" => [
                   new Assert\NotBlank([
                      "message" => "Les rôles sont obligatoires."
                   ])
                   ],
                'choices'  => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER'
                ]               
            ])
            ->add('password', PasswordType::class, options: [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                "constraints" => [
                    new Assert\NotBlank([
                        "message" => "Le mot de passe est obligatoire."
                    ]),
                new Assert\Length([
                        "min" => 8,
                        "minMessage" => "Le mot de passe doit contenir au moins {{ limit }} caractères."
                    ])
                ]
            ]);  
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    return count($rolesAsArray) ? $rolesAsArray[0]: null;
                },
                function ($rolesAsString) {
                    return [$rolesAsString];
                }
            ));                  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
