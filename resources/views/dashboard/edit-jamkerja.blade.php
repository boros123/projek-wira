@extends('layout.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="panel col-lg-9  mx-auto p-3 rounded "  style="background-color:  #1100ff">
            <form action="{{route('update-jam-kerja', $data->id)}}" method="post" id="form" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-evenly">


                    <div class="mb-3 col-12 col-lg-6">
                        <select class="form-control" id="exampleFormControlSelect1" name="jam_kerja">
                            <option  value="{{ $data->jam_kerja }}">{{ $data->jam_kerja }}</option>
                            <option  value="normal">Normal</option>
                            <option  value="lembur">Lembur</option>
                        </select>
                    </div>


                    <div class="col-lg-12 mt-3">
                        <div class="d-flex justify-content-center">
                            <Button class="btn btn-light col-12" id="submit" type="submit">Simpan</Button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>

    </div>

@endsection