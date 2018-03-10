<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 1.03.2018
 * Time: 17:09
 */

namespace App\Controller;

use App\Entity\User;
use App\Models\AccountException;
use App\Models\BaseController;
use App\Models\CustomException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class DefaultController
 * @package App\Controller
 * @Route("/account")
 */
class AccountController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/forgot-password", name="account_forgot_password")
     */
    public function forgotPasswordAction(Request $request)
    {
        try {
            if ($request->isMethod('GET')) {
                $username = $request->get('username');
                $user = $this->getDoctrine()->getRepository('App:User')->findOneBy(['username' => $username]);

                if ($user instanceof User) {
                    return $this->render('Account\forgot-password.html.twig', [
                            'question' => $user->getSecretQuestion(),
                            'username' => $user->getUsername()
                        ]
                    );
                } else {
                    throw new CustomException('No matching user has been found.');
                }
            } else {
                $secret = $request->get('secret');
                $username = $request->get('username');

                $user = $this->getDoctrine()->getRepository('App:User')->findOneBy(['username' => $username]);

                if ($user instanceof User) {
                    $encodedSecret = $this->get('security.password_encoder')->encodePassword($user, $secret);
                    if ($encodedSecret == $user->getSecretAnswer()) {
                        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                        $this->get('security.token_storage')->setToken($token);
                        $this->get('session')->set('_security_main', serialize($token));

                        $event = new InteractiveLoginEvent($request, $token);
                        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                        return $this->redirectToRoute('homepage');
                    } else {
                        throw new AccountException('No username secret match has been found.');
                    }
                } else {
                    throw new AccountException('No username secret match has been found.');
                }
            }
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }
}