<?php

namespace Warden\CarAPI\Parser;

abstract class Parser
{
    protected $data;

    public function __construct(string $data)
    {
        $this->data = trim($data);
    }

    /**
     * Выбор парсера и возврат массива данных
     *
     * @param  string $file
     * @param  mixed $data
     * @return array
     */
    static public function parse(string $file, $data): array
    {
        $file_info = new \SplFileInfo($file);

        $ext = $file_info->getExtension();

        switch ($ext) {
            case 'json':
                $array = (new JsonParser($data))->decode();
                break;

            case 'xml':
                $array = (new XmlParser($data))->decode();
                break;
        }

        return $array;
    }

    /**
     * Декодирование данных в массив
     *
     * @return array
     */
    abstract public function decode(): array;
}
