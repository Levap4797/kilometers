<?php

namespace App\Http\Controllers;

use App\DriveModel;
use App\Tables\DrivesTable;
use ErrorException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DrivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws ErrorException
     */
    public function index()
    {
        $table = (new DrivesTable())->setup();
        $exportable = true;

        return view('drives.index', compact('table', 'exportable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('drives.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kilometers' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/drives/create')->with('error', 'Validation Error');
        }

        $drive = DriveModel::create([
            'kilometers' => $request->get('kilometers'),
            'user_id' => auth()->id(),
        ]);

        return redirect('/drives/' . $drive->id . '/edit');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        return view('drives.create', ['drive' => DriveModel::where('id', $id)->firstOrFail()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {
        $drive = DriveModel::where('id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'kilometers' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/drives/' . $drive->id. '/edit')->with('error', 'Validation Error');
        }

        $drive->update([
            'kilometers' => $request->get('kilometers'),
        ]);

        return redirect('/drives/' . $drive->id. '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy($id)
    {
        DriveModel::where('id', $id)->delete();

        return redirect('/drives');
    }
}
