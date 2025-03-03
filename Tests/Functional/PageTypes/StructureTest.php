<?php

/*
 * This file is part of the "headless" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 *
 * (c) 2021
 */

declare(strict_types=1);

namespace FriendsOfTYPO3\Headless\Test\Functional\PageTypes;

use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;

class StructurePageTypesTest extends BasePageTypesTest
{
    /**
     * @test
     */
    public function getMenuStructure()
    {
        $response = $this->executeFrontendRequest(
            new InternalRequest('https://website.local/?type=834')
        );

        self::assertEquals(200, $response->getStatusCode());

        $pageTree = json_decode((string)$response->getBody(), true);

        self::assertTrue(isset($pageTree['navigation']));
        self::assertEquals(1, count($pageTree['navigation']));
        self::assertTrue(isset($pageTree['navigation'][0]));
        self::assertEquals(3, count($pageTree['navigation'][0]['children']));
        self::assertEquals(1, count($pageTree['navigation'][0]['children'][0]['children']));
        self::assertEquals(0, count($pageTree['navigation'][0]['children'][1]['children']));

        self::assertEquals('/', $pageTree['navigation'][0]['link']);
        self::assertEquals('/page1', $pageTree['navigation'][0]['children'][0]['link']);
        self::assertEquals('/page1/page1_1', $pageTree['navigation'][0]['children'][0]['children'][0]['link']);
        self::assertEquals('/page2', $pageTree['navigation'][0]['children'][1]['link']);
    }
}
