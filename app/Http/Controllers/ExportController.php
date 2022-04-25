<?php

namespace App\Http\Controllers;

use App\Interfaces\GenerationInterface;
use App\Rules\StringIntRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExportController extends Controller
{
    /** @var GenerationInterface */
    protected $generation;

    public function __construct(GenerationInterface $watermarkService)
    {
        $this->generation = $watermarkService;
    }

    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'array',
            'data.0' => 'array',
            'data.0.*' => [new StringIntRule()],
        ]);

        if ($validator->fails() && $request->get('password') === $request->get('confirmed_password')) {
            return back()->with('error', 'Export Failed');
        }

        $pathToFile = $this->generation->generate($request->get('data'));

        return response()->download($pathToFile);
    }
}
