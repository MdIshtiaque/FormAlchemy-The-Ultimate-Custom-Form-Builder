@extends('master')

@push('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <style>
        body {
            background: linear-gradient(to right, #8e9eab, #eef2f3);
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center;
            max-width: 60%;
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 15px;
        }

        .stat-card {
            background: linear-gradient(to left, #a1c4fd, #c2e9fb);
            color: white;
            border-radius: 10px;
            text-align: center;
        }

        .stat-title {
            font-size: 20px;
            margin: 20px 0;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
        }

        td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }


        @media (max-width: 768px) {
            .container {
                max-width: 90%;
            }
        }

        @media only screen and (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h1>Dashboard</h1>
        <div class="row mt-4">
            <div class="col-md-12 col-12">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-title">Total Form</div>
                        <div class="stat-number" id="shortenedCount">{{ $items->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center mb-3">
            <button type="button" class="btn btn-success mt-5" data-toggle="modal" data-target="#exampleModalCenter">
                Create New Form
            </button>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Shareable Link</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableBody">
                @foreach ($items as $index => $item)
                    <tr>
                        <td>{{ $item->first()->topic->title }}</td>
                        <td>
                            <button type="button" class="btn btn-link copy-link" id="copyBtn" data-clipboard-text="{{ env('APP_URL') }}/form/{{ $item->first()->unique_id }}" data-toggle="tooltip" data-placement="top" title="Copied!">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </td>
                        <td>
                            <a type="button" href="{{ route('responds', ['uniqueId' => $item->first()->unique_id]) }}" class="btn btn-primary edit-link btn-edit-link">
                                View Responds
                            </a>
                            <a type="button" href="{{ route('show.chart', ['uniqueId' => $item->first()->unique_id]) }}" class="btn btn-primary edit-link btn-edit-link">
                                Statistics
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @include('pages.forms.modal.form-name')
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                responsive: true
            });
        });

    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({trigger: 'manual', placement: 'top'});

            var clipboard = new ClipboardJS('.copy-link');

            clipboard.on('success', function(e) {
                $(e.trigger).tooltip('show');
                setTimeout(function() {
                    $(e.trigger).tooltip('hide');
                }, 1000);
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
@endpush
