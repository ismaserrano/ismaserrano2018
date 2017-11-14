<?php

namespace Ismaserrano\PortfolioBundle\Form\PageParts;

use Kunstmaan\MediaBundle\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;

/**
 * ImageGalleryItemPagePartAdminType
 */
class ImageGalleryItemPagePartAdminType extends AbstractType
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
        $builder->add('media', 'Kunstmaan\MediaBundle\Form\Type\MediaType', [
            'mediatype' => 'image',
            'required' => false
        ]);
        $builder->add('mediaAltText', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
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
        return 'ismaserrano_portfoliobundle_imagegalleryitempageparttype';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Ismaserrano\PortfolioBundle\Entity\PageParts\ImageGalleryItemPagePart',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }
}
