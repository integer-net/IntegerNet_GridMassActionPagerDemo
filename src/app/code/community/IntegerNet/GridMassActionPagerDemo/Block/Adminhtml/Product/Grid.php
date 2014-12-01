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
 * Class IntegerNet_GridMassActionPagerDemo_Block_Adminhtml_Product_Grid
 */
class IntegerNet_GridMassActionPagerDemo_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('product_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setData('use_ajax', true);
    }

    /**
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     * @throws Mage_Core_Exception
     */
    protected function _prepareCollection()
    {
        /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('attribute_set_id');
        $collection->addAttributeToSelect('type_id');
        $collection->addAttributeToSelect('price');
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');

        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('ID'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'entity_id',
            ));

        $this->addColumn('name',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Name'),
                'index' => 'name',
            ));

        $this->addColumn('type',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
            ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Attrib. Set Name'),
                'width' => '100px',
                'index' => 'attribute_set_id',
                'type' => 'options',
                'options' => $sets,
            ));

        $this->addColumn('sku',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
            ));

        $this->addColumn('price',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Price'),
                'type' => 'price',
                'currency_code' => Mage::app()->getDefaultStoreView()->getBaseCurrency()->getCode(),
                'index' => 'price',
            ));

        $this->addColumn('visibility',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Visibility'),
                'width' => '70px',
                'index' => 'visibility',
                'type' => 'options',
                'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
            ));

        $this->addColumn('status',
            array(
                'header' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Status'),
                'width' => '70px',
                'index' => 'status',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
            ));

        return parent::_prepareColumns();
    }

    /**
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setData('form_field_name', 'id');
        $this->getMassactionBlock()->setData('use_ajax', true);
        $this->setData('no_filter_massaction_column', true);

        $this->getMassactionBlock()->addItem('export', array(
            'label' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Export'),
            'url' => $this->getUrl('*/*/massExport'),
            'confirm' => Mage::helper('integernet_gridmassactionpagerdemo')->__('Are you sure?'),
            'complete' => 'integerNetGridMassActionPager',
        ));

        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * @param $row
     * @return null
     */
    public function getRowUrl($row)
    {
        return null;
    }
}
