<?php

declare(strict_types=1);

namespace Bluethinkinc\CancelOrder\Block\Adminhtml\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;

class DField extends AbstractFieldArray
{

    private const OPTION_EXTRA_ATTRS = 'option_extra_attrs';

    private const TEXT_FIELD = 'text_field';

    private const OPTION_ = 'option_';

    /**
     * Prepare dynamic fields
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            self::TEXT_FIELD,
            [
                'label' => __('Text Field'),
                'class' => 'required-entry'
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New Row');
    }

    /**
     * Prepare Array Row
     *
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $options = [];
        $dropdownField = $row->getDropdownField();
        if ($dropdownField !== null) {
            $options[self::OPTION_. $this->getDropdownFieldRenderer()
            ->calcOptionHash($dropdownField)] = 'selected="selected"';
        }
        $row->setData(self::OPTION_EXTRA_ATTRS, $options);
    }
}
