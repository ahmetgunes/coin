<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    const SECRET_QUESTIONS = [
        'What was the name of your primary school?' => 0,
        'In what city or town does your sibling live?' => 1,
        'What is your pets name?' => 2
    ];

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="secret_answer", nullable=false, length=60)
     */
    protected $secretAnswer;

    /**
     * @ORM\Column(type="smallint", name="secret_question", nullable=false)
     */
    protected $secretQuestion;

    /**
     * @ORM\Column(type="string", name="private_key", nullable=false)
     */
    protected $privateKey;

    /**
     * @ORM\Column(type="string", name="public_key", nullable=false)
     */
    protected $publicKey;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretAnswer()
    {
        return $this->secretAnswer;
    }

    /**
     * @param mixed $secretAnswer
     * @return User
     */
    public function setSecretAnswer($secretAnswer)
    {
        $this->secretAnswer = $secretAnswer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretQuestion()
    {
        return self::SECRET_QUESTIONS[$this->secretQuestion];
    }

    /**
     * @param mixed $secretQuestion
     * @return User
     */
    public function setSecretQuestion($secretQuestion)
    {
        $this->secretQuestion = $secretQuestion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param mixed $privateKey
     * @return User
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param mixed $publicKey
     * @return User
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }
}
