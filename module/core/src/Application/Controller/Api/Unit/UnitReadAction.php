<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Core\Application\Controller\Api\Unit;

use Ergonode\Api\Application\Response\SuccessResponse;
use Ergonode\Core\Domain\Entity\Unit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     name="ergonode_unit_read",
 *     path="/units/{unit}",
 *     methods={"GET"},
 *     requirements={"unit"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"}
 * )
 */
class UnitReadAction
{
    /**
     * @IsGranted("SETTINGS_READ")
     *
     * @SWG\Tag(name="Unit")
     * @SWG\Parameter(
     *     name="language",
     *     in="path",
     *     type="string",
     *     required=true,
     *     default="en",
     *     description="Language Code",
     * )
     * @SWG\Parameter(
     *     name="unit",
     *     in="path",
     *     type="string",
     *     required=true,
     *     description="Unit Id",
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns unit",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Not found",
     * )
     *
     * @ParamConverter(class="Ergonode\Core\Domain\Entity\Unit")
     *
     * @param Unit $unit
     *
     * @return Response
     */
    public function __invoke(Unit $unit): Response
    {
        return new SuccessResponse($unit);
    }
}
