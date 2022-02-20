<?php

namespace Warden\CarAPI\Parser;

class JsonParser extends Parser
{
    /**
     * @inheritdoc
     */
    public function decode(): array
    {
        return json_decode($this->data, null, 512, JSON_OBJECT_AS_ARRAY);
    }
}
