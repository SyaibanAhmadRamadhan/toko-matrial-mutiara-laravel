@extends('layouts.main')

@section('container')
    <div class="wrapper">
        @include('partials.navbar')
        @include('partials.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>data kasbon</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row pl-0 flex-column flex-md-row justify-content-between">
                                        <div class="mb-3 mb-md-0 col-12 col-md-6">
                                            <span>Export : </span>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    Pdf </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                    style="position: absolute; transform: translate3d(0px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item"
                                                        href="/kasbon/export/pdf/lunas?dari={{ isset($_GET['dari']) ? $_GET['dari'] : '' }}&sampai={{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}">Lunas</a>
                                                    <a class="dropdown-item"
                                                        href="/kasbon/export/pdf/belum lunas?dari={{ isset($_GET['dari']) ? $_GET['dari'] : '' }}&sampai={{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}">Belum
                                                        Lunas</a>
                                                    <a class="dropdown-item"
                                                        href="/kasbon/export/pdf/semua?dari={{ isset($_GET['dari']) ? $_GET['dari'] : '' }}&sampai={{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}">Semua</a>
                                                </div>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    Excel </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                    style="position: absolute; transform: translate3d(0px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item"
                                                        href="/kasbon/export/excel/lunas?dari={{ isset($_GET['dari']) ? $_GET['dari'] : '' }}&sampai={{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}">Lunas</a>
                                                    <a class="dropdown-item"
                                                        href="/kasbon/export/excel/belum lunas?dari={{ isset($_GET['dari']) ? $_GET['dari'] : '' }}&sampai={{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}">Belum
                                                        Lunas</a>
                                                    <a class="dropdown-item"
                                                        href="/kasbon/export/excel/semua?dari={{ isset($_GET['dari']) ? $_GET['dari'] : '' }}&sampai={{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}">Semua</a>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" method="get" class="col-12 col-md-6 w-100">
                                            <div class="input-group">
                                                <label for="" class="p-2">dari</label>
                                                <input type="date" required class="form-control " name="dari"
                                                    value="{{ isset($_GET['dari']) ? $_GET['dari'] : '' }}">
                                                <label for="" class="p-2">sampai</label>
                                                <input type="date" required class="form-control " name="sampai"
                                                    value="{{ isset($_GET['sampai']) ? $_GET['sampai'] : '' }}">
                                            </div>
                                            <div class="input-group">
                                                <label for="" class="p-2">status</label>
                                                <select name="status" class="form-control">
                                                    <option value="semua" selected>semua</option>
                                                    <option value="lunas">lunas</option>
                                                    <option value="belum lunas">belum lunas</option>
                                                </select>
                                                <button class="btn btn-success ml-2" type="submit"
                                                    id="button-addon2">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (session()->has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="alert-success" style="padding: 0.5em; margin-bottom: 1em">
                                        <center>
                                            TOTAL KASBON
                                            <h6>@currency($total)</h6>
                                        </center>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>tanggal kasbon</th>
                                                <th>uang kasbon</th>
                                                <th>nama</th>
                                                <th>no telepon</th>
                                                <th>keterangan</th>
                                                <th>status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kasbon as $key => $p)
                                                <tr>
                                                    <td>{{ $p->tanggal_kasbon }}</td>
                                                    <td>@currency($p->uang_kasbon)</td>
                                                    <td>{{ $p->nama }}</td>
                                                    <td>{{ $p->no_telepon }}</td>
                                                    <td>{{ $p->keterangan }}</td>
                                                    <td>{{ $p->status }}</td>
                                                    <td>
                                                        <div class="d-flex flex-row mb-3">
                                                            <div><button type="button"
                                                                    onclick="location.href='{{ route('kasbon.update', ['id' => $p->id]) }}'"
                                                                    class="btn">
                                                                    <i class="material-icons text-warning">edit</i>
                                                                </button></div>
                                                            <div>
                                                                <form class="form-button-action"
                                                                    action="{{ route('kasbon.delete.post', $p->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn">
                                                                        <i class="material-icons text-danger">delete</i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection
