<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormData;
use App\Models\Topic;
use Exception;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $items = Form::with('topic')->whereCreated_by(auth()->user()->id)->get()->groupby('unique_id');

        return view('pages.forms.index', ['items' => $items]);
    }

    public function topicStore(Request $request)
    {
        try {
            $topic = Topic::create([
                'title' => $request->title,
                'user_id' => auth()->user()->id
            ]);
        } catch (Exception $exception) {

        }

        return redirect()->route('create.form', ['topicId' => $topic->id]);
    }

    public function createForm(Request $request, $topicId)
    {
        return view('pages.forms.create-form', ['topicId' => $topicId]);
    }

    public function generateUniqueId()
    {
        $uniqueId = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT); // Generate a 5-digit unique ID
        $exists = Form::where('unique_id', $uniqueId)->exists(); // Check if the ID exists in the database

        // If the ID already exists, recursively call the function to generate a new one
        if ($exists) {
            return $this->generateUniqueId();
        }

        return $uniqueId;
    }

    public function storeForm(Request $request)
    {

        $formData = $request->except('_token', 'topicId');
        $formDataToInsert = [];
        $uniqueId = $this->generateUniqueId();

        foreach ($formData as $questionType => $data) {
            // Initialize the questionText
            $questionText = [];
            $options = [];

            // Loop through the $data array to find the key associated with the question text
            foreach ($data as $key => $value) {
                if ($key !== 'options') {
                    $questionText = $value;
                    break;
                }
            }
            // Extract the portion of the string until the last underscore
            $lastUnderscorePosition = strrpos($questionType, '_');
            if ($lastUnderscorePosition !== false) {
                $questionType = substr($questionType, 0, $lastUnderscorePosition);
            }

            $options = isset($data['options']) ? json_encode($data['options']) : null;

            $formDataToInsert[] = [
                'type' => $questionType, // Type (dynamic)
                'question' => $questionText, // Question text (dynamic)
                'options' => $options, // Options (if they exist)
            ];
            Form::create([
                'unique_id' => $uniqueId, // Assign the unique ID
                'topic_id' => $request->topicId,
                'type' => $questionType, // Type (dynamic)
                'question' => $questionText, // Question text (dynamic)
                'options' => $options, // Options (if they exist)
                'created_by' => auth()->user()->id
            ]);
        }

        return redirect()->route('preview.form', ["code" => $uniqueId]);
    }

    public function preview($uniqueId)
    {
        $datas = Form::whereUnique_id($uniqueId)->get();
        $isFilled = FormData::whereUnique_id($uniqueId)->whereUser_id(auth()->user()->id)->first();
        if($isFilled) {
            $items = Form::whereUnique_id($uniqueId)
                ->with(['formData' => function ($query) {
                    $query->where('user_id', auth()->user()->id);
                }])
                ->get();
            return view('pages.forms.submitted-form', ['items' => $items]);
        }
        return view('pages.forms.dynamic-form', ['datas' => $datas, 'isFilled' => $isFilled]);
    }

    public function formDataSave(Request $request)
    {

        $formIds = Form::whereUnique_id($request->uniqueId)->get();
//        dd($formIds, $request->all());
        foreach ($formIds as $item) {
            $valueToSave = $request->value[$item->id];
            if (is_array($valueToSave)) {
                $valueToSave = json_encode($valueToSave);
            }
            FormData::create([
                'form_id' => $item->id,
                'user_id' => auth()->user()->id,
                'unique_id' => $request->uniqueId,
                'value' => $valueToSave
            ]);
        }

        return redirect()->route('preview.respond', ['uniqueId' => $request->uniqueId, 'submittedBy' => auth()->user()->id]);

    }
}
