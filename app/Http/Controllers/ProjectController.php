<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\CreateProjectRequest;
use App\Project;
use Carbon\Carbon;

class ProjectController extends Controller
{
    protected $nbrPerPage = 10;        
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->wantsJson())
        {                    
            return view('projects.index');
        }
        else
        {
            if ($request->has('betweenDate1') && $request->has('betweenDate2')
                && $request->has('minPriority')
                && ($request->get('sortDir') == null || $request->get('sortDir') == 'asc' || $request->get('sortDir') == 'desc'))
            {               
                $projects = Project::search(array(
                    'q' => $request->get('q', null),
                    'betweenDate1' => $request->get('betweenDate1'),
                    'betweenDate2' => $request->get('betweenDate2'),
                    'minPriority' => $request->get('minPriority'),
                    'sortBy' => $request->get('sortBy', 'name'),
                    'sortDir' => $request->get('sortDir', 'asc')
                ));
                
                return new JsonResponse(
                    $projects->paginate($request->get('per_page', $this->nbrPerPage))
                );    
            }
            else
            {
                return new JsonResponse(array("details" => "The query is not specified." ), 400);   
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {
        $project = new Project;
        $project->fill($request->all());
        $project->save();
        $project->performers()->attach($request->performers_id);

        return redirect(action('ProjectController@show',
                               ['id' => $project->id]))
            ->withOk("The project " . $project->name . " has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('leader', 'performers')->find($id);

        return view('projects.show', ['project' => $project ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with('leader', 'performers')->find($id);

        return view('projects.edit', ['project' => $project ]);     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateProjectRequest $request, $id)
    {
        $project = Project::find($id);
        $project->fill($request->all());
        $project->performers()->sync($request->performers_id);
        $project->save();

        return redirect(action('ProjectController@show',
                               ['id' => $project->id]))
            ->withOk("The project " . $project->name . " has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->performers()->detach();
        $project->delete();

        return redirect(action('ProjectController@index'))
            ->withOk("The project " . $project->name . " has been deleted.");
    }
}
