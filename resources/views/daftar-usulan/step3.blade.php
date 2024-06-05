@extends('daftar-usulan.tambah_usulan')

@section('step')
    <form action="{{ url('step_2') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                                    <table class="table table-bordered" id="tableLuaran">
                                        <thead>
                                            <tr>
                                                <th colspan="3">
                                                    <button type="button" class="btn btn-success"
                                                        onclick="addLuaran()"><b>+</b></button>
                                                    Tambah Luaran Tambahan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="isiLuaran">
                                            @if ($_GET['edit'] != '')
                                                @foreach ($data['luaran_tambahan'] as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <button type="button" class="btn btn-danger delete-row"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </td>
                                                        <td>
                                                            <select class="custom-select"
                                                                name="luaran[{{ $key }}]">
                                                                <option selected value="{{ $value->luaran_tambahan_nama }}">
                                                                    {{ $value->luaran_tambahan_nama }}</option>
                                                                @foreach ($data['trx_luaran_tambahan'] as $item)
                                                                    <option value="{{ $value->luaran_tambahan_id }}">
                                                                        {{ $item->luaran_tambahan_nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
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
                                    <table class="table table-bordered" id="tableIku">
                                        <thead>
                                            <tr>
                                                <th colspan="3">
                                                    <button type="button" class="btn btn-success"
                                                        onclick="addIKU()"><b>+</b></button>
                                                    Tambah IKU
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="isiIku">
                                            @if ($_GET['edit'] != '')
                                                @foreach ($data['iku'] as $key => $value)
                                                    <td>
                                                        <button type="button" class="btn btn-danger delete-row"><i
                                                                class="fa fa-trash"></i></button>
                                                    </td>
                                                    <td>

                                                        <select class="custom-select" name="iku[{{ $key }}]">
                                                            <option selected value="{{ $value->iku_nama }}">
                                                                {{ $value->iku_nama }}
                                                            </option>
                                                            @foreach ($data['ref_iku'] as $item)
                                                                <option value="{{ $item->iku_id }}">
                                                                    {{ $item->iku_nama }}</option>
                                                            @endforeach
                                                        </select>

                                                    </td>
                                                    <td>
                                                        <input type="text" name="realisasiIku[{{ $key }}]"
                                                            class="form-control" placeholder="IKU Target"
                                                            aria-describedby="addon-wrapping"
                                                            value="{{ $value->iku_target }}">
                                                    </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
                                        <input type="hidden" name="id_file[{{ $key }}]"
                                            value="{{ $data['skema_file'][$key]->skema_file_id }}">
                                        <input type="file" class="form-control" accept="{{ $item->file_accepted_type }}"
                                            id="{{ $item->file_key }}" name="inputFile[{{ $key }}]"
                                            @if ($item->is_required == '1') required @endif>
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
                                    <a href="{{ url('tambah_usulan?&step=2&usulan_id=' . $_GET['usulan_id'] . '&edit=1') }}"
                                        type="button" class="btn btn-warning"><b>Kembali</b></a>
                                </div>
                                <div class="col text-right">
                                    <input type="submit" value="Simpan Sebagai Draf" name="btn-save"
                                        class="btn btn-primary" style="transform: scale(0.9)">
                                    <input type="submit" value="Simpan Permanen" name="btn-save" class="btn btn-success"
                                        style="transform: scale(1.1)">
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
            <tr>                                <td>
                                                    <button type="button" class="btn btn-danger delete-row"><i
                                                    class="fa fa-trash"></i></button>
                                                </td>
                                                <td>
                                                    <select class="custom-select" name="luaran[]">
                                                        <option selected>Pilih Luaran</option>
                                                        @foreach ($data['trx_luaran_tambahan'] as $item)
                                                            <option value="{{ $item->luaran_tambahan_id }}">
                                                                {{ $item->luaran_tambahan_nama }}</option>
                                                        @endforeach
                                                    </select>
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
                                                <td>
                                                    <button type="button" class="btn btn-danger delete-row"><i
                                                    class="fa fa-trash"></i></button>
                                                </td>
                                                <td>
                                                    <select class="custom-select" name="iku[]">
                                                        <option selected>Pilih IKU</option>
                                                        @foreach ($data['ref_iku'] as $item)
                                                            <option value="{{ $item->iku_id }}">
                                                                {{ $item->iku_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="realisasiIku[]" class="form-control" placeholder="IKU Target" aria-describedby="addon-wrapping">
                                                </td>
                                            </tr>
        `;
            tbIku.innerHTML += newIku;
            count_iku++;
        }
        var tableIku = document.getElementById('tableIku');
        var tableLuaran = document.getElementById('tableLuaran');

        tableIku.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                e.target.closest('tr').remove();
                const rows = document.querySelectorAll('#tableIku tbody tr');
                rows.forEach((row, index) => {
                    row.querySelector('th').textContent = index + 1;
                });
            }
        });

        tableLuaran.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                e.target.closest('tr').remove();
                const rows = document.querySelectorAll('#tableLuaran tbody tr');
                rows.forEach((row, index) => {
                    row.querySelector('th').textContent = index + 1;
                });
            }
        });
    </script>
@endpush
