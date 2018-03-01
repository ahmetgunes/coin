<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 1.03.2018
 * Time: 17:04
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
    /**
     * @param bool $status
     * @param string|null $message
     * @param array $body
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonResponse(bool $status = true, string $message = null, array $body = [])
    {
        $data = [
            'status' => $status,
            'message' => $message,
            'data' => $body
        ];

        return $this->json($data);
    }

    /**
     * @param \Exception $ex
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * Used to easily (more cleanly) convert exceptions to JSON errors
     */
    protected function throwJsonError(\Exception $ex)
    {
        return $this->jsonResponse(false, $ex->getMessage());
    }
}