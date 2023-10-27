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
            margin-top: 3rem;
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
            font-size: 2.2rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        h5 {
            color: #495057;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control, .form-select {
            border-radius: .25rem;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            width: 100%;
            font-size: 1.2rem;
        }

        .form-check-label {
            margin-left: 0.5rem;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <h1>FormAlchemy</h1>
        @if($isFilled === null)
            <form action="{{ route('formData.store') }}" method="post">
                @csrf
                <div class="form-wizardry-card">
                    <input name="uniqueId" value="{{ $datas->first()->unique_id }}" hidden>
                    @foreach($datas as $key => $item)
                        <!-- Repeated code block for form elements -->
                        @if($item->type === 'Short_Answer')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">{{ $item->question }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="value[{{ $item->id }}]"
                                       placeholder="name@example.com">
                            </div>
                        @elseif($item->type === 'Long_Answer')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">{{ $item->question }}</label>
                                <textarea class="form-control" name="value[{{ $item->id }}]"></textarea>
                            </div>
                        @elseif($item->type === 'Checkbox')
                            <div class="mb-3">
                                <label class="form-label">{{ $item->question }}</label>
                                @php $options = json_decode($item->options); @endphp
                                @if (is_array($options))
                                    @foreach ($options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="value[{{ $item->id }}]"
                                                   id="{{ $option }}" value="{{ $option }}">
                                            <label class="form-check-label" for="{{ $option }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @elseif($item->type === 'Multiple_Choice')
                            <div class="mb-3">
                                <label class="form-label">{{ $item->question }}</label>
                                @php $options = json_decode($item->options); @endphp
                                @if (is_array($options))
                                    @foreach ($options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"  value="{{ $option }}" id="{{ $option }}" name="value[{{ $item->id }}][]">
                                            <label class="form-check-label" for="{{ $option }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @elseif($item->type === 'Dropdown')
                            <div class="mb-3">
                                <label class="form-label">{{ $item->question }}</label>
                                @php $options = json_decode($item->options); @endphp
                                @if (is_array($options))
                                    <select class="form-select" id="{{ $item->question }}" name="value[{{ $item->id }}]">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        @elseif($item->type === 'Time')
                            <div class="mb-3">
                                <label for="{{ $item->id }}" class="form-label">{{ $item->question }}</label>
                                <input type="time" class="form-control" id="{{ $item->id }}" name="value[{{ $item->id }}]">
                            </div>
                        @elseif($item->type === 'Date')
                            <div class="mb-3">
                                <label for="{{ $item->id }}" class="form-label">{{ $item->question }}</label>
                                <input type="date" class="form-control" id="{{ $item->id }}" name="value[{{ $item->id }}]">
                            </div>
                        @endif
                    @endforeach
                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                </div>
            </form>
        @else
            <h1>You Have Already Submitted the form</h1>
        @endif
    </div>

@endsection
