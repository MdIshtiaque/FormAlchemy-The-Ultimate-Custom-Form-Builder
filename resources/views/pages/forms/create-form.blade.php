@extends('master')

@push('css')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
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
            <form action="{{ route('form.store') }}" method="POST">
                @csrf
                <input type="text" name="topicId" value="{{ $topicId }}" hidden>
                <div id="configDiv">
                </div>
                <div id="selectorDiv" class="mt-4">
                    <label class="form-label">Select an Input Type, Future Form Wizard</label>
                    <select id="inputType" class="form-select" onchange="renderConfig()">
                        <option value="">Select a input type</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-2" onclick="captureInfo()">Gather Intel</button>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="{{ asset('js/formCreate.js') }}"></script>
@endpush
