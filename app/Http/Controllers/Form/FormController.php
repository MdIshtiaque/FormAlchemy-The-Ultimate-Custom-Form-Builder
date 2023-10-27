<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function createForm(Request $request)
    {
        return view('pages.forms.create-form');
    }

    public function generateUniqueId() {
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

        $formData = $request->except('_token');
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
                'type' => $questionType, // Type (dynamic)
                'question' => $questionText, // Question text (dynamic)
                'options' => $options, // Options (if they exist)
            ]);
        }

        return redirect()->route('preview.form', ["code" => $uniqueId]);
    }

    public function preview($uniqueId) {
        $datas = Form::whereUnique_id($uniqueId)->get();

        return view('pages.forms.dynamic-form', ['datas' => $datas]);
    }
}
