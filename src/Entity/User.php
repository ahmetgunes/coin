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
     * @return mixed
     */
    public function getSecretAnswer()
    {
        return $this->secretAnswer;
    }

    /**
     * @param mixed $secretAnswer
     */
    public function setSecretAnswer($secretAnswer): void
    {
        $this->secretAnswer = $secretAnswer;
    }

    /**
     * @return mixed
     */
    public function getSecretQuestion()
    {
        return $this->secretQuestion;
    }

    /**
     * @param mixed $secretQuestion
     */
    public function setSecretQuestion($secretQuestion): void
    {
        $this->secretQuestion = $secretQuestion;
    }
}
