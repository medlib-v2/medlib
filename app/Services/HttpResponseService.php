<?php

namespace Medlib\Services;

use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response as IlluminateResponse;

trait HttpResponseService
{
    /**
     * @var int $statusCode
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @return int $statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return \Medlib\Http\Controllers\Controller
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNotSaved($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->responseWithError($message);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNotFound($message = 'Item not found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->responseWithError($message);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseCreated($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->response([
            /**
             * some people like to use status => 'failed'
             */
            'data' => $message
        ]);
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param string|array $message
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithError($message, $status = null)
    {
        if ($status) $this->setStatusCode($status);

        return $this->response([
            'success' => false,
            'data' => $message,
            'status_code' => $status ? $status : $this->getStatusCode()
        ]);
    }

    /**
     * @param string $message
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithSuccess($message, $status = null)
    {
        if ($status) $this->setStatusCode($status);

        return $this->response([
            'success' => true,
            'data' => $message,
            'status_code' => $status ? $status : $this->getStatusCode()
        ]);
    }

    /**
     * @param LengthAwarePaginator $pagination
     * @param array $data
     * @return mixed
     */
    protected function responseWithPagination(LengthAwarePaginator $pagination, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count'    => $pagination->total(),
                'total_pages'    => ceil($pagination->total() / $pagination->perPage()),
                'current_page'    => $pagination->currentPage(),
                'limit'            => $pagination->perPage()
            ]
        ]);
        return $this->response($data);
    }
}