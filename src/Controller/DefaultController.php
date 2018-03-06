<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 1.03.2018
 * Time: 17:09
 */

namespace App\Controller;

use App\Models\BaseController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 * @Route("/")
 */
class DefaultController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        if ($user = $this->getUser()) {
            $balance = $this->getManager()->getRepository('App:Transaction')->getUserBalance($user->getId());

            return $this->render('Default\index.html.twig', ['balance' => $balance]);
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}