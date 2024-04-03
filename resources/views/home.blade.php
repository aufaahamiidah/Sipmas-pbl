@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col mt-5">
            <div class="card card-outline">
                <div class="card-header d-flex align-items-center">
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
                                <label>NIP</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="" disabled>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Nama Lengkap</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="" disabled>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Email Polines</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="" disabled>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>NIDN</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="" disabled>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Sinta ID</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="" disabled>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="mt-3 d-sm-flex justify-content-end flex-col">
                            <button type="submit" class="btn btn-danger col-sm-12 col-lg-2">Keluar (Logout)</button>
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
