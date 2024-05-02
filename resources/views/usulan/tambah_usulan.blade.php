@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column gap-5">
        <div class="row pt-5 mb-3">
            <div class="m-0 p-0 row col d-flex align-items-center justify-content-between">
                <h3>Buat Usulan Penelitian</h3>
                <p class="mb-0">Home / Daftar Usulan / Buat Usulan Penelitian</p>
            </div>
        </div>
    </div>
    <div class="container mb-1">
        <div class="row">
            <div class="col">
                <div class="card card-outline">
                    <div class="card-header">
                        <h4 class="card-title"><b>Tahap Pengajuan</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="row gx-5">
                            <div class="col ">
                                <div class="p-3 border border-success bg-light">
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 10px">
                                        <div class="bg-success px-3 pt-1">
                                            <h5>1</h5>
                                        </div>
                                        <h5>Judul Penelitian dan Anggota</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col ">
                                <div class="p-3 border bg-light {{ $data['step'] >= 2 ? 'border-success' : '' }}">
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 10px">
                                        <div class="px-3 pt-1 {{ $data['step'] >= 2 ? 'bg-success' : 'bg-secondary' }}">
                                            <h5>2</h5>
                                        </div>
                                        <h5>Pendanaan</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col ">
                                <div class="p-3 border bg-light {{ $data['step'] >= 3 ? 'border-success' : '' }}">
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 10px">
                                        <div class="px-3 pt-1 {{ $data['step'] >= 3 ? 'bg-success' : 'bg-secondary' }}">
                                            <h5>3</h5>
                                        </div>
                                        <h5>Luaran dan Finalisasi</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('step')
@endsection
