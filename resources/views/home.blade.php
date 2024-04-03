@extends('layouts.app')

@section('content')
    
    <div class="content">
        <div class="container-fluid " style="width: 800px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card  card-outline">
                        <div class="card-header">
                            <h5 class="m-0"><b>Informasi</b> User</h5>
                        </div>
                        <div class="card-body">
                            <div class="card bg-success p-3" style="height: 6rem;">
                                <h5>Perhatian</h5>
                                <p>Profil anda telah lengkap</p>
                            </div>
                            <form>
                                <div class="row form-group-row">
                                    <div class="col">
                                        <label>NIP</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col">
                                        <label>Nama Lengkap</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col">
                                        <label>Email Polines</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col">
                                        <label>NIDN</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row form-group-row mt-3">
                                    <div class="col">
                                        <label>Sinta ID</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </form>
                            <div class="button mt-3">
                                <button type="button" class="btn btn-danger">Keluar (Logout)</button>
                            </div>
                        </div>
                    </div>
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
