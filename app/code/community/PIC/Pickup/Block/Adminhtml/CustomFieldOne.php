<?php

class PIC_Pickup_Block_Adminhtml_CustomFieldOne
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{

//    public function __construct()
//    {
//        /** @var PIC_Pickup_Helper_Data $helper */
//        $helper = Mage::helper('pic_pickup');
//
//        $this->addColumn('pickup_name', array(
//        'style' => 'width:200px',
//        'label' => $helper->__('Pickup'),
//        ));
//
//        parent::__construct();
//    }
    public function _prepareToRender()
    {
        $this->addColumn('pickup_name', array(
            'label' => Mage::helper('pickup')->__('Pickup'),
            'style' => 'width:150px',
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('pickup')->__('Add');
    }
}