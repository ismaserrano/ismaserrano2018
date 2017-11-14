<?php

namespace Ismaserrano\PortfolioBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectPagePart
 *
 * @ORM\Table(name="ismaserrano_portfoliobundle_project_page_parts")
 * @ORM\Entity
 */
class ProjectPagePart extends \Ismaserrano\PortfolioBundle\Entity\PageParts\AbstractPagePart
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ismaserrano\PortfolioBundle\Entity\Project", inversedBy="projectpageparts")
     * @ORM\JoinTable(name="ismaserrano_portfoliobundle_project_page_part_project",
     *   joinColumns={
     *     @ORM\JoinColumn(name="project_page_part_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     *   }
     * )
     */
    private $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add project
     *
     * @param \Ismaserrano\PortfolioBundle\Entity\Project $project
     *
     * @return ProjectPagePart
     */
    public function addProject(\Ismaserrano\PortfolioBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \Ismaserrano\PortfolioBundle\Entity\Project $project
     */
    public function removeProject(\Ismaserrano\PortfolioBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'IsmaserranoPortfolioBundle:PageParts:ProjectPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Ismaserrano\PortfolioBundle\Form\PageParts\ProjectPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Ismaserrano\PortfolioBundle\Form\PageParts\ProjectPagePartAdminType();
    }
}
