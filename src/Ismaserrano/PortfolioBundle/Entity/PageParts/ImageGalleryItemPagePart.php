<?php

namespace Ismaserrano\PortfolioBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;
use Ismaserrano\PortfolioBundle\Entity\Project;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageGalleryItemPagePart
 *
 * @ORM\Table(name="ismaserrano_portfoliobundle_image_gallery_item_page_parts")
 * @ORM\Entity
 */
class ImageGalleryItemPagePart extends \Ismaserrano\PortfolioBundle\Entity\PageParts\AbstractPagePart
{
    /**
     * @var string
     *
     * @ORM\Column(name="media_alt_text", type="text", nullable=true)
     */
    private $mediaAltText;

    /**
     * @var \Kunstmaan\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * })
     * @Assert\NotNull()
     */
    private $media;

    /**
     * @var \Ismaserrano\PortfolioBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity="Ismaserrano\PortfolioBundle\Entity\Project", inversedBy="images")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $project;


    /**
     * Set mediaAltText
     *
     * @param string $mediaAltText
     *
     * @return ImageGalleryItemPagePart
     */
    public function setMediaAltText($mediaAltText)
    {
        $this->mediaAltText = $mediaAltText;

        return $this;
    }

    /**
     * Get mediaAltText
     *
     * @return string
     */
    public function getMediaAltText()
    {
        return $this->mediaAltText;
    }

    /**
     * Set media
     *
     * @param \Kunstmaan\MediaBundle\Entity\Media $media
     *
     * @return ImageGalleryItemPagePart
     */
    public function setMedia(\Kunstmaan\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Kunstmaan\MediaBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }
    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'IsmaserranoPortfolioBundle:PageParts:ImageGalleryItemPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Ismaserrano\PortfolioBundle\Form\PageParts\ImageGalleryItemPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Ismaserrano\PortfolioBundle\Form\PageParts\ImageGalleryItemPagePartAdminType();
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }
}
