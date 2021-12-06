<?php


namespace App\Converting;


class ArrayToXmlConverter
{
    public function process(array $arr)
    {
        $xmlElement = new \SimpleXMLElement('<rootTag/>');
        $this->arrToXml($arr, $xmlElement);
        return html_entity_decode($xmlElement->asXML(), ENT_NOQUOTES, 'UTF-8');
    }

    private function arrToXml(array $arr, \SimpleXMLElement $xmlElement) {
        foreach ($arr as $k => $v) {
            is_array($v)
                ? $this->arrToXml($v, $xmlElement->addChild(is_numeric($k) ? 'element'.($k+1) : $k))
                : $xmlElement->addChild($k, $v);
        }
    }

}
