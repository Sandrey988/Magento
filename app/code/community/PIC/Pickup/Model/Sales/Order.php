<?php
class PIC_Pickup_Model_Sales_Order extends Mage_Sales_Model_Order{
    public function getShippingDescription(){
        $desc = parent::getShippingDescription();
        $pickupObject = $this->getPickupObject();
        if($pickupObject){
            $desc .= 'Store - '.$pickupObject->getStore();
        }
        return $desc;
    }
}