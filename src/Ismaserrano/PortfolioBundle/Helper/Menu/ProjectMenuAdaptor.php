<?php

namespace Ismaserrano\PortfolioBundle\Helper\Menu;

use Doctrine\ORM\EntityManager;
use Kunstmaan\AdminBundle\Helper\Menu\MenuAdaptorInterface;
use Kunstmaan\AdminBundle\Helper\Menu\MenuBuilder;
use Kunstmaan\AdminBundle\Helper\Menu\MenuItem;
use Kunstmaan\AdminBundle\Helper\Menu\TopMenuItem;
use Symfony\Component\HttpFoundation\Request;


class ProjectMenuAdaptor implements MenuAdaptorInterface
{
    private $overviewpageIds = null;

    private $em;

    /**
     * @param EntityManager $em The entity manager
     */
    public function __construct(EntityManager $em)
    {
	    $this->em = $em;
    }

    public function adaptChildren(MenuBuilder $menu, array &$children, MenuItem $parent = null, Request $request = null)
    {
        if (is_null($this->overviewpageIds)) {
            $overviewPageNodes = $this->em->getRepository('KunstmaanNodeBundle:Node')->findByRefEntityName('Ismaserrano\\PortfolioBundle\\Entity\\Project');
            $this->overviewpageIds = array();
            foreach ($overviewPageNodes as $overviewPageNode) {
                $this->overviewpageIds[] = $overviewPageNode->getId();
            }
        }

        if (is_null($parent)) {
            $menuItem = new TopMenuItem($menu);
            $menuItem
                ->setRoute('ismaserranoportfoliobundle_admin_project')
                ->setLabel('Projects')
                ->setUniqueId('projects');
            if (stripos($request->attributes->get('_route'), $menuItem->getRoute()) === 0) {
                $menuItem->setActive(true);
                if (!is_null($parent)) $parent->setActive(true);
            }
            $children[] = $menuItem;
        }
    }
}
