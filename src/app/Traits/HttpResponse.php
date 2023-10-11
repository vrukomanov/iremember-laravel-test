<?php

namespace App\Traits;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

trait HttpResponse
{
    public function success(array $data = [], ?string $message = null, int $code = 200 ): ?Response
    {
        if (!($this instanceof Controller)) {
            return null;
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error(array $data = [], ?string $message = null, int $code = 400 ): ?Response
    {
        if (!($this instanceof Controller)) {
            return null;
        }

        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
