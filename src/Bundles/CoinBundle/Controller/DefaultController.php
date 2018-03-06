<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 3.03.2018
 * Time: 18:27
 */

namespace App\Bundles\CoinBundle\Controller;


use App\Bundles\CoinBundle\Models\CoinTransaction;
use App\Bundles\CoinBundle\Models\Miner;
use App\Models\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Bundles\CoinBundle\Controller
 * @Route("/")
 */
class DefaultController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/buy")
     */
    public function buyAction()
    {
        try {
            $user = $this->getUser();

            $transactionModel = new CoinTransaction($this->get('doctrine'));
            $hash = $transactionModel->buy($user);

            return $this->jsonResponse(true, $hash);
        } catch (\Exception $ex) {
            return $this->throwJsonError($ex);
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/verify")
     */
    public function verifyAction(Request $request)
    {
        try {
            $hash = $request->get('hash');
            $miner = new Miner($this->get('doctrine.dbal.default_connection'));
            $amount = $miner->verify($hash);

            return $this->jsonResponse(true, $amount);
        } catch (\Exception $ex) {
            return $this->throwJsonError($ex);
        }
    }
}