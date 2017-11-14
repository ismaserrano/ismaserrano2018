<?php

namespace Ismaserrano\PortfolioBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;

use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Symfony\Component\Form\AbstractType;
use Ismaserrano\PortfolioBundle\Form\Pages\BehatTestPageAdminType;

/**
 * BehatTestPage
 *
 * @ORM\Entity()
 * @ORM\Table(name="ismaserrano_portfoliobundle_behat_test_pages")
 */
class BehatTestPage extends AbstractPage implements HasPageTemplateInterface
{

    /**
     * Returns the default backend form type for this page
     *
     * @return AbstractType
     */
    public function getDefaultAdminType()
    {
        return new BehatTestPageAdminType();
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
                'name'  => 'HomePage',
                'class' => 'Ismaserrano\PortfolioBundle\Entity\Pages\HomePage'
            ),
            array(
                'name'  => 'ContentPage',
                'class' => 'Ismaserrano\PortfolioBundle\Entity\Pages\ContentPage'
            ),
        );
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array('IsmaserranoPortfolioBundle:behat-test-page');
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return '';
    }
}
