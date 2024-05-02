@extends('usulan.tambah_usulan')

@section('step')
    <form action="">
        <div class="row mb-1">
            <div class="col">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Capaian</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>Luaran Tambahan<b class="text-danger">*</b></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-sm">
                                <label>IKU<b class="text-danger">*</b></label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Berkas Usulan</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="proposalFile">Proposal <sup class="text-danger">(PDF)*</sup></label>
                            <input type="file" class="form-control" id="proposalFile">
                        </div>

                        <div class="form-group">
                            <label for="rabFile">Rencana Anggaran Biaya (RAB) <sup class="text-danger">(PDF)*</sup></label>
                            <input type="file" class="form-control" id="rabFile">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mb-1">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-between">
                            <div class="col">
                                <button type="button" class="btn btn-warning"><b>Kembali</b></button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary"><b>Simpan Draft</b></button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-success"><b>Simpan Permanen</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection
