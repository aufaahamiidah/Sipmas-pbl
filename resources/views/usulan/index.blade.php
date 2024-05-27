@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column gap-5">
        <div class="row pt-5 mb-3">
            <div class="m-0 p-0 row col d-flex align-items-center justify-content-between">
                <h3>Daftar Usulan</h3>
                <p class="mb-0">Home / Daftar Usulan</p>
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-12 col-md-4 card card-outline">
                <div class="card-header">
                    <h5 class="m-0 text-bold">Tahun Pelaksanaan</h5>
                </div>
                <div class="card-body">
                    <select class="form-control" id="tahunSelect">
                        <option>2024</option>
                        <option>2023</option>
                        <option>2022</option>
                        <option>2021</option>
                        <option>2020</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-12 col-md-7 card card-outline">
                <div class="card-header">
                    <h5 class="m-0 text-bold">Usulan Skema Baru</h5>
                </div>
                <div class="card-body d-flex flex-row flex-wrap" style="gap: 10px;">
                    @foreach (json_decode(MenuHelper::getUsulanSkema()) as $item)
                        <button type="button"
                            class="col-sm-12 col-md btn btn-{{ $item->skema_color }} d-flex flex-column align-items-center"
                            data-toggle="modal" data-target="#Modal{{ $item->skema_id }}">
                            <i class="fas fa-{{ $item->skema_icon }}"></i>
                            <span>{{ $item->skema_nama }}</span>
                        </button>

                        <div class="modal fade" id="Modal{{ $item->skema_id }}" tabindex="-1"
                            aria-labelledby="{{ $item->skema_id }}ModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $item->skema_nama }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body d-flex flex-column" style="gap: 10px">
                                        @foreach ($item->trx_skema as $skema)
                                            <a class="btn btn-info"
                                                href="{{ url('/tambah_usulan') }}?skema_id={{ $item->skema_id }}&step=1&usulan_id=">{{ $skema[0] }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-12 card card-outline">
                <div class="card-body" style="overflow: auto">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Abstrak</th>
                                <th scope="col">Skema</th>
                                <th scope="col">Anggota</th>
                                <th scope="col">Pendanaan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($count_usulan > 0)
                                @foreach ($usulan as $key => $item)
                                    <tr class="m-auto">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item['usulan_judul'] }}</td>
                                        <td>{{ $item['usulan_abstrak'] }}</td>
                                        <td>{{ $item['nama_skema'] }}</td>
                                        <td>
                                            <ul>
                                                <li><b> *Ketua</b> {{ $item['ketua']->dosen_nama }}
                                                    ({{ $item['ketua']->dosen_id }})
                                                </li>
                                                <br>
                                                @foreach ($item['dosen_anggota'] as $val)
                                                    <li>
                                                        {{ $val->dosen_nama_lengkap }} ({{ $val->dosen_id }})
                                                    </li>
                                                @endforeach
                                                <br>
                                                @foreach ($item['mhs_anggota'] as $val)
                                                    <li>
                                                        {{ $val->mhs_nama }} ({{ $val->mhs_id }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @if ($item['count_pendanaan'] > 0)
                                                {{ $item['pendanaan']->first()->pendanaan_value }}
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td>
                                            <span
                                                class="text-{{ $item['status_usulan'][0]->status_color }}">{{ $item['status_usulan'][0]->status_nama }}</span>
                                        </td>
                                        <td>
                                            @if ($item['status_usulan'][0]->status_id == 1)
                                                <a href="{{ url('/tambah_usulan') }}?skema_id={{ $item['skema_id'] }}&step=1&usulan_id={{ $item['usulan_id'] }}"
                                                    class="btn btn-warning">Edit Usulan</a>
                                            @else
                                                <button class="btn btn-warning" disabled>Edit Usulan</button>
    
                                            @endif

                                            <a href="{{url('/detail_usulan')}}" class="btn btn-primary d-flex justify-content-center">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">Data Kosong</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
