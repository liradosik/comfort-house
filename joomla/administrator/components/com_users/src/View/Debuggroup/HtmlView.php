<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Users\Administrator\View\Debuggroup;

use Joomla\CMS\Access\Exception\NotAllowed;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\Component\Users\Administrator\Model\DebuggroupModel;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * View class for a list of User Group ACL permissions.
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
    /**
     * List of component actions
     *
     * @var  array
     */
    protected $actions;

    /**
     * The item data.
     *
     * @var   object
     * @since 1.6
     */
    protected $items;

    /**
     * The pagination object.
     *
     * @var   \Joomla\CMS\Pagination\Pagination
     * @since 1.6
     */
    protected $pagination;

    /**
     * The model state.
     *
     * @var   \Joomla\Registry\Registry
     * @since 1.6
     */
    protected $state;

    /**
     * The id and title for the user group.
     *
     * @var   \stdClass
     * @since 4.0.0
     */
    protected $group;

    /**
     * Form object for search filters
     *
     * @var  \Joomla\CMS\Form\Form
     */
    public $filterForm;

    /**
     * The active search filters
     *
     * @var  array
     */
    public $activeFilters;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Access check.
        if (!$this->getCurrentUser()->authorise('core.manage', 'com_users')) {
            throw new NotAllowed(Text::_('JERROR_ALERTNOAUTHOR'), 403);
        }

        /** @var DebuggroupModel $model */
        $model = $this->getModel();

        $this->actions       = $model->getDebugActions();
        $this->items         = $model->getItems();
        $this->pagination    = $model->getPagination();
        $this->state         = $model->getState();
        $this->group         = $model->getGroup();
        $this->filterForm    = $model->getFilterForm();
        $this->activeFilters = $model->getActiveFilters();

        // Check for errors.
        if (\count($errors = $model->getErrors())) {
            throw new GenericDataException(implode("\n", $errors), 500);
        }

        $this->addToolbar();

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolbar()
    {
        $canDo   = ContentHelper::getActions('com_users');
        $toolbar = $this->getDocument()->getToolbar();

        ToolbarHelper::title(Text::sprintf('COM_USERS_VIEW_DEBUG_GROUP_TITLE', $this->group->id, $this->escape($this->group->title)), 'users groups');
        $toolbar->cancel('group.cancel');

        if ($canDo->get('core.admin') || $canDo->get('core.options')) {
            $toolbar->preferences('com_users');
            $toolbar->divider();
        }

        $toolbar->help('Permissions_for_Group');
    }
}
