<?php

namespace Warden\CarAPI\Response;

use SimpleXMLElement;

class XmlResponse implements Response
{
    /**
     * @inheritdoc
     */
    public function setHeaders(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
    }

    /**
     * @inheritdoc
     */
    public function setBody($data): void
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Cars></Cars>');
        $xml->addAttribute('total', $data['total']);
        $xml->addAttribute('page', $data['page']);

        foreach ($data['result'] as $car_attributes) {
            $car = $xml->addChild('Car');

            $car->addAttribute('id', $car_attributes['id']);
            unset($car_attributes['id']);

            foreach ($car_attributes as $attribute => $value) {
                $car->addChild($attribute, $value);
            }
        }

        echo $xml->asXML();
    }
}
