<?php
/**
 * integer_net GmbH Magento Module
 *
 * @package    IntegerNet_GridMassActionPagerDemo
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     integer_net GmbH <info@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */

/**
 * Class IntegerNet_GridMassActionPagerDemo_Block_Adminhtml_Product
 */
class IntegerNet_GridMassActionPagerDemo_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    protected $_blockGroup = 'integernet_gridmassactionpagerdemo';
    protected $_controller = 'adminhtml_product';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->_removeButton('add');

        $this->_headerText = Mage::helper('integernet_gridmassactionpagerdemo')->__('GridMassActionPager Demo');
    }

}
