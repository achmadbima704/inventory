@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>
            <p class="section-lead">
                Ubah informasi profil di halaman ini.
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}"
                                class="rounded-circle profile-widget-picture">
                        </div>
                        <form id="form-update">
                            <div class="profile-widget-description">
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                                        <div class="invalid-feedback">
                                            Please fill in the first name
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $('#form-update').on('submit', function (e) {
            e.preventDefault()

            let payload = {
                _token: "{{ csrf_token() }}",
                name: $('input[name=name]').val(),
                email: $('input[name=email]').val(),
                password: $('input[name=password]').val(),
                role: "{{ auth()->user()->roles }}",
                id: "{{ auth()->user()->id }}"
            };

            $.ajax({
                url: "{{ route('app.action.updatepetugas') }}",
                method: 'POST',
                data: payload,
                success: function (res) {
                    if (res.success) {
                        alert('profile berhasil diubah');
                    }
                }
            })

        })
    </script>
@endsection
