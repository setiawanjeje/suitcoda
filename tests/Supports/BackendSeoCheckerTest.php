<?php

namespace SuitTests\Supports;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Model\Project;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;
use Suitcoda\Supports\BackendSeoChecker;
use SuitTests\TestCase;

class BackendSeoCheckerTest extends TestCase
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
     * Test run method
     *
     * @return void
     */
    public function testRun()
    {
        $this->addUrlFaker();
        $destination = 'public/test/project/example/1/';
        $option = [
            'title-similar' => true,
            'desc-similar' => true,
            'depth' => true
        ];

        $url = new Url;
        $checker = new BackendSeoChecker($url);
        
        $checker->setUrl('http://example.com/test');
        $checker->setDestination($destination);
        $checker->setOption($option);
        $checker->run();

        unlink(base_path($destination) . 'resultBackendSEO.json');
        if (is_dir(base_path($destination))) {
            rmdir(base_path('public/test/project/example/1'));
            rmdir(base_path('public/test/project/example'));
            rmdir(base_path('public/test/project'));
            rmdir(base_path('public/test'));
        }
    }

    /**
     * Make faker for url
     *
     * @return void
     */
    protected function addUrlFaker()
    {
        $userFaker = factory(User::class)->create(['name' => 'test']);
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);
        for ($i = 0; $i < 2; $i++) {
            $urlFaker = factory(Url::class)->make();
            $projectFaker->urls()->save($urlFaker);
        }
    }
}
