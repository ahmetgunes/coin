<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 2.03.2018
 * Time: 16:13
 */

namespace App\Services\EventListeners;


use App\Entity\User;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationListener implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $encoder;

    /**
     * RegistrationListener constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        if ($user instanceof User) {
            //TODO:Create public and private key
            //Hashing secret answer before saving the user
            $secretAnswer = $this->encoder->encodePassword($user, $user->getSecretAnswer());
            $user->setSecretAnswer($secretAnswer);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => ['onRegistrationSuccess', -10]
        ];
    }
}