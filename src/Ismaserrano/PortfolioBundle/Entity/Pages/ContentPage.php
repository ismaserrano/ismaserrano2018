<?php

namespace Ismaserrano\PortfolioBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\NodeSearchBundle\Helper\SearchTypeInterface;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Symfony\Component\Form\AbstractType;
use Ismaserrano\PortfolioBundle\Form\Pages\ContentPageAdminType;

/**
 * ContentPage
 *
 * @ORM\Entity()
 * @ORM\Table(name="ismaserrano_portfoliobundle_content_pages")
 */
class ContentPage extends AbstractPage implements HasPageTemplateInterface, SearchTypeInterface
{
    /**
     * Returns the default backend form type for this page
     *
     * @return AbstractType
     */
    public function getDefaultAdminType()
    {
        return new ContentPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array (
            array(
                'name'  => 'ContentPage',
                'class' => 'Ismaserrano\PortfolioBundle\Entity\Pages\ContentPage'
            ),
	);
    }


    /**
     * {@inheritdoc}
     */
    public function getSearchType()
    {
    	return 'Page';
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array('IsmaserranoPortfolioBundle:main');
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
	    return array('IsmaserranoPortfolioBundle:contentpage');
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return 'IsmaserranoPortfolioBundle:Pages\ContentPage:view.html.twig';
    }
}
