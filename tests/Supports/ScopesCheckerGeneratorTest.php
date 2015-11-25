<?php

namespace SuitTests\Supports;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Url;
use Suitcoda\Supports\ScopesCheckerGenerator;
use SuitTests\TestCase;

class ScopesCheckerGeneratorTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test to generate url
     *
     * @return void
     */
    public function testGenerateUrl()
    {
        $urlFaker = factory(Url::class)->make();

        $scope = Mockery::mock(Scope::class)->makePartial();

        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateUrl($urlFaker);
        $this->assertEquals(' --url ' . $urlFaker->url, $result);
    }

    /**
     * Test to generate destination
     *
     * @return void
     */
    public function testGenerateDestination()
    {
        $inspectionFaker = factory(Inspection::class)->make();
        $projectFaker = factory(Project::class)->make();

        $scope = Mockery::mock(Scope::class)->makePartial();

        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateDestination($projectFaker, $inspectionFaker);
        $this->assertEquals(
            ' --destination public/files/' .
            $projectFaker->name . '/' .
            $inspectionFaker->sequence_number . '/ ',
            $result
        );
    }

    /**
     * Test to generate sub directory folder path
     *
     * @return void
     */
    public function testGetSubDirCommand()
    {
        $scope = Mockery::mock(Scope::class)->makePartial();

        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->getSubDirCommand('SEO');
        $this->assertEquals('seo/', $result);
    }

    /**
     * Test to generate parameters
     *
     * @return void
     */
    public function testGenerateParameters()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateParameters('256', 'seo');
        $this->assertEquals('--heading', $result);
    }

    /**
     * Test to generate command
     *
     * @return void
     */
    public function testGenerateCommand()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateCommand('2097151', 'seo');
        $this->assertEquals('nodejs seo/seoChecker.js', $result);
    }

    /**
     * Test to generate command of backend seo scope
     *
     * @return void
     */
    public function testGenerateCommandBackendSeo()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateCommand('2097151', 'backendSeo');
        $this->assertEquals('php artisan checker:backend-seo', $result);
    }

    /**
     * Test to generate null command
     *
     * @return void
     */
    public function testGenerateCommandNull()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateCommand('0', 'seo');
        $this->assertNull($result);
    }

    /**
     * Test to get Scope by type
     *
     * @return void
     */
    public function testGetByType()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->getByType('css');
        $this->assertInstanceOf(Scope::class, $result->first());
    }
}
