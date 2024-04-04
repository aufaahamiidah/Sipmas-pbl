@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col mt-5">
            <div class="card card-outline">
                <div class="card-header">
                    <h5 class="m-0"><b>Informasi</b> User</h5>
                </div>
                <div class="card-body">
                    @if (Session::has('warningMsg'))
                        <div class="alert alert-warning" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ Session::get('warningMsg') }}
                        </div>
                    @endif

                    <form action="/edit_data" method="POST">
                        @csrf
                        <div class="row form-group-row">
                            <div class="col-sm">
                                <label>Email</label>
                            </div>
                            <div class="col">
                                <input type="email" value="{{ Auth::user()->email }}" class="form-control" placeholder=""
                                    disabled>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>NIP <span class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                                <input type="text" name="dosen_id" id="dosen_id" class="form-control" placeholder=""
                                    required>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-2">
                                <input type="text" name="dosen_gelar_depan" id="dosen_gelar_depan" class="form-control"
                                    placeholder="Gelar Depan">
                            </div>
                            <div class="col">
                                <input type="text" name="dosen_nama" id="dosen_nama" class="form-control"
                                    placeholder="Nama Lengkap" required>
                            </div>
                            <div class="col-2">
                                <input type="text" name="dosen_gelar_belakang" id="dosen_gelar_belakang"
                                    class="form-control" placeholder="Gelar Belakang">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>NIDN</label>
                            </div>
                            <div class="col">
                                <input type="text" name="dosen_nidn" id="dosen_nidn" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Sinta ID</label>
                            </div>
                            <div class="col">
                                <input type="text" name="dosen_sinta_id" id="dosen_sinta_id" class="form-control"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Program Studi</label>
                            </div>
                            <div class="col">
                                <select class="form-control" name="prodi_id" id="prodi_id">
                                    @foreach (json_decode(MenuHelper::getDataRef('prodi', 'prodi')) as $item)
                                        <option value="{{ $item->prodi_id }}">{{ $item->prodi_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Jabatan Fungsional</label>
                            </div>
                            <div class="col">
                                <select class="form-control" name="jabfung_id" id="jabfung_id">
                                    @foreach (json_decode(MenuHelper::getDataRef('jabatan_fungsional', 'jabfung')) as $item)
                                        <option value="{{ $item->jabfung_id }}">{{ $item->jabfung_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group-row my-3">
                            <div class="col-sm">
                                <label>Pendidikan</label>
                            </div>
                            <div class="col">
                                <select class="form-control" name="pendidikan_id" id="pendidikan_id">
                                    @foreach (json_decode(MenuHelper::getDataRef('pendidikan', 'pendidikan')) as $item)
                                        <option value="{{ $item->pendidikan_id }}">{{ $item->pendidikan_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group-row">
                            <div class="col-sm d-flex justify-content-center flex-column">
                                <button type="submit" class="btn btn-info">Submit</button>
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
