<?php
/**
 * Smartworking_CustomOrderProcessing Add New Row Form Admin Block.
 * @category    Smartworking
 * @package     Smartworking_CustomOrderProcessing
 * @author      Smartworking Software Private Limited
 *
 */
namespace Smartworking\CustomOrderProcessing\Block\Adminhtml\Grid\Edit;


/**
 * Adminhtml Add New Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Smartworking\CustomOrderProcessing\Model\Status $options,
        array $data = []
    ) 
    {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form', 
                            'enctype' => 'multipart/form-data', 
                            'action' => $this->getData('action'), 
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('wkgrid_');
        if ($model->getStatusId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Status'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('status_id', 'hidden', ['name' => 'status_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Status'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'status_code',
            'text',
            [
                'name' => 'status_code',
                'label' => __('Status Code'),
                'id' => 'status_code',
                'title' => __('Status Code'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        $fieldset->addField(
            'label',
            'text',
            [
                'name' => 'label',
                'label' => __('Label'),
                'id' => 'label',
                'title' => __('Label'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );


        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'id' => 'is_active',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}