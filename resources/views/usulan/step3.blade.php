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
                                                <th>
                                                    <button type="button" class="btn btn-success"
                                                        onclick="addLuaran()"><b>+</b></button>
                                                    Tambah Luaran Tambahan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="isiLuaran">

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
                                                <th>
                                                    <button type="button" class="btn btn-success"
                                                        onclick="addIKU()"><b>+</b></button>
                                                    Tambah IKU
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="isiIku">

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
                            @foreach ($data['skema_file'] as $key => $item)
                                <div class="row form-group-row p-3">
                                    <div class="col-12">
                                        <label>{{ $item->file_caption }} <sup><span
                                                    style="color: red">({{ $item->file_accepted_type }})@if ($item->is_required == '1')
                                                        *
                                                    @endif </span></sup></label>
                                    </div>
                                    <div class="custom-file">
                                        <input type="hidden" name="id_file[{{ $key }}]">
                                        <input type="file" class="custom-file-input"
                                            accept="{{ $item->file_accepted_type }}" id="{{ $item->file_key }}"
                                            name="inputFile[{{ $key }}]">
                                        <label class="custom-file-label" for="{{ $item->file_key }}">Choose file</label>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="container mb-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ url('tambah_usulan?&step=2&usulan_id=' . $_GET['usulan_id'] . '') }}"
                                        type="button" class="btn btn-warning"><b>Kembali</b></a>
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

@push('js')
    <script>
        const tbLuaran = document.getElementById('isiLuaran');
        var count_luaran = 0;

        function addLuaran() {
            let newLuaran = `
            <tr>
                                                <td colspan="2">
                                                    <select class="custom-select" name="luaran[` + count_luaran + `]">
                                                        <option selected>Pilih Luaran</option>
                                                        @foreach ($data['trx_luaran_tambahan'] as $item)
                                                            <option value="{{ $item->luaran_tambahan_id }}">
                                                                {{ $item->luaran_tambahan_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="targetLuaran[` + count_luaran + `]" class="form-control" placeholder="Luaran Tambahan Target" aria-describedby="addon-wrapping">
                                                </td>
                                            </tr>
        `;
            tbLuaran.innerHTML += newLuaran;
            count_luaran++;
        }

        const tbIku = document.getElementById('isiIku');
        var count_iku = 0;

        function addIKU() {
            let newIku = `
            <tr>
                                                <td colspan="2">
                                                    <select class="custom-select" name="iku[` + count_iku + `]">
                                                        <option selected>Pilih IKU</option>
                                                        @foreach ($data['ref_iku'] as $item)
                                                            <option value="{{ $item->iku_id }}">
                                                                {{ $item->iku_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="realisasiIku[` + count_iku + `]" class="form-control" placeholder="IKU Target" aria-describedby="addon-wrapping">
                                                </td>
                                            </tr>
        `;
            tbIku.innerHTML += newIku;
            count_iku++;
        }
    </script>
@endpush
