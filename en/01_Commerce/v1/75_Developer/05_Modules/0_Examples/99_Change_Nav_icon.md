This module sample shows how you can change a navigation icon in the manager. This module changes the icon for the Modules subnav under Configuration.

````
<?php

namespace modmore\Commerce\Modules\Admin;

use modmore\Commerce\Admin\Generator;
use modmore\Commerce\Events\Admin\TopNavMenu as TopNavMenuEvent;
use modmore\Commerce\Modules\BaseModule;
use modmore\Commerce\Dispatcher\EventDispatcher;
// For modules that need to support 1.2 or before, replace with:
// use Symfony\Component\EventDispatcher\EventDispatcher;
// Please note that is DEPRECATED and will be REMOVED in 2.0

class ChangeIcon extends BaseModule
{
    public function getName()
    {
        return 'Change Icon';
    }

    public function getAuthor()
    {
        return 'Mark Hamstra';
    }

    public function getDescription()
    {
        return 'Changes the menu items to suit Isaac\'s preferences better.';
    }

    public function initialize(EventDispatcher $dispatcher)
    {
        $dispatcher->addListener(\Commerce::EVENT_DASHBOARD_GET_MENU, array($this, 'loadMenuItem'));
    }

    public function loadMenuItem(TopNavMenuEvent $event)
    {
        $items = $event->getItems();

        foreach ($items['configuration']['submenu'] as &$subitem) {
            if ($subitem['key'] === 'configuration/modules') {
                $subitem['icon'] = 'icon icon-bars';
            }
        }

        $event->setItems($items);
    }
}
````
