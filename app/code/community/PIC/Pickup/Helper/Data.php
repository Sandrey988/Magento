<?php

class PIC_Pickup_Helper_Data extends Mage_Core_Helper_Abstract{

    const XML_PATH_CONFIG_FIELD_ONE = 'carriers/pickup/custom_field_one';

    public function getConfigFieldOne()
    {
        $config = Mage::getStoreConfig(self::XML_PATH_CONFIG_FIELD_ONE);

        if (!$config) {
            return array();
        }

        try {
            $config = Mage::helper('core/unserializeArray')->unserialize($config);
        } catch (Exception $exception) {
            Mage::logException($exception);
            $config = array();
        }

        return $config;
    }

    public function getBoxCost($weight)
    {
        $request = new Zend_Http_Client();
        $request->setUri('http://tarifikator.belpost.by/forms/international/ems.php');

        $request->setParameterPost(array(
            'who'=>'ur',
            'type'=>'goods',
            'to'=>'n10',
            'weight'=>$weight
        ));

        $response = $request->request(Zend_Http_Client::POST);

        $html = $response->getBody();

        $tag_regex = "/<blockquote>(.*)<\/blockquote>/im";
        $sum_reqex = "/(\d+)/is";
        preg_match_all($tag_regex,
            $html,
            $matches,
            PREG_PATTERN_ORDER);
        if(isset($matches[1]) && isset($matches[1][0])) {
            preg_match($sum_reqex,$matches[1][0],$matches);
            if(isset($matches[0])) {
                return $matches[0];
            }
        }
        return Mage::getStoreConfig('carriers/pickup/price');
    }

    public function getPacketCost($weight)
    {
        $request = new Zend_Http_Client();
        $request->setUri('http://tarifikator.belpost.by/forms/international/packet.php');
        $request->setParameterPost(array(
            'who'=>'ur',
            'type'=>'registered',
            'priority'=>'priority',
            'to'=>'other',
            'weight'=>$weight
        ));
        $response = $request->request(Zend_Http_Client::POST);

        $html = $response->getBody();

        $tag_regex = "/<blockquote>(.*)<\/blockquote>/im";
        $sum_reqex = "/(\d+)/is";
        preg_match_all($tag_regex,
            $html,
            $matches,
            PREG_PATTERN_ORDER);
        if(isset($matches[1]) && isset($matches[1][0])) {
            preg_match($sum_reqex,$matches[1][0],$matches);
            if(isset($matches[0])) {
                return (float)$matches[0];
            }
        }
        return Mage::getStoreConfig('carriers/pickup/price');
    }



}
