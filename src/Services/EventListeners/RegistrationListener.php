<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 2.03.2018
 * Time: 16:13
 */

namespace App\Services\EventListeners;


use App\Entity\User;
use App\Services\KeyGenerator;
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
     * @var KeyGenerator
     */
    protected $keyGenerator;

    /**
     * RegistrationListener constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param KeyGenerator $keyGenerator
     */
    public function __construct(UserPasswordEncoderInterface $encoder, KeyGenerator $keyGenerator)
    {
        $this->encoder = $encoder;
        $this->keyGenerator = $keyGenerator;
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        if ($user instanceof User) {
            //Hashing secret answer before saving the user
            $secretAnswer = $this->encoder->encodePassword($user, $user->getSecretAnswer());
            list($privateKey, $publicKey) = $this->keyGenerator->generateKeyPairForUser();

            $user->setSecretAnswer($secretAnswer)->setPrivateKey($privateKey)->setPublicKey($publicKey);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => ['onRegistrationSuccess', -10]
        ];
    }
}