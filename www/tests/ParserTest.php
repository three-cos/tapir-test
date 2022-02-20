<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Warden\CarAPI\Parser\JsonParser;
use Warden\CarAPI\Parser\XmlParser;

class ParserTest extends TestCase
{
    public function testJsonParserWorks()
    {
        $json = <<<JSON
        [
            {
                "id": "3eae0521def81be8536bb9ef80f02431",
                "brand": "Mercedes-Benz",
                "model": "W128",
                "vin": "9E4ED0D320DA36B8",
                "body_type": "Кабриолет",
                "engine_type": "Дизель",
                "drive_type": "Задний",
                "gearbox_type": "АТ",
                "year": 2022,
                "price": 4442800
            },
            {
                "id": "e1dbf489e76c9d934ef7753bfd36f604",
                "brand": "Mercedes-Benz",
                "model": "G-klasse AMG",
                "vin": "A7E91BBDB23C6FC4",
                "body_type": "Минивэн",
                "engine_type": "Электро",
                "drive_type": "Задний",
                "gearbox_type": "АТ",
                "year": 2022,
                "price": 4370300
            },
            {
                "id": "1c035ae312d71dca992cb839be088dc4",
                "brand": "Kia",
                "model": "Niro",
                "vin": "F9F45D654C9EBB64",
                "body_type": "Кабриолет",
                "engine_type": "Гибрид",
                "drive_type": "Задний",
                "gearbox_type": "AMT",
                "year": 2003,
                "price": 2885100
            },
            {
                "id": "b522ddf6551bb677f79b06e3db05e8ca",
                "brand": "Kia",
                "model": "Telluride",
                "vin": "032C048C957A23AB",
                "body_type": "Внедорожник",
                "engine_type": "Газ",
                "drive_type": "Полный",
                "gearbox_type": "АТ",
                "year": 2000,
                "price": 4889900
            },
            {
                "id": "6c887767d3cc103f0c31b33eb8125a24",
                "brand": "Kia",
                "model": "Carnival",
                "vin": "3767EE95A32DAE1B",
                "body_type": "Хетчбэк",
                "engine_type": "Бензин",
                "drive_type": "Задний",
                "gearbox_type": "AMT",
                "year": 2013,
                "price": 4518200
            }
        ]
JSON;

        $parser = new JsonParser($json);

        $result = $parser->decode();

        $this->assertSame($result[0], [
            "id" => "3eae0521def81be8536bb9ef80f02431",
            "brand" => "Mercedes-Benz",
            "model" => "W128",
            "vin" => "9E4ED0D320DA36B8",
            "body_type" => "Кабриолет",
            "engine_type" => "Дизель",
            "drive_type" => "Задний",
            "gearbox_type" => "АТ",
            "year" => 2022,
            "price" => 4442800
        ]);
    }

    public function testXmlParserWorks()
    {
        $xml = <<<XML
        <?xml version="1.0" encoding="utf-8"?>
        <Cars>
            <Car id="ba510207aa0e2607077508911250c494">
                <Brand>BMW</Brand>
                <Model>700</Model>
                <BodyType>Хетчбэк</BodyType>
                <EngineType>Электро</EngineType>
                <DriveType>Полный</DriveType>
                <GearboxType>АТ</GearboxType>
                <Year>2019</Year>
                <Price>4708800</Price>
                <Mileage>290999</Mileage>
                <OwnerCount>1</OwnerCount>
            </Car>
            <Car id="e8b8bab46776b85e8a1432d7f6d4648b">
                <Brand>Volvo</Brand>
                <Model>S80</Model>
                <BodyType>Фургон</BodyType>
                <EngineType>Газ</EngineType>
                <DriveType>Полный</DriveType>
                <GearboxType>АТ</GearboxType>
                <Year>2012</Year>
                <Price>4082500</Price>
                <Mileage>425</Mileage>
                <OwnerCount>1</OwnerCount>
            </Car>
            <Car id="5dbf4e2483dbe0ccb58f25e4ad36d379">
                <Brand>Acura</Brand>
                <Model>Integra</Model>
                <BodyType>Минивэн</BodyType>
                <EngineType>Электро</EngineType>
                <DriveType>Передний</DriveType>
                <GearboxType>АТ</GearboxType>
                <Year>2020</Year>
                <Price>2902700</Price>
                <Mileage>143147</Mileage>
                <OwnerCount>1</OwnerCount>
            </Car>
            <Car id="8095ad21df49675cbba8be104b01f0aa">
                <Brand>ВАЗ (Lada)</Brand>
                <Model>2112</Model>
                <BodyType>Седан</BodyType>
                <EngineType>Газ</EngineType>
                <DriveType>Полный</DriveType>
                <GearboxType>CVT</GearboxType>
                <Year>2014</Year>
                <Price>4538200</Price>
                <Mileage>122455</Mileage>
                <OwnerCount>3</OwnerCount>
            </Car>
        </Cars>
XML;

        $parser = new XmlParser($xml);

        $result = $parser->decode();

        $this->assertSame($result[0], [
            "id" => "ba510207aa0e2607077508911250c494",
            "brand" => "BMW",
            "model" => "700",
            "body_type" => "Хетчбэк",
            "engine_type" => "Электро",
            "drive_type" => "Полный",
            "gearbox_type" => "АТ",
            "year" => 2019,
            "price" => 4708800,
            "mileage" => 290999,
            "owner_count" => 1
        ]);
    }
}
