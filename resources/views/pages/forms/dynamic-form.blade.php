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
        {{--        @dd($datas);--}}
        <div class="form-wizardry-card">
            <div id="selectorDiv" class="mt-4">
                @foreach($datas as $item)
                    @if($item->type == 'Short_Answer')
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">{{ $item->question }}</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                   placeholder="name@example.com">
                        </div>
                    @elseif($item->type == 'Long_Answer')
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">{{ $item->question }}</label>
                            <textarea class="form-control"></textarea>
                            {{--                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">--}}
                        </div>
                    @elseif($item->type == 'Checkbox')
                        <div class="mb-3">
                            <label class="form-label">{{ $item->question }}</label>
                            @php
                                $options = json_decode($item->options);
                            @endphp
                            @if (is_array($options))
                                @foreach ($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{ $item->question }}" id="{{ $option }}">
                                        <label class="form-check-label" for="{{ $option }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @elseif($item->type == 'Multiple_Choice')
                        <div class="mb-3">
                            <label class="form-label">{{ $item->question }}</label>
                            @php
                                $options = json_decode($item->options);
                            @endphp
                            @if (is_array($options))
                                @foreach ($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $option }}">
                                        <label class="form-check-label" for="{{ $option }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @elseif($item->type == 'Dropdown')
                        <div class="mb-3">
                            <label class="form-label">{{ $item->question }}</label>
                            @php
                                $options = json_decode($item->options);
                            @endphp
                            @if (is_array($options))
                                <select class="form-select" id="{{ $item->question }}">
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            <button type="submit" class="btn btn-success mt-2">Submit</button>
        </div>
    </div>

@endsection

@push('js')

@endpush
