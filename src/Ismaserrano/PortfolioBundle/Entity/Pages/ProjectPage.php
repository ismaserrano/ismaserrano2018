<?php

namespace Ismaserrano\PortfolioBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectPage
 *
 * @ORM\Table(name="ismaserrano_portfoliobundle_project_pages")
 * @ORM\Entity
 */
class ProjectPage extends \Kunstmaan\NodeBundle\Entity\AbstractPage implements \Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface
{
    /**
     * @var \Ismaserrano\PortfolioBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity="Ismaserrano\PortfolioBundle\Entity\Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * })
     */
    private $project;


    /**
     * Set project
     *
     * @param \Ismaserrano\PortfolioBundle\Entity\Project $project
     *
     * @return ProjectPage
     */
    public function setProject(\Ismaserrano\PortfolioBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Ismaserrano\PortfolioBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }    /**
     * Returns the default backend form type for this page
     *
     * @return \Ismaserrano\PortfolioBundle\Form\Pages\ProjectPageAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Ismaserrano\PortfolioBundle\Form\Pages\ProjectPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return [
            'IsmaserranoPortfolioBundle:main',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return [
            'IsmaserranoPortfolioBundle:contentpage',
        ];
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'IsmaserranoPortfolioBundle:Pages:Common/view.html.twig';
    }
}
