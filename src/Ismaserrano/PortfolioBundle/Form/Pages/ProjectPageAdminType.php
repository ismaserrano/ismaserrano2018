<?php

namespace Ismaserrano\PortfolioBundle\Form\Pages;

use Kunstmaan\MediaBundle\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ProjectPageAdminType
 */
class ProjectPageAdminType extends \Kunstmaan\NodeBundle\Form\PageAdminType
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
        $builder->add('project', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
            'class' => 'Ismaserrano\PortfolioBundle\Entity\Project',
            'expanded' => false,
            'multiple' => false,
            'required' => false,
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'ismaserrano_portfoliobundle_projectpagetype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Ismaserrano\PortfolioBundle\Entity\Pages\ProjectPage',
        ]);
    }
}
