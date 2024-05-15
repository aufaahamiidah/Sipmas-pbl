@extends('usulan.tambah_usulan')

@section('step')
<form action="">
    <input type="hidden" name="usulan_id" value="{{ $_GET['usulan_id'] }}">
    <div class="container mb-1">

        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Capaian</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="row form-group-row p-3">
                            <div class="col-12">
                                <label>Luaran Tambahan <span style="color: red">*</span></label>
                            </div>
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><button class="btn btn-success"><i class="fa fa-file-invoice"></i></button></th>
                                            <th><b>Luaran</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group-row p-3">
                            <div class="col-12">
                                <label>IKU <span style="color: red">*</span></label>
                            </div>
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><button class="btn btn-success"><i class="fa fa-file-invoice"></i></button> IKU</th>
                                            <th>
                                                <b>Jumlah</b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h4 class="card-title"><b>Berkas Usulan</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="row form-group-row p-3">
                            <div class="col-12">
                                <label>Proposal <sup><span style="color: red">(pdf)*</span></sup></label>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group-row p-3">
                            <div class="col-12">
                                <label>Rencana Anggaran Biaya (RAB) <sup><span style="color: red">(pdf)*</span></sup></label>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mb-1">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ url('tambah_usulan?&step=2&usulan_id=' . $_GET['usulan_id'] . '') }}" type="button" class="btn btn-warning"><b>Kembali</b></a>
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-primary"><b>Simpan Draft</b></button>
                                <button type="submit" class="btn btn-success"><b>Simpan Permanen</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
@endsection