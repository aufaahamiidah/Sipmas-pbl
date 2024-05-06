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
                            <div class="col-12">
                                <label>Luaran Tambahan<b class="text-danger">*</b></label>
                            </div>
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#luaranModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                    </svg>
                                                </button>
                                            </td>
                                            <td><b>Luaran</b></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-12">
                                <label>IKU<b class="text-danger">*</b></label>
                            </div>
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                    </svg>
                                                </button>
                                            </td>
                                            <td><b>IKU</b></td>
                                            <td><b>Jumlah</b></td>
                                        </tr>
                                    </thead>
                                </table>
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
                            <div class="col-8">
                                <button type="button" class="btn btn-warning"><b>Kembali</b></button>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-primary"><b>Simpan Draft</b></button>
                                <button type="button" class="btn btn-success"><b>Simpan Permanen</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="luaranModal" tabindex="-1" aria-labelledby="luaranModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="luaranModalLabel">Luaran Tambahan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($data['luaran_tambahan'] as $key => $value)
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="luaran_{{ $value->luaran_tambahan_id }}"
                                    name="luaran_{{ $value->luaran_tambahan_id }}" value="">
                                <label class="form-check-label"
                                    for="luaran_{{ $value->luaran_tambahan_id }}">{{ $value->luaran_tambahan_nama }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="pilihLuaran()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
