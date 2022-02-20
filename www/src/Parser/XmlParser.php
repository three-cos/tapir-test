<?php

namespace Warden\CarAPI\Parser;

use SimpleXMLElement;

class XmlParser extends Parser
{
    /**
     * @inheritdoc
     */
    public function decode(): array
    {
        $parsed_xml = new SimpleXMLElement($this->data);

        $array = ((array) $parsed_xml)['Car'];

        $normalized_array = array_map(fn ($car) => $this->normalize($car), $array);

        return $normalized_array;
    }

    /**
     * Конвертация xml в массив
     *
     * @param  SimpleXMLElement $car
     * @return array
     */
    public function normalize(SimpleXMLElement $car): array
    {
        return [
            "id" => (string) $car->attributes()['id'],
            "brand" => (string) $car->Brand,
            "model" => (string) $car->Model,
            "body_type" => (string) $car->BodyType,
            "engine_type" => (string) $car->EngineType,
            "drive_type" => (string) $car->DriveType,
            "gearbox_type" => (string) $car->GearboxType,
            "year" => (int) $car->Year,
            "price" => (int) $car->Price,
            "mileage" => (int) $car->Mileage,
            "owner_count" => (int) $car->OwnerCount,
        ];
    }
}
