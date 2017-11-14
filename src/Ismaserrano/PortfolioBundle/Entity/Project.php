<?php

namespace Ismaserrano\PortfolioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use Ismaserrano\PortfolioBundle\Entity\PageParts\ImageGalleryItemPagePart;
use Ismaserrano\PortfolioBundle\Entity\PageParts\ProjectPagePart;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Sluggable\Util\Urlizer;

/**
 * Projects
 *
 * @ORM\Table(name="ismaserrano_portfoliobundle_projects")
 * @ORM\Entity(repositoryClass="Ismaserrano\PortfolioBundle\Repository\ProjectRepository")
 */
class Project extends \Kunstmaan\AdminBundle\Entity\AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     * @Assert\Regex("/^[a-zA-Z0-9\-_\/]+$/")
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="Ismaserrano\PortfolioBundle\Entity\PageParts\ImageGalleryItemPagePart", mappedBy="project", cascade={"persist"}, orphanRemoval=true, fetch="EAGER")
     */
    private $images;

    /**
     * @var PersistentCollection
     * @ORM\ManyToMany(targetEntity="Ismaserrano\PortfolioBundle\Entity\PageParts\ProjectPagePart", mappedBy="project")
     */
    private $projectpageparts;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->setCreated(new \DateTime('now'));
        $this->setSlug(Urlizer::urlize($this->getTitle()));
    }

    public function __toString()
    {
        return $this->title;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Projects
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Projects
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set imagesAltText
     *
     * @param string $imagesAltText
     *
     * @return Projects
     */
    public function setImagesAltText($imagesAltText)
    {
        $this->imagesAltText = $imagesAltText;

        return $this;
    }

    /**
     * Get imagesAltText
     *
     * @return string
     */
    public function getImagesAltText()
    {
        return $this->imagesAltText;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Projects
     */
    public function setSlug($slug)
    {
        $this->slug = (empty($slug) || strlen($slug)==0) ? Urlizer::urlize($this->getTitle()) : Urlizer::urlize($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Projects
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Projects
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set images
     *
     * @param \Kunstmaan\MediaBundle\Entity\Media $images
     *
     * @return Projects
     */
    public function setImages(ArrayCollection $images = null)
    {
        foreach ($images as $item) {
            $this->addImage($item);
        }
//        $this->images = $images;
//
        return $this;
    }

    /**
     * Get images
     *
     * @return \Kunstmaan\MediaBundle\Entity\Media
     */
    public function getImages()
    {
        return $this->images;
    }


    public function addImage(ImageGalleryItemPagePart $image)
    {
        $image->setProject($this);
        $this->images->add($image);
    }


    public function removeImage(ImageGalleryItemPagePart $image)
    {
        $this->images->removeElement($image);
    }

    public function addProjectPagePart(ProjectPagePart $projectpagepart)
    {
        if ($this->projectpageparts->contains($projectpagepart)) {
            return;
        }

        $this->projectpagepart->add($projectpagepart);
        $projectpagepart->addProject($this);
    }


    public function removeProjectPagePart(ProjectPagePart $projectpagepart)
    {
        if (!$this->projectpageparts->contains($projectpagepart)) {
            return;
        }

        $this->projectpagepart->removeElement($projectpagepart);
        $projectpagepart->removeProject($this);
    }

}