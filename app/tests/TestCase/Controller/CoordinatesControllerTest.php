<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

/**
 * Class CoordinatesControllerTest
 * @package App\Test\TestCase\Controller
 */
class CoordinatesControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.coordinates',
        'app.users',
        'app.favorites',
        'app.items',
        'app.shops',
        'app.coordinates_items'
    ];

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @return void
     */
    public function testView()
    {
        $this->get('/coordinates/view/1');
        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * @return void
     */
    public function testPostFavorite()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
