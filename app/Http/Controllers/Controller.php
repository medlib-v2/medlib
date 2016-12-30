<?php

namespace Medlib\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var int $statusCode
     */
    protected $statusCode = 200;

    /**
     * @return $statusCode
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
     *
     * @return Response
     */
    public function responseNotSaved($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->responseWithError($message);
    }

    /**
     *
     * @param  string  $com_message_pump()
     * @return Response
     */
    public function responseNotFound($message = 'Item not found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->responseWithError($message);
    }

    /**
     * @param string $message
     */
    public function responseCreated($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->response([
            /**
             * some people like to use status => 'failed'
             */
            'message' => $message
        ]);
    }
    /**
     * @param array $data
     *
     * @param array $headers
     */
    public function response($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }
    /**
     *  @param string $message
     */
    public function responseWithError($message)
    {
        return $this->response([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * @param LengthAwarePaginator $lessons
     * @param array $data
     * @return mixed
     */
    protected function responseWithPagination(LengthAwarePaginator $lessons, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count'    => $lessons->total(),
                'total_pages'    => ceil($lessons->total() / $lessons->perPage()),
                'current_page'    => $lessons->currentPage(),
                'limit'            => $lessons->perPage()
            ]
        ]);
        return $this->response($data);
    }
}
