<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Section\SectionStoreRequest;
use App\Http\Requests\Section\SectionUpdateRequest;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data  = Section::latest()->get();
       return view('sections.sections',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionStoreRequest $request)
    {

        $data = $request->validated();

        $data['created_by'] = Auth::user()->name;


        Section::create($data);

        return redirect()->route('sections.index')->with('success','تم انشاء بالنجاح');



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {



       $sections = Section::findOrFail($id);

       return view('sections.sectionsEdit',compact('sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionUpdateRequest $request, string $id)
    {

        $data = $request->validated();

        $data['created_by'] = Auth::user()->name;
        $section = Section::findOrFail($id);

        $section->update($data);

        return redirect()->route('sections.index')->with('success','تم تعديل بالنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $sec= Section::findOrFail($id);
        $sec->delete();
        return redirect()->route('sections.index')->with('success','تم الحذف بالنجاح');

    }
}
