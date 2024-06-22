<?php

use dokuwiki\Extension\ActionPlugin;
use dokuwiki\Extension\EventHandler;
use dokuwiki\Extension\Event;
use dokuwiki\Subscriptions\SubscriberManager;

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
        $controller->register_hook('IO_WIKIPAGE_WRITE', 'BEFORE', $this, 'handleIoWikipageWrite');
    }

    /**
     * Event handler for IO_WIKIPAGE_WRITE
     *
     * @see https://www.dokuwiki.org/devel:events:IO_WIKIPAGE_WRITE
     * @param Event $event Event object
     * @param mixed $param optional parameter passed when event was registered
     * @return void
     */
     
    private function str_contains($string, $subString) 
    { 
        $len = strlen($subString); 
        if ($len == 0) { 
            return false; 
        } 
        return (strpos($string, $subString) !== False); 
    }  

    private function endsWith($string, $endString) 
    { 
        $len = strlen($endString); 
        if ($len == 0) { 
            return true; 
        } 
        return (substr($string, -$len) === $endString); 
    }  
      
     
    public function handleIoWikipageWrite(Event $event, $param)
    {
        global $ID;
        $filename = $event->data[0][0];
        
        if ($this->endsWith($filename,"gz")) {
            // skip this file - this is saving the backup data, so ignore as duplicate
            return;
        }

        $new_page = $event->data[0][1];
        $content = $this->getConf('content');
        if (! $this->getConf('case_sensitive')) {
            $new_page = strtolower($new_page);
            $content = strtolower($content);
        }
        $new_found = $this->str_contains($new_page, $content);
        if ($new_found) {
            \dokuwiki\Logger::error("new stuff found");
            $users = $this->getConf('users');
            $sub = new SubscriberManager();
            foreach ($users as $user) {
                \dokuwiki\Logger::error("user", $user);
                $sub->add($ID, $user, 'every');
            }
        }           
    }
}
