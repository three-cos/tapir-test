<?php

namespace Warden\CarAPI\Response;

interface Response
{
    /**
     * Установка заголовков ответа
     *
     * @return void
     */
    public function setHeaders(): void;

    /**
     * Установка тела ответа
     *
     * @param  mixed $body
     * @return void
     */
    public function setBody($body): void;
}
