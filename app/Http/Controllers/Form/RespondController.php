<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormData;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RespondController extends Controller
{
    public function responds($uniqueId): View
    {
        $responds = FormData::with('form', 'user')->whereUnique_id($uniqueId)->get()->groupby('user_id');

        return view('pages.forms.responds', ['responds' => $responds]);
    }

    public function previewRespond($uniqueId, Request $request): View
    {

        $items = Form::whereUnique_id($uniqueId)
            ->with(['formData' => function ($query) use ($request) {
                $query->where('user_id', $request->submittedBy);
            }, 'topic'])
            ->get();

        return view('pages.forms.submitted-form', ['items' => $items]);
    }

    public function respondUpdate(Request $request): RedirectResponse
    {
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

    public function submittedForm(): View
    {
        $items = FormData::with('form.topic')->whereUser_id(auth()->user()->id)->get()->groupby('unique_id');

        return view('pages.forms.submitted', ['items' => $items]);
    }

    public function chart($uniqueId)
    {
        $responds = FormData::with('form', 'user')->where('unique_id', $uniqueId)->get()->groupBy('form_id');
        $output = [];

        foreach ($responds as $formId => $formDataCollection) {
            $question = $formDataCollection->first()->form->question;
            $answers = $formDataCollection->pluck('value')->toArray();
            $countedAnswers = [];

            foreach ($answers as $answer) {
                $decodedAnswer = json_decode($answer, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedAnswer)) {
                    foreach ($decodedAnswer as $item) {
                        $item = (string)$item; // Convert to string if it's not
                        if (!isset($countedAnswers[$item])) {
                            $countedAnswers[$item] = 0;
                        }
                        $countedAnswers[$item]++;
                    }
                } else {
                    if (!isset($countedAnswers[$answer])) {
                        $countedAnswers[$answer] = 0;
                    }
                    $countedAnswers[$answer]++;
                }
            }

            $output[] = [
                'question' => $question,
                'answers' => $countedAnswers
            ];
        }

//        return response()->json($output);
        return view('pages.forms.chart-view', ['output' => json_encode($output)]);
    }
}
