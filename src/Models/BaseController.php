<?php
/**
 * Created by A.
 * User: ahmetgunes
 * Date: 1.03.2018
 * Time: 17:04
 */

namespace App\Models;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

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
        return $this->jsonResponse(false, self::extractMessage($ex));
    }

    protected function throwError(\Exception $ex)
    {
        $this->addFlash('danger', self::extractMessage($ex));
    }

    /**
     * @param \Exception $ex
     * @return string
     */
    protected static function extractMessage(\Exception $ex)
    {
        return $ex->getMessage();
        return $ex instanceof CustomException ? $ex->getMessage() : CustomException::DEFAULT_MESSAGE;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }
}