<?php

namespace Ismaserrano\PortfolioBundle\Form\PageParts;

use Kunstmaan\MediaBundle\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ProjectPagePartAdminType
 */
class ProjectPagePartAdminType extends \Symfony\Component\Form\AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('projects', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class' => 'Ismaserrano\PortfolioBundle\Entity\Project',
            'expanded' => true,
            'multiple' => true,
            'required' => false,
//            'by_reference' => false,
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'ismaserrano_portfoliobundle_projectpageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Ismaserrano\PortfolioBundle\Entity\PageParts\ProjectPagePart',
        ]);
    }
}
