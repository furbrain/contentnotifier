<?php

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\EventHandler;
use dokuwiki\Extension\Event;

/**
 * DokuWiki Plugin contentnotifier (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author Phil Underwood <beardydoc@gmail.com>
 */
class action_plugin_contentnotifier extends ActionPlugin
{
    /** @inheritDoc */
    public function register(EventHandler $controller)
    {
        $controller->register_hook('IO_WIKIPAGE_WRITE', 'AFTER|BEFORE', $this, 'handleIoWikipageWrite');
    }

    /**
     * Event handler for IO_WIKIPAGE_WRITE
     *
     * @see https://www.dokuwiki.org/devel:events:IO_WIKIPAGE_WRITE
     * @param Event $event Event object
     * @param mixed $param optional parameter passed when event was registered
     * @return void
     */
    public function handleIoWikipageWrite(Event $event, $param)
    {
    }
}
