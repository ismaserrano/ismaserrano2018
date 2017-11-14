<?php

namespace Ismaserrano\PortfolioBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * LinePagePart
 *
 * @ORM\Table(name="ismaserrano_portfoliobundle_line_page_parts")
 * @ORM\Entity
 */
class LinePagePart extends AbstractPagePart
{
    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
	return 'IsmaserranoPortfolioBundle:PageParts:LinePagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Ismaserrano\PortfolioBundle\Form\PageParts\LinePagePartAdminType
     */
    public function getDefaultAdminType()
    {
	return new \Ismaserrano\PortfolioBundle\Form\PageParts\LinePagePartAdminType();
    }
}
