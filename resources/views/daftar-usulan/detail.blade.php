@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column gap-5">
        <div class="row pt-5 mb-3">
            <div class="m-0 p-0 row col d-flex align-items-center justify-content-between">
                <h3>Detail Usulan</h3>
                <p class="mb-0">Home / Detail Usulan</p>
            </div>
        </div>
    </div>
    <div class="container mt-3 d-flex justify-content-end">
        <button class="btn btn-warning"><b>Kembali</b></button>
    </div>
    <div class="row mt-4">
        <div class="col-lg-5">
            <div class="card card-outline card-primary">
                <div class="card-header"><b>Data Penelitian</b></div>
                <div class="card-body">
                    <form>
                        <div class="row form-group-row">
                            <div class="col-12 col-lg-4">
                                <label>Skema</label>
                            </div>
                            <div class="col">
                                <input type="text" name="skemaid" class="form-control" disabled
                                    value="{{ $data['data_penelitian'][0]->trx_skema_nama }}">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-12 col-lg-4">
                                <label>Judul <b class="text-danger">*</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="skemaid" class="form-control" disabled
                                    value="{{ $data['data_penelitian'][0]->usulan_judul }}">
                            </div>
                        </div>
                        <div class="row form-group-row mt-3">
                            <div class="col-12 col-lg-4">
                                <label>Abstrak <b class="text-danger">*</b></label>
                            </div>
                            <div class="col">
                                <textarea class="form-control" id="abstrak" name="abstrak" disabled>{{ $data['data_penelitian'][0]->usulan_abstrak }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-outline card-primary">
                <div class="card-header"><b>Capaian</b></div>
                <div class="card-body">
                    <div class="row form-group-row">
                        <div class="col-12 col-lg-4">
                            <label>Luaran Wajib</label>
                        </div>
                        <div class="col">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Jenis Luaran Wajib</th>
                                        <th>Luaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['capaian']['luaran_wajib'] as $item)
                                        <tr>
                                            <td>{{ $item->luaran_wajib_nama }}</td>
                                            <td>{{ $item->luaran_wajib_deskripsi }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row form-group-row mt-3">
                        <div class="col-12 col-lg-4">
                            <label>Luaran Tambahan</label>
                        </div>
                        <div class="col">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Jenis Luaran Tambahan</th>
                                        <th>Luaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['capaian']['luaran_tambahan'] as $item)
                                        <tr>
                                            <td>{{ $item->luaran_tambahan_nama }}</td>
                                            <td>{{ $item->luaran_tambahan_target }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form action="/simpan_iku" method="POST">
                        @csrf
                        <input type="hidden" name="usulan_id" value="{{ $_GET['usulan_id'] }}">
                        <div class="row form-group-row mt-3">
                            <div class="col-12 col-lg-4">
                                <label>IKU</label>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            <div class="col">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="col-6">IKU</th>
                                            <th class="col-2">Target Pengusul</th>
                                            <th>Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['capaian']['iku'] as $key => $item)
                                            <tr>
                                                <td>{{ $item->iku_nama }}</td>
                                                <td>{{ $item->iku_target }}</td>
                                                @if ($item->iku_bukti == '')
                                                    <td>
                                                        <input type="hidden" name="id_iku[{{ $key }}]"
                                                            value="{{ $item->iku_id }}">
                                                        <input type="file" name="iku[{{ $key }}]">
                                                    </td>
                                                @else
                                                    <td><a href="{{ route('iku.download') }}"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-outline card-primary">
                <div class="card-header"><b>Anggota</b></div>
                <div class="card-body">
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2" class="bg-success text-center">Dosen Politeknik Negeri Semarang</th>
                                </tr>
                                <tr>
                                    <th class="text-center col-7">Nama Dosen</th>
                                    <th class="text-center col-5">Status Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $data['anggota']['dosen_ketua'][0]->dosen_nama_lengkap }} <b>(Ketua)</b></td>
                                    <td>{{ $data['anggota']['dosen_ketua'][0]->is_verified }}</td>
                                </tr>
                                @foreach ($data['anggota']['dosen_anggota'] as $item)
                                    <tr>
                                        <td>{{ $item->dosen_nama_lengkap }}</td>
                                        <td>{{ $item->is_verified }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" class="bg-success text-center">Mahasiswa</th>
                                </tr>
                                <tr>
                                    <th class="text-center col-3">NIM</th>
                                    <th class="text-center col-5">Nama</th>
                                    <th class="text-center col-4">Program Studi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['anggota']['mahasiswa'] as $item)
                                    <tr>
                                        <td>{{ $item->mhs_id }}</td>
                                        <td>{{ $item->mhs_nama }}</td>
                                        <td>{{ $item->prodi_nama }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card card-outline card-primary">
                <div class="card-header"><b>Berkas Usulan</b></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center col-1">No</th>
                                <th class="text-center col-5">Berkas</th>
                                <th class="text-center col-3">Lihat Berkas</th>
                                <th class="text-center col-3">Status Berkas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['berkas_usulan'] as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->file_caption }}</td>
                                    <td><a href="{{ route('file.download', ['file' => $value->file_name]) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a></td>
                                    <td>
                                        @if ($value->file_status == 0)
                                            <span class="text-warning">Pending</span>
                                        @else
                                            @if ($value->file_status == 1)
                                                <span class="text-success">Valid</span>
                                            @else
                                                <span class="text-danger">Tidak Valid</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-outline card-primary">
                <div class="card-header"><b>Komponen Pendanaan</b></div>
                <div class="card-body">
                    <form>
                        <div class="row form-group-row">
                            <div class="col-12 col-lg-4">
                                <label>Total Pendanaan</label>
                            </div>
                            <div class="col">
                                <input type="text" name="skemaid" class="form-control" disabled
                                    value="{{ $data['komponen_pendanaan']['total_pendanaan'][0]->usulan_pendanaan }}">
                            </div>
                        </div>
                        @foreach ($data['komponen_pendanaan']['detail_pendanaan'] as $item)
                            <div class="row form-group-row mt-3">
                                <div class="col-12 col-lg-4">
                                    <label>{{ $item->pendanaan_nama }} <span class="text-danger">*</span> (Maks. <span
                                            class="text-danger">{{ $item->pendanaan_persentase }}</span>)</label>
                                </div>
                                <div class="col">
                                    <input type="number" name="skemaid" class="form-control" disabled
                                        value="{{ $item->pendanaan_value }}">
                                </div>
                            </div>
                        @endforeach


                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="timeline">
                            <div class="time-label">
                                <span class="bg-blue">10 Februari 2024</span>
                            </div>
                            <div>
                                <i class="fas fa-check bg-yellow"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                                    <h3 class="timeline-header">Draft</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-check bg-green"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
                                    <h3 class="timeline-header">Diusulkan</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
