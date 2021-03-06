<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Designer\Tests\Domain\Event;

use Ergonode\Designer\Domain\Entity\TemplateElement;
use Ergonode\SharedKernel\Domain\Aggregate\TemplateId;
use Ergonode\Designer\Domain\Event\TemplateElementChangedEvent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 */
class TemplateElementChangedEventTest extends TestCase
{
    /**
     *
     */
    public function testEventCreation(): void
    {
        /** @var TemplateId | MockObject $id */
        $id = $this->createMock(TemplateId::class);

        /** @var TemplateElement | MockObject $element */
        $element = $this->createMock(TemplateElement::class);

        $event = new TemplateElementChangedEvent($id, $element);

        $this->assertSame($id, $event->getAggregateId());
        $this->assertSame($element, $event->getElement());
    }
}
