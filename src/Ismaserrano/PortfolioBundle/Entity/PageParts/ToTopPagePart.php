<?php

namespace Ismaserrano\PortfolioBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * ToTopPagePart
 *
 * @ORM\Table(name="ismaserrano_portfoliobundle_to_top_page_parts")
 * @ORM\Entity
 */
class ToTopPagePart extends AbstractPagePart
{
    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
	return 'IsmaserranoPortfolioBundle:PageParts:ToTopPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Ismaserrano\PortfolioBundle\Form\PageParts\ToTopPagePartAdminType
     */
    public function getDefaultAdminType()
    {
	return new \Ismaserrano\PortfolioBundle\Form\PageParts\ToTopPagePartAdminType();
    }
}
