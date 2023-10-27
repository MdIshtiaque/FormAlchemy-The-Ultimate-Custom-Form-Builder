<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormData;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class RespondController extends Controller
{
    public function responds($uniqueId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $responds = FormData::with('form', 'user')->whereUnique_id($uniqueId)->get()->groupby('user_id');

        return view('pages.forms.responds', ['responds' => $responds]);
    }

    public function previewRespond($uniqueId, Request $request) {

        $items = Form::whereUnique_id($uniqueId)
            ->with(['formData' => function ($query) use ($request) {
                $query->where('user_id', $request->submittedBy);
            }])
            ->get();
//        return  $items;
        return view('pages.forms.submitted-form', ['items' => $items]);
    }
}
