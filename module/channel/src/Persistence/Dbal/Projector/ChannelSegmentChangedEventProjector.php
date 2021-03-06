<?php

/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See license.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Channel\Persistence\Dbal\Projector;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Ergonode\Channel\Domain\Event\ChannelSegmentChangedEvent;

/**
 */
class ChannelSegmentChangedEventProjector
{
    private const TABLE = 'exporter.channel';

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ChannelSegmentChangedEvent $event
     *
     * @throws DBALException
     */
    public function __invoke(ChannelSegmentChangedEvent $event): void
    {
        $this->connection->update(
            self::TABLE,
            [
                'segment_id' => $event->getTo()->getValue(),
            ],
            [
                'id' => $event->getAggregateId()->getValue(),
            ]
        );

        $this->connection->commit();
    }
}
