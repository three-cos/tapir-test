<?php

namespace Warden\CarAPI\Response;

class JsonResponse implements Response
{
    /**
     * @inheritdoc
     */
    public function setHeaders(): void
    {
        header('Content-Type: application/json; charset=utf-8');
    }

    /**
     * @inheritdoc
     */
    public function setBody($data): void
    {
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
