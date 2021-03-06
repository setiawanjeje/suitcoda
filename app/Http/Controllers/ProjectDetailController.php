<?php

namespace Suitcoda\Http\Controllers;

use Illuminate\Http\Request;
use Suitcoda\Events\ProjectWatcher;
use Suitcoda\Model\Category;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Pagination\CustomPresenter;

class ProjectDetailController extends BaseController
{
    protected $project;

    protected $scope;

    /**
     * Class constructor
     *
     * @param Suitcoda\Model\Project  $project []
     * @param Suitcoda\Model\Inspection $inspection []
     * @param Suitcoda\Model\Scope $scope []
     */
    public function __construct(Project $project, Inspection $inspection, Scope $scope)
    {
        parent::__construct();
        $this->project = $project;
        $this->scope = $scope;
        $this->inspection = $inspection;
    }

    /**
     * Show overview information for project
     *
     * @param  string $key []
     * @return \Illuminate\Http\Response
     */
    public function overview($key)
    {
        $project = $this->find($key);
        $active = 0;

        return view('detail_overview', compact('project', 'active'));
    }

    /**
     * Show activity information for project
     *
     * @param  string $key []
     * @return \Illuminate\Http\Response
     */
    public function activity($key, Category $category)
    {
        $project = $this->find($key);
        $active = 1;
        $categories = $category->get();

        return view('detail_activity', compact('project', 'active', 'categories'));
    }

    /**
     * Show issue information for project
     *
     * @param  string $key []
     * @param  int $inspectionNumber []
     * @param string $selectedCategory []
     * @return \Illuminate\Http\Response
     */
    public function issue($key, $inspectionNumber, $selectedCategory)
    {
        $project = $this->find($key);

        $inspection = $project->inspections()->bySequenceNumber($inspectionNumber)->first();
        $issues = $inspection->issues()->byCategorySlug($selectedCategory)->orderBy('type')->paginate(5);
        $pagination = new CustomPresenter($issues);

        if ($project->inspections()->latestCompleted()->first()->sequence_number == $inspectionNumber) {
            $active = 2;
        } else {
            $active = 1;
        }
        return view(
            'detail_issue',
            compact('project', 'inspection', 'active', 'issues', 'pagination', 'selectedCategory')
        );
    }

    public function issueByCategory(Request $request, $project, $number)
    {
        return redirect()->route('detail.issue', [$project, $number, $request->input('category')]);
    }

    /**
     * Find operation
     *
     * @param  string $key []
     * @return Suitcoda\Model\User
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function find($key)
    {
        $result = \Auth::user()->projects()->findOrFailByUrlKey($key);

        if (empty($result)) {
            return abort(404);
        }
        view()->share('lastInspection', $result->inspections->where('status', '2')->last());
        return $result;
    }

    /**
     * Show json data for chart
     *
     * @param  string $key []
     * @return \Illuminate\Http\Response
     */
    public function graph($key)
    {
        $project = $this->find($key);
        return response()->json($project->getJsonData());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request []
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['scopes' => 'required']);

        $project = $this->project->findBySlug($request->route()->parameters()['project']);

        $sumScopes = 0;
        foreach ($request->input('scopes') as $scopeValue) {
            $sumScopes |= $scopeValue;
        }

        $inspection = $this->inspection->newInstance();
        if ($project->inspections->last() &&
            $project->inspections->last()->sequence_number > 0) {
            $inspection->sequence_number = $project->inspections->last()->sequence_number + 1;
        } else {
            $inspection->sequence_number = 1;
        }
        $inspection->scopes = $sumScopes;
        $project->inspections()->save($inspection);

        $project->update(['is_crawlable' => true]);

        event(new ProjectWatcher($project, $inspection));

        return redirect()->route('detail.activity', $project->slug);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $key []
     * @return \Illuminate\View\View
     */
    public function create($key)
    {
        $project = $this->find($key);
        $scopes = $this->scope->all()->groupBy('categoryName');
        $active = 1;

        return view('inspection_create', compact('project', 'scopes', 'active'));
    }
}
