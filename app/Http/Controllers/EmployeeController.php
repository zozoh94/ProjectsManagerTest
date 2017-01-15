<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Employee;

class EmployeeController extends Controller
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
            $employees = Employee::paginate($this->nbrPerPage);
        
            return view('employees.index', ['employees' => $employees]);

        }
        else
        {           
            if ($request->has('q'))
            {
                $query = $request->get('q');                
                
                return new JsonResponse(
                    Employee::search($query)->paginate($request->get('per_page', $this->nbrPerPage))
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
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $employee = new Employee;
        $employee->fill($request->all());
        $employee->save();

        return redirect(action('EmployeeController@show',
                               ['id' => $employee->id]))
            ->withOk("The employee " . $employee->firstname . " "
                     . $employee->lastname . " has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::with('performedProjects', 'leadedProjects')->find($id);

        return view('employees.show', ['employee' => $employee ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);

        return view('employees.edit', ['employee' => $employee ]);                                                  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = Employee::find($id);        
        $employee->fill($request->all());
        $employee->save();

        return redirect(action('EmployeeController@show',
                               ['id' => $employee->id]))
            ->withOk("The employee " . $employee->firstname . " "
                     . $employee->lastname . " has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);        
        $employee->delete();

        return redirect(action('EmployeeController@index'))
            ->withOk("The employee " . $employee->firstname . " "
                     . $employee->lastname . " has been deleted.");
    }
}
