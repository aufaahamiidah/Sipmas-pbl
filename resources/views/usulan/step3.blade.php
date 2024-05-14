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
                                                <th><button class="btn btn-success"><i
                                                            class="fa fa-file-invoice"></i></button></th>
                                            </tr>
                                            <tr>
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
                                    <input type="number" name="total" class="form-control" placeholder="" required>
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
                                <div class="col-12">
                                    <input type="number" name="total" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row form-group-row p-3">
                                <div class="col-12">
                                    <label>Rencana Anggaran Biaya (RAB) <sup><span
                                                style="color: red">(pdf)*</span></sup></label>
                                </div>
                                <div class="col-12">
                                    <input name="" type="number" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
