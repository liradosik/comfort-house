<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_associations
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Associations\Administrator\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\Component\Associations\Administrator\Helper\AssociationsHelper;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Field listing item languages
 *
 * @since  3.7.0
 */
class ItemlanguageField extends ListField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  3.7.0
     */
    protected $type = 'Itemlanguage';

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since  3.7.0
     */
    protected function getOptions()
    {
        $input = Factory::getApplication()->getInput();

        [$extensionName, $typeName] = explode('.', $input->get('itemtype', '', 'string'), 2);

        // Get the extension specific helper method
        $helper = AssociationsHelper::getExtensionHelper($extensionName);

        $languageField = $helper->getTypeFieldName($typeName, 'language');
        $referenceId   = $input->get('id', 0, 'int');
        $reference     = ArrayHelper::fromObject(AssociationsHelper::getItem($extensionName, $typeName, $referenceId));
        $referenceLang = $reference[$languageField];

        // Get item associations given ID and item type
        $associations = AssociationsHelper::getAssociationList($extensionName, $typeName, $referenceId);

        // Check if user can create items in this component item type.
        $canCreate = AssociationsHelper::allowAdd($extensionName, $typeName);

        // Gets existing languages.
        $existingLanguages = LanguageHelper::getContentLanguages([0, 1], false);

        $options = [];

        // Each option has the format "<lang>|<id>", example: "en-GB|1"
        foreach ($existingLanguages as $langCode => $language) {
            // If language code is equal to reference language we don't need it.
            if ($language->lang_code == $referenceLang) {
                continue;
            }

            $options[$langCode]       = new \stdClass();
            $options[$langCode]->text = $language->title;

            // If association exists in this language.
            if (isset($associations[$language->lang_code])) {
                $itemId                    = (int) $associations[$language->lang_code]['id'];
                $options[$langCode]->value = $language->lang_code . ':' . $itemId . ':edit';

                // Check if user does have permission to edit the associated item.
                $canEdit = AssociationsHelper::allowEdit($extensionName, $typeName, $itemId);

                // Check if item can be checked out
                $canCheckout = AssociationsHelper::canCheckinItem($extensionName, $typeName, $itemId);

                // Disable language if user is not allowed to edit the item associated to it.
                $options[$langCode]->disable = !($canEdit && $canCheckout);
            } else {
                // New item, id = 0 and disabled if user is not allowed to create new items.
                $options[$langCode]->value = $language->lang_code . ':0:add';

                // Disable language if user is not allowed to create items.
                $options[$langCode]->disable = !$canCreate;
            }
        }

        return array_merge(parent::getOptions(), $options);
    }
}
