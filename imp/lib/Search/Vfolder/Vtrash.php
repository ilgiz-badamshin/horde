<?php
/**
 * This class provides a data structure for storing the virtual trash.
 *
 * Copyright 2010-2013 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.
 *
 * @author   Michael Slusarz <slusarz@horde.org>
 * @category Horde
 * @license  http://www.horde.org/licenses/gpl GPL
 * @package  IMP
 */
class IMP_Search_Vfolder_Vtrash extends IMP_Search_Vfolder_Builtin
{
    /**
     * Display this virtual folder in the preferences screen?
     *
     * @var boolean
     */
    public $prefDisplay = false;

    /**
     * Initialization tasks.
     */
    protected function _init()
    {
        $this->_id = 'vtrash';
        $this->_label = _("Virtual Trash");

        $this->add(new IMP_Search_Element_Flag(
            Horde_Imap_Client::FLAG_DELETED,
            true
        ));
    }

    /**
     * Get object properties.
     * Only create mailbox list on demand.
     *
     * @see __get()
     */
    public function __get($name)
    {
        switch ($name) {
        case 'mboxes':
            $iterator = new IMP_Imap_Tree_IteratorFilter_Nocontainers(
                IMP_Imap_Tree_IteratorFilter::create()
            );

            return array_map('strval', iterator_to_array($iterator, true));
        }

        return parent::__get($name);
    }

}
