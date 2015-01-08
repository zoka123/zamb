<?php

namespace Zantolov\Zamb\Controller;

class BaseApiController extends \Controller
{

    /**
     * Returns array structured as successful response
     *
     * @param array $data
     * @return array
     */
    public function getSuccessResponse($data = array())
    {
        return array(
            'status' => 1,
            'data' => $data,
        );
    }

    /**
     * Returns array structured as unsuccessful response
     *
     * @param array $data
     * @return array
     */
    public function getErrorResponse($data = array())
    {
        return array(
            'status' => 0,
            'data' => $data,
        );
    }

}