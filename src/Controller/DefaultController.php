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
        try {
            if ($user = $this->getUser()) {
                $balance = $this->getManager()->getRepository('App:Transaction')->getUserBalance($user->getId());

                return $this->render('Default\index.html.twig', ['balance' => $balance]);
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/history", name="history")
     */
    public function historyAction()
    {
        try {
            $history = $this->getManager()->getRepository('App:Transaction')->findBy(['user' => $this->getUser()]);

            return $this->render('Default\history.html.twig', ['history' => $history]);
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }
}