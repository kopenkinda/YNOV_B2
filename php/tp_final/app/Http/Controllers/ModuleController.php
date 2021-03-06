<?php

namespace App\Http\Controllers;

use App\Module;
use App\Promo;
use App\Student;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $search = $request->input('search') ?? '';

        if ($search != '') {
            $modules = Module::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $modules = Module::all();
        }

        return view('module.index', ['modules' => $modules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module.create', ['promos' => Promo::all(), 'students' => Student::all(), 'modules' => Module::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $module = new Module();
        $module->name = $request->input('name');
        $module->description = $request->input('description');
        $module->save();
        $module->promos()->attach($request->input('promos'));
        $module->students()->attach($request->input('students'));
        return redirect()->route('modules.index', ['module' => $module]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        return view('module.show', ['module' => $module]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        return view('module.edit', ['module' => $module, 'promos' => Promo::all(), 'students' => Student::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        $module->name = $request->input('name');
        $module->description = $request->input('description');
        $module->promos()->detach();
        $module->promos()->attach($request->input('promos'));
        $module->students()->detach();
        $module->students()->attach($request->input('students'));
        $module->save();
        return redirect()->route('modules.show', ['module' => $module]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module->promos()->detach();
        $module->students()->detach();
        $module->delete();
        return redirect()->route('modules.index');
    }
}
