<?php

namespace Ismaserrano\PortfolioBundle\Form;

use Kunstmaan\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Ismaserrano\PortfolioBundle\Form\PageParts\ImageGalleryItemPagePartAdminType;

/**
 * The type for Project
 */
class ProjectAdminType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $request = new Request();
//        dump($builder);exit;

        $builder->add('title');
        $builder->add('body', TextareaType::class, array(
            'attr' => array('rows' => 10, 'cols' => 600, 'class' => 'js-rich-editor rich-editor', 'height' => 120),
            'required' => false
        ));
        $builder->add('slug');
//        $builder->add('filter', null, array(
//            'attr' => array(
//                'class' => 'js-advanced-select',
//                'multiple' => 'multiple'
//            ),
//            'query_builder' => function(FilterRepository $repository) {
//                $qb = $repository->createQueryBuilder('p');
//                return $qb
//                    ->where($qb->expr()->isNotNull('p.parent'))
//                    ->orderBy('p.name', 'ASC');
//            },
//            'group_by' => 'parent'
//        ));
//        $builder->add('image_id', MediaType::class, array('label'=>'Header image'));
        $builder->add('images', CollectionType::class, array(
            'entry_type' => ImageGalleryItemPagePartAdminType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'attr' => array(
                'nested_form' => true,
                'nested_sortable' => false,
                'nested_form_min' => 1,
                'nested_form_max' => 10,
            )
        ));

//        $builder->add('images', ImageGalleryItemPagePartAdminType::class,
//            array('data_class'=>null)
//        );
//        $builder->get('images')
//        ->addModelTransformer(new CallbackTransformer(
//            function ($mediaAsArray) {
////                dump($mediaAsArray->getValues());exit;
//                // transform the array to a string
////                $returnArray = new ArrayCollection();
////                if (!is_null($mediaAsArray->getValues())) {
////                    $returnArray = $mediaAsArray->map(function($entity){
////                        return $entity;
////                    })->toArray();
////                }
////                $returnArray = new ImageGalleryItemPagePart($returnArray);
////                dump($returnArray);exit;
//                return $mediaAsArray->getValues(); //$returnArray; //implode(', ', $returnArray);
//            },
//            function ($mediaAsString) {
//                foreach($mediaAsString as $media) {
//                    dump($media);
//                }
//                exit;
//                // transform the string back to an array
//                return explode(', ', $mediaAsString);
//            }
//        ));
//        $builder->add('created', DateTimeType::class, [
//            'widget' => 'single_text',
//            'format' => 'dd-MM-yyyy',
//            'attr' => [
//                'class' => 'form-control input-inline datepicker',
//                'data-date-format' => 'DD/MM/YYYY HH:mm:ss'
//            ]
//        ]);
        $builder->add('status');
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Ismaserrano\PortfolioBundle\Entity\Project',
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'project_form';
    }
}
