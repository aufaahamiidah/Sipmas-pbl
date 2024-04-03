@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col mt-5">
            <div class="card card-outline">
                <div class="card-header">
                    <h5 class="m-0"><b>Informasi</b> User</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        <h5>Perhatian!</h5>
                        <p class="m-0 p-0">Profil anda sudah lengkap.</p>
                    </div>
                    <form>
                        <div class="row form-group-row">
                            <div class="col-sm">
                                <label>Email</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="" disabled>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>NIP</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Nama Lengkap</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" placeholder="" required>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>NIDN</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Sinta ID</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Program Studi</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Jabatan Fungsional</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="row form-group-row my-3">
                            <div class="col-sm">
                                <label>Pendidikan</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.toast').toast('show')
    </script>
@endpush
