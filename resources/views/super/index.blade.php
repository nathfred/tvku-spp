@extends('layouts.super.app')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar User</h3>
                    <p class="text-subtitle text-muted">Tabel Daftar User E-SPP</p>
                    <a href="/logout" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1" name="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Lengkap</th>
                                <th>Role</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @if ($users->isNotEmpty())
                                @foreach ($users as $user)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td style="height: 70px;">
                                            <a href="{{ route('super-show-user', ['id' => $user->id]) }}" class="btn btn-info"><i class="bi bi-arrow-left-square"></i></a>
                                            {{-- <a href="{{ route('super-delete-user', ['id' => $user->user->id]) }}" class="btn btn-danger"><i class="bi bi-x-square"></i></a> --}}
                                            <button class="btn btn-danger" onclick="delete_confirm('{{ $user->id }}')"><i class="bi bi-x-square"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td align='center' colspan='6'>Tidak Ada Data</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

    <script src="{{ asset('vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
    <script>
        function delete_confirm(user_id) {
            var user_id = user_id;
            var url = '{{ route("super-delete-user", ":slug") }}';
            url = url.replace(':slug', user_id);
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Aksi ini tidak dapat diulangi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus user!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil terhapus.',
                        'success'
                    )
                }
            })
        }
    </script>

@include('super.alerts')

@endsection