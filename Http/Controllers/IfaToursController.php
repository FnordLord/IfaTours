<?php

namespace Modules\IfaTours\Http\Controllers;

use App\Contracts\Controller;
use Illuminate\Http\Request;

/**
 * Class IfaToursController
 */
class IfaToursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ifatours::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ifatours::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     */
    public function show()
    {
        return view('ifatours::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('ifatours::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
    }
}
