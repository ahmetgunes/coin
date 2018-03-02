<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 2.03.2018
 * Time: 15:24
 */

namespace App\Types;


use App\Entity\User;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secretQuestion', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => User::SECRET_QUESTIONS
            ])
            ->add('secretAnswer', null, ['attr' => ['class' => 'form-control']]);
    }

    public function getParent()
    {
        return RegistrationFormType::class;
    }
}