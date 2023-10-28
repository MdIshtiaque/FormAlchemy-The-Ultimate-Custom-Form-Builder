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

    public function respondUpdate(Request $request) {
        try {
            $formIds = FormData::whereUnique_id($request->uniqueId)->whereUser_id(auth()->user()->id)->get();

            foreach ($formIds as $item) {
                $valueToSave = $request->value[$item->form_id];
                if (is_array($valueToSave)) {
                    $valueToSave = json_encode($valueToSave);
                }
                $item->update([
                    'value' => $valueToSave
                ]);
            }
        }catch (\Exception $exception) {

        }

        return back();
    }

    public function submittedForm() {
        $items = FormData::with('form.topic')->whereUser_id(auth()->user()->id)->get()->groupby('unique_id');
//        return $items;
        return view('pages.forms.submitted', ['items' => $items]);
    }
}
