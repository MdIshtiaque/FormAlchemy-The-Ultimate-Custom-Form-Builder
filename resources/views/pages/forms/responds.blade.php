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
        <h1>Responds</h1>
        <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Submitted By</th>
                <th>Submit Time</th>
                <th>Action</th>
            </tr>

            </thead>
            <tbody id="tableBody">
            <!-- Data will go here -->
            @foreach ($responds as $index => $respond)
                <tr>
                    <td>{{ $respond->first()->user->name }}</td>
                    <td>{{ $respond->first()->created_at->format('jS F, Y') }}</td>
                    <td>
                        <a type="button" href="{{ route('preview.respond', ['uniqueId' => $respond->first()->unique_id, 'submittedBy' => $respond->first()->user_id]) }}"
                           class="btn btn-primary edit-link btn-edit-link">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
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
@endpush
