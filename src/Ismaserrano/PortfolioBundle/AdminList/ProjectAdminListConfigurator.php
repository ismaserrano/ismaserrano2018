<?php

namespace Ismaserrano\PortfolioBundle\AdminList;

use Doctrine\ORM\EntityManager;

use Kunstmaan\AdminBundle\Helper\Security\Acl\AclHelper;
use Kunstmaan\AdminListBundle\AdminList\Configurator\AbstractDoctrineORMAdminListConfigurator;
use Kunstmaan\AdminListBundle\AdminList\FilterType\ORM;
use Kunstmaan\AdminListBundle\AdminList\SortableInterface;
use Ismaserrano\PortfolioBundle\Form\ProjectAdminType;

/**
 * The admin list configurator for Project
 */
class ProjectAdminListConfigurator extends AbstractDoctrineORMAdminListConfigurator implements SortableInterface {
    /**
     * @param EntityManager $em        The entity manager
     * @param AclHelper     $aclHelper The acl helper
     */
    public function __construct(EntityManager $em, AclHelper $aclHelper = null)
    {
        parent::__construct($em, $aclHelper);
        $this->setAdminType(new ProjectAdminType());
    }

    /**
     * Configure the visible columns
     */
    public function buildFields()
    {
        $this->addField('title', 'Title', true);
        $this->addField('body', 'Body', true, 'IsmaserranoPortfolioBundle:AdminList\Project:description.html.twig');
        $this->addField('images', 'Images', true, 'IsmaserranoPortfolioBundle:AdminList\Project:image.html.twig');
        $this->addField('slug', 'Slug', true);
        $this->addField('created', 'Created', true);
        $this->addField('status', 'Status', true, 'IsmaserranoPortfolioBundle:AdminList:online.html.twig');
    }

    /**
     * Build filters for admin list
     */
    public function buildFilters()
    {
        $this->addFilter('title', new ORM\StringFilterType('title'), 'Title');
        $this->addFilter('body', new ORM\StringFilterType('body'), 'Body');
        $this->addFilter('slug', new ORM\StringFilterType('slug'), 'Slug');
        $this->addFilter('created', new ORM\DateFilterType('created'), 'Created');
        $this->addFilter('status', new ORM\BooleanFilterType('status'), 'Status');
    }

    /**
     * Get bundle name
     *
     * @return string
     */
    public function getBundleName()
    {
        return 'IsmaserranoPortfolioBundle';
    }

    /**
     * Get entity name
     *
     * @return string
     */
    public function getEntityName()
    {
        return 'Project';
    }

    /**
     * Get sortable field name
     *
     * @return string
     */
    public function getSortableField()
    {
        return "id";
    }

    public function canExport()
    {
        return true;
    }

}
