<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 1.03.2018
 * Time: 17:09
 */

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 * @Route("/")
 */
class DefaultController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $this->get('security.password_encoder');
        return $this->render('base.html.twig');
    }
}