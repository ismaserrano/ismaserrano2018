<?php

namespace Ismaserrano\PortfolioBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * TocPagePart
 *
 * @ORM\Table(name="ismaserrano_portfoliobundle_toc_page_parts")
 * @ORM\Entity
 */
class TocPagePart extends AbstractPagePart
{
    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
	return 'IsmaserranoPortfolioBundle:PageParts:TocPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Ismaserrano\PortfolioBundle\Form\PageParts\TocPagePartAdminType
     */
    public function getDefaultAdminType()
    {
	return new \Ismaserrano\PortfolioBundle\Form\PageParts\TocPagePartAdminType();
    }
}
