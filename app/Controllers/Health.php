<?php

namespace App\Controllers;

use Throwable;

final class Health extends BaseController
{
    public function index()
    {
        try {
            db_connect()->query('SELECT 1');

            return $this->response->setJSON([
                'status'   => 'ok',
                'database' => 'connected',
            ]);
        } catch (Throwable $exception) {
            log_message('error', 'Health check failed: {message}', ['message' => $exception->getMessage()]);

            return $this->response->setStatusCode(503)->setJSON([
                'status'   => 'unavailable',
                'database' => 'disconnected',
            ]);
        }
    }
}
