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
 * Class IntegerNet_GridMassActionPagerDemo_Adminhtml_Integernetgridmassactionpagerdemo_IndexController
 */
class IntegerNet_GridMassActionPagerDemo_Adminhtml_Integernetgridmassactionpagerdemo_IndexController extends Mage_Adminhtml_Controller_Action
{


    /**
     *
     */
    public function indexAction()
    {
        $this->loadLayout();

        Mage::helper('integernet_gridmassactionpager')->addScript();

        $this->_setActiveMenu('integernet_gridmassactionpagerdemo');
        $this->_title($this->__('GridMassActionPager Demo'));

        $this->_addContent($this->getLayout()->createBlock('integernet_gridmassactionpagerdemo/adminhtml_product'));

        $this->renderLayout();
    }


    /**
     *  Grid Action
     */
    public function gridAction()
    {
        /** @var IntegerNet_GridMassActionPagerDemo_Block_Adminhtml_Product_Grid $grid */
        $grid = $this->getLayout()->createBlock('integernet_gridmassactionpagerdemo/adminhtml_product_grid');

        $this->getResponse()->setBody($grid->toHtml());
    }


    /**
     * Mass Export Action
     */
    public function massExportAction()
    {
        /** @var IntegerNet_GridMassActionPager_Model_GridMassActionPager $gridMassActionPager */
        $gridMassActionPager = Mage::getModel('integernet_gridmassactionpager/gridMassActionPager');

        if ($productIds = (array)$this->getRequest()->getParam('id')) {

            $gridMassActionPager->init($productIds, 100);

        } elseif ($pageIds = $gridMassActionPager->getPageIds()) {

            $this->_process($pageIds);

            $gridMassActionPager->next();
        }

        $message = Mage::helper('integernet_gridmassactionpagerdemo')->__('Export product<br />{{from}} to {{to}} of {{of}}');

        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->getResponse()->setBody($gridMassActionPager->getStatus(true, $message));
    }


    /**
     * @param $productIds
     */
    protected function _process($productIds)
    {
        Mage::log($productIds, null, 'IntegerNet_GridMassActionPagerDemo.log', true);
    }
}
