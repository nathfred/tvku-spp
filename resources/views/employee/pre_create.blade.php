@extends('layouts.employee.app')

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
                    <h3>Daftar Penugasan</h3>
                    <p class="text-subtitle text-muted">Daftar Penugasan</p>
                </div>
            </div>
        </div>
        <section id="groups">
            <div class="row match-height">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="section-title text-uppercase">Jenis Penugasan</h4>
                </div>
            </div>
            <div class="row match-height">
                <div class="col-12">
                    <div class="card-group">
                        <div class="card">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="{{ asset('img/free.png') }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title">FREE</h4>
                                    <a href="{{ route('employee-create-assignment',['type'=>'Free']) }}" class="btn btn-primary card-text mb-2">Buat Penugasan</a><br>
                                    <p class="card-text">Buat dokumen penugasan baru berjenis Free</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="{{ asset('img/berbayar.png') }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title">BERBAYAR</h4>
                                    <a href="{{ route('employee-create-assignment',['type'=>'Berbayar']) }}" class="btn btn-primary card-text mb-2">Buat Penugasan</a><br>
                                    <p class="card-text">Buat dokumen penugasan baru berjenis Berbayar</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="{{ asset('img/barter.png') }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title">BARTER</h4>
                                    <a href="{{ route('employee-create-assignment',['type'=>'Barter']) }}" class="btn btn-primary card-text mb-2">Buat Penugasan</a><br>
                                    <p class="card-text">Buat dokumen penugasan baru berjenis Barter</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
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

@include('employee.alerts')

@endsection