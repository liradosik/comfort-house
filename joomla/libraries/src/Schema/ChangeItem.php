<?php

/**
 * Joomla! Content Management System
 *
 * @copyright  (C) 2011 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\Schema;

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseDriver;
use Joomla\Database\Exception\ExecutionFailureException;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Each object represents one query, which is one line from a DDL SQL query.
 * This class is used to check the site's database to see if the DDL query has been run.
 * If not, it provides the ability to fix the database by re-running the DDL query.
 * The queries are parsed from the update files in the folder
 * `administrator/components/com_admin/sql/updates/<database>`.
 * These updates are run automatically if the site was updated using com_installer.
 * However, it is possible that the program files could be updated without updating
 * the database (for example, if a user just copies the new files over the top of an
 * existing installation).
 *
 * This is an abstract class. We need to extend it for each database and add a
 * buildCheckQuery() method that creates the query to check that a DDL query has been run.
 *
 * @since  2.5
 */
abstract class ChangeItem
{
    /**
     * Update file: full path file name where query was found
     *
     * @var    string
     * @since  2.5
     */
    public $file = null;

    /**
     * Update query: query used to change the db schema (one line from the file)
     *
     * @var    string
     * @since  2.5
     */
    public $updateQuery = null;

    /**
     * Check query: query used to check the db schema
     *
     * @var    string
     * @since  2.5
     */
    public $checkQuery = null;

    /**
     * Check query result: expected result of check query if database is up to date
     *
     * @var    string
     * @since  2.5
     */
    public $checkQueryExpected = 1;

    /**
     * DatabaseDriver object
     *
     * @var    DatabaseDriver
     * @since  2.5
     */
    public $db = null;

    /**
     * Query type: To be used in building a language key for a
     * message to tell user what was checked / changed
     * Possible values: ADD_TABLE, ADD_COLUMN, CHANGE_COLUMN_TYPE, ADD_INDEX
     *
     * @var    string
     * @since  2.5
     */
    public $queryType = null;

    /**
     * Array with values for use in a Text::sprintf statement indicating what was checked
     *
     * Tells you what the message should be, based on which elements are defined, as follows:
     *     For ADD_TABLE: table
     *     For ADD_COLUMN: table, column
     *     For CHANGE_COLUMN_TYPE: table, column, type
     *     For ADD_INDEX: table, index
     *
     * @var    array
     * @since  2.5
     */
    public $msgElements = [];

    /**
     * Checked status
     *
     * @var    integer   0=not checked, -1=skipped, -2=failed, 1=succeeded
     * @since  2.5
     */
    public $checkStatus = 0;

    /**
     * Rerun status
     *
     * @var    integer   0=not rerun, -1=skipped, -2=failed, 1=succeeded
     * @since  2.5
     */
    public $rerunStatus = 0;

    /**
     * Constructor: builds check query and message from $updateQuery
     *
     * @param   DatabaseDriver  $db     Database connector object
     * @param   string          $file   Full path name of the sql file
     * @param   string          $query  Text of the sql query (one line of the file)
     *
     * @since   2.5
     */
    public function __construct($db, $file, $query)
    {
        $this->updateQuery = $query;
        $this->file        = $file;
        $this->db          = $db;
        $this->buildCheckQuery();
    }

    /**
     * Returns a reference to the ChangeItem object.
     *
     * @param   DatabaseDriver  $db     Database connector object
     * @param   string          $file   Full path name of the sql file
     * @param   string          $query  Text of the sql query (one line of the file)
     *
     * @return  ChangeItem  instance based on the database driver
     *
     * @since   2.5
     * @throws  \RuntimeException if class for database driver not found
     */
    public static function getInstance($db, $file, $query)
    {
        // Get the class name
        $serverType = $db->getServerType();

        $class = '\\Joomla\\CMS\\Schema\\ChangeItem\\' . ucfirst($serverType) . 'ChangeItem';

        // If the class exists, return it.
        if (class_exists($class)) {
            return new $class($db, $file, $query);
        }

        throw new \RuntimeException(\sprintf('ChangeItem child class not found for the %s database driver', $serverType), 500);
    }

    /**
     * Checks a DDL query to see if it is a known type
     * If yes, build a check query to see if the DDL has been run on the database.
     * If successful, the $msgElements, $queryType, $checkStatus and $checkQuery fields are populated.
     * The $msgElements contains the text to create the user message.
     * The $checkQuery contains the SQL query to check whether the schema change has
     * been run against the current database. The $queryType contains the type of
     * DDL query that was run (for example, CREATE_TABLE, ADD_COLUMN, CHANGE_COLUMN_TYPE, ADD_INDEX).
     * The $checkStatus field is set to zero if the query is created
     *
     * If not successful, $checkQuery is empty and , and $checkStatus is -1.
     * For example, this will happen if the current line is a non-DDL statement.
     *
     * @return void
     *
     * @since  2.5
     */
    abstract protected function buildCheckQuery();

    /**
     * Runs the check query and checks that 1 row is returned
     *
     * @return  integer  1 if success, -1 if skipped, -2 if check failed
     *
     * @since  2.5
     */
    public function check()
    {
        $this->checkStatus = -1;

        if ($this->checkQuery) {
            try {
                $this->db->setQuery($this->checkQuery);
                $rows = $this->db->loadRowList(0);
            } catch (\RuntimeException $e) {
                // Still render the error message from the Exception object
                Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
                $this->checkStatus = -2;

                return $this->checkStatus;
            }

            if (\count($rows) === $this->checkQueryExpected) {
                $this->checkStatus = 1;

                return $this->checkStatus;
            }

            $this->checkStatus = -2;
        }

        return $this->checkStatus;
    }

    /**
     * Runs the update query to apply the change to the database
     *
     * @return  void
     *
     * @since   2.5
     */
    public function fix()
    {
        if ($this->checkStatus === -2) {
            // At this point we have a failed query
            $query = $this->updateQuery;

            try {
                $this->db->setQuery($query);
                $this->db->execute();

                if ($this->check()) {
                    $this->checkStatus = 1;
                    $this->rerunStatus = 1;
                } else {
                    $this->rerunStatus = -2;
                }
            } catch (ExecutionFailureException | \RuntimeException) {
                $this->rerunStatus = -2;
            }
        }
    }
}
