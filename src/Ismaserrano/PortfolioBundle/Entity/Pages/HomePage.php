<?php

namespace Ismaserrano\PortfolioBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\NodeBundle\Entity\HomePageInterface;
use Kunstmaan\NodeSearchBundle\Helper\SearchTypeInterface;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Symfony\Component\Form\AbstractType;
use Ismaserrano\PortfolioBundle\Form\Pages\HomePageAdminType;

/**
 * HomePage
 *
 * @ORM\Entity()
 * @ORM\Table(name="ismaserrano_portfoliobundle_home_pages")
 */
class HomePage extends AbstractPage implements HasPageTemplateInterface, SearchTypeInterface, HomePageInterface
{
    /**
     * Returns the default backend form type for this page
     *
     * @return AbstractType
     */
    public function getDefaultAdminType()
    {
        return new HomePageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array(
            array(
                'name' => 'ProjectPage',
                'class'=> 'Ismaserrano\PortfolioBundle\Entity\Pages\ProjectPage'
            ),
            array(
                'name'  => 'ContentPage',
                'class' => 'Ismaserrano\PortfolioBundle\Entity\Pages\ContentPage'
            ),
            array(
                'name'  => 'BehatTestPage',
                'class' => 'Ismaserrano\PortfolioBundle\Entity\Pages\BehatTestPage'
            )
        );
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
    	return array('IsmaserranoPortfolioBundle:homepage');
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return 'IsmaserranoPortfolioBundle:Pages\HomePage:view.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchType()
    {
	    return 'Home';
    }
}
