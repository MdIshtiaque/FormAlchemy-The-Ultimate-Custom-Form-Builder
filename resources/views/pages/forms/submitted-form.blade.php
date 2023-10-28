@extends('master')

@push('css')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }

        .container {
            margin-top: 2rem;
        }

        .form-wizardry-card {
            margin-bottom: 50px;
            padding: 2rem;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #343a40;
            font-size: 2rem;
        }

        h5 {
            color: #495057;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: .25rem;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .card-append {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #b4b4b4;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')

    <div class="container mt-5">
        <h1 class="text-center text-primary">FormAlchemy</h1>
        <div class="form-wizardry-card">
            <div id="selectorDiv" class="mt-4">
                <form id="respond" action="{{ route('respond.update') }}" method="POST">
                    @csrf
                    <input name="uniqueId" value="{{ $items->first()->unique_id }}" hidden>
                    @foreach($items as $key => $item)
                        @if($item->type === 'Short_Answer')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">{{ $item->question }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" disabled
                                       value="{{ optional($item->formData[0])->value }}" placeholder="name@example.com" name="value[{{ $item->id }}]" required>
                            </div>
                        @elseif($item->type === 'Long_Answer')
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1"
                                       class="form-label">{{ $item->question }}</label>
                                <textarea class="form-control" disabled name="value[{{ $item->id }}]"
                                          id="exampleFormControlTextarea1" required>{{ optional($item->formData[0])->value }}</textarea>
                            </div>
                        @elseif($item->type === 'Checkbox')
                            <div class="mb-3">
                                <label class="form-label">{{ $item->question }}</label>
                                @php
                                    $options = json_decode($item->options, true);
                                    $value = optional($item->formData[0])->value;
                                @endphp
                                @foreach ($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" disabled
                                               type="radio"
                                               name="value[{{ $item->id }}]"
                                               id="{{ $option }}"
                                               value="{{ $option }}" {{ $value === $option ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="{{ $option }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($item->type === 'Multiple_Choice')
                            <div class="mb-3">
                                <label class="form-label">{{ $item->question }}</label>
                                @php
                                    $options = json_decode($item->options, true);
                                    $value = optional($item->formData[0])->value;
                                    $valueArray = json_decode($value, true);
                                @endphp
                                @foreach ($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox"
                                               name="value[{{ $item->id }}][]"
                                               id="{{ $option }}" value="{{ $option }}"
                                               {{ in_array($option, $valueArray) ? 'checked' : '' }} readonly required>
                                        <label class="form-check-label" for="{{ $option }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($item->type === 'Dropdown')
                            <div class="mb-3">
                                <label class="form-label">{{ $item->question }}</label>
                                @php
                                    $options = json_decode($item->options, true);
                                    $value = optional($item->formData[0])->value;
                                @endphp
                                <select class="form-select" id="{{ $item->question }}" name="value[{{ $item->id }}]"
                                        disabled required>
                                    <option value="" disabled {{ empty($value) ? 'selected' : '' }}>Select</option>
                                    @foreach ($options as $option)
                                        <option
                                            value="{{ $option }}" {{ $value === $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif($item->type === 'Time')
                            <div class="mb-3">
                                <label for="{{ $item->id }}" class="form-label">{{ $item->question }}</label>
                                <input type="time" disabled class="form-control" id="{{ $item->id }}"
                                       name="value[{{ $item->id }}]"
                                       value="{{ optional($item->formData[0])->value }}" required>
                            </div>
                        @elseif($item->type === 'Date')
                            <div class="mb-3">
                                <label for="{{ $item->id }}" class="form-label">{{ $item->question }}</label>
                                <input type="date" disabled class="form-control" id="{{ $item->id }}"
                                       name="value[{{ $item->id }}]"
                                       value="{{ optional($item->formData[0])->value }}" required>
                            </div>
                        @endif
                    @endforeach
                    <button id="submitButton" class="btn btn-primary" type="submit" style="display:none;">Submit</button>
                </form>
                @if($items->first()->formData[0]->user_id == auth()->user()->id)
                    <button id="editButton" class="btn btn-warning">Edit Respond</button>
                @endif
            </div>
        </div>

        @endsection

        @push('js')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const editButton = document.getElementById('editButton');
                    const submitButton = document.getElementById('submitButton');
                    const formControls = document.querySelectorAll('.form-control, .form-check-input, .form-select');

                    editButton.addEventListener('click', function () {
                        formControls.forEach(function (element) {
                            element.removeAttribute('disabled');
                        });
                        document.getElementById('editButton').style.display = 'none'
                        submitButton.style.display = 'block';
                    });
                    const formId = document.getElementById('respond');

                    submitButton.addEventListener('click', function() {
                        if (formId.checkValidity()) {
                            formId.submit();
                        } else {
                            alert('Please fill out all required fields.');
                        }
                    });
                });
            </script>
    @endpush

