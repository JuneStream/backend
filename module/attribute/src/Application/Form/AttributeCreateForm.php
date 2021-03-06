<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Attribute\Application\Form;

use Ergonode\Attribute\Application\Form\Model\CreateAttributeFormModel;
use Ergonode\Attribute\Application\Form\Type\AttributeCodeType;
use Ergonode\Attribute\Application\Form\Type\AttributeGroupType;
use Ergonode\Attribute\Application\Form\Type\AttributeTypeType;
use Ergonode\Core\Application\Form\Type\TranslationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Ergonode\Attribute\Application\Provider\AttributePropertyFormResolver;
use Ergonode\Attribute\Domain\ValueObject\AttributeType;

/**
 */
class AttributeCreateForm extends AbstractType implements EventSubscriberInterface
{
    /**
     * @var AttributePropertyFormResolver
     */
    private AttributePropertyFormResolver $resolver;

    /**
     * @param AttributePropertyFormResolver $resolver
     */
    public function __construct(AttributePropertyFormResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'code',
                AttributeCodeType::class
            )
            ->add(
                'type',
                AttributeTypeType::class
            )
            ->add(
                'label',
                TranslationType::class
            )
            ->add(
                'hint',
                TranslationType::class
            )
            ->add(
                'placeholder',
                TranslationType::class
            )
            ->add(
                'groups',
                AttributeGroupType::class
            )
            ->add(
                'multilingual',
                CheckboxType::class,
                [
                    'false_values' => [
                        '0',
                        'false',
                        '',
                        false,
                    ],
                    'empty_data' => false,
                ]
            )
            ->addEventSubscriber($this);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onEvent',
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function onEvent(FormEvent $event): void
    {
        /** @var array $attribute */
        $form = $event->getForm();
        $type = $this->provide($event, 'type');

        if ($type) {
            $propertyForm = $this->resolver->resolve($type->getValue());
            if ($propertyForm) {
                $form->add(
                    'parameters',
                    $propertyForm,
                );
            }
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateAttributeFormModel::class,
            'translation_domain' => 'attribute',
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix(): ?string
    {
        return null;
    }

    /**
     * @param FormEvent $event
     * @param string    $field
     *
     * @return AttributeType
     */
    private function provide(FormEvent $event, string $field): ?AttributeType
    {
        if (\is_object($event->getData()) && $event->getData()->{$field}) {
            return $event->getData()->{$field};
        }

        if (\is_object($event->getForm()->getData()) && $event->getForm()->getData()->{$field}) {
            return $event->getForm()->getData()->{$field};
        }

        if (\is_array($event->getData()) && !empty($event->getData()[$field])) {
            return new AttributeType($event->getData()[$field]);
        }

        return null;
    }
}
