<?php
class PIC_Pickup_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code = 'pickup';

    public function getFormBlock(){
        return 'pickup/pickup';
    }

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');

        $weight = $request->getPackageWeight();

        /** @var Mage_Shipping_Model_Rate_Result_Method $method */
        $method = Mage::getModel('shipping/rate_result_method');
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        if($weight > $this->getConfigData('max_packet_weight')) {
            $this->_getBoxMethod($weight,$method);
        } else {
            $this->_getPacketMethod($weight,$method);
        }

        $result->append($method);

        return $result;
    }

    protected function _getPacketMethod($weight,$method)
    {
        $method->setMethod($this->_code);
        $method->setMethodTitle('Pickup');

        $config = Mage::helper('pickup')->getConfigFieldOne();

        foreach ($config as $row) {
            Mage::log($row['pickup_name']);
        }




        $sum = Mage::helper('pickup')->getPacketCost($weight);
        $method->setPrice($sum/19050);
    }

    protected function _getBoxMethod($weight,$method)
    {
        $method->setMethod($this->_code);
        $method->setMethodTitle('Belpost parcel');
        $sum = Mage::helper('pickup')->getBoxCost($weight);
        $method->setPrice($sum/19050);
    }

    public function isTrackingAvailable()
    {
        return false;
    }

    public function getAllowedMethods()
    {
        return array(
            'box' => 'Belpost parcel',
            'packet' => 'Belpost packet'
        );
    }
}