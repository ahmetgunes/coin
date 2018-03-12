<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 1.03.2018
 * Time: 17:09
 */

namespace App\Controller;

use App\Models\AccountException;
use App\Models\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/reset-password", name="account_reset_password")
     */
    public function resetPasswordAction(Request $request)
    {
        try {
            if ($request->isMethod('GET')) {
                return $this->render('Account/reset-password.html.twig');
            } else {
                $currentPassword = $request->get('current_password');
                $newPassword = $request->get('new_password');
                $repeatPassword = $request->get('repeat_password');

                if (strlen($newPassword) < 6) {
                    throw new AccountException('Your password should be at least 6 characters long.');
                }

                if ($newPassword != $repeatPassword) {
                    throw new AccountException('Your repeat passwords does not match.');
                }

                $encoder = $this->get('security.password_encoder');
                $user = $this->getUser();

                if (!$encoder->isPasswordValid($user, $currentPassword)) {
                    throw new AccountException('Your current password is wrong.');
                }

                $password = $encoder->encodePassword($user, $newPassword);
                $user->setPassword($password);
                $this->getManager()->merge($user);
                $this->getManager()->flush();

                $this->addFlash('success', 'Your password has been changed successfully!');
                return $this->redirectToRoute('homepage');
            }
        } catch (\Exception $ex) {
            $this->throwError($ex);
            return $this->redirectToRoute('account_reset_password');
        }
    }
}