<?php

namespace Antonowano\QiwiTopup\Convert;

class XmlConvert
{
    public function bool(?\SimpleXMLElement $element): ?bool
    {
        if ($this->isNull($element)) {
            return null;
        }

        return $element == 'true' || $element == '1';
    }

    public function string(?\SimpleXMLElement $element): ?string
    {
        if ($this->isNull($element)) {
            return null;
        }

        return strval($element);
    }

    public function int(?\SimpleXMLElement $element): ?int
    {
        if ($this->isNull($element)) {
            return null;
        }

        return intval($element);
    }

    public function float(?\SimpleXMLElement $element): ?float
    {
        if ($this->isNull($element)) {
            return null;
        }

        return floatval($element);
    }

    public function datetime(?\SimpleXMLElement $element, $format): ?\DateTime
    {
        if ($this->isNull($element)) {
            return null;
        }

        return \DateTime::createFromFormat($format, strval($element));
    }

    public function balances(?\SimpleXMLElement $balances): ?array
    {
        if ($this->isNull($balances)) {
            return null;
        }

        $result = [];

        foreach ($balances->{'balance'} as $balance) {
            $result[(int) $balance['code']] = (float) $balance;
        }

        return $result;
    }

    private function isNull(?\SimpleXMLElement $element): bool
    {
        return $element === null || !isset($element[0]);
    }
}
