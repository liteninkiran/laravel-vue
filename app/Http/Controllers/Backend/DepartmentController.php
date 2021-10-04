<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Requests\DepartmentStoreRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $search = '';

        if ($request->has('search')) {

            $search = $request->search;

            $queryBuilder = Department::query()
                ->where('name', 'like', "%{$search}%");
        } else {
            $queryBuilder = Department::query();
        }

        $departments = $queryBuilder
            ->withCount('employees')
            ->orderBy('name', 'asc')
            ->get();

        return view('departments.index', compact('departments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\DepartmentStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreRequest $request) {
        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('departments.index')->with('message', 'Department Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $department = Department::withCount('employees')->findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentUpdateRequest $request, Department $department) {
        $department->update([
            'name' => $request->name,
        ]);

        return redirect()->route('departments.index')->with('message', 'Department Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $department = Department::query()
            ->withCount('employees')
            ->findOrFail($id);

        if ($department->employees_count === 0) {
            $department->delete();
            return redirect()->route('departments.index')->with('message', 'Department Deleted Successfully');
        }
        return redirect()->route('departments.index')->with('message', 'Could not delete department ' . $department->name);

    }
}
