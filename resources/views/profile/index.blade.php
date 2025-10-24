@extends('layouts.master')
@section('content')
    <style>
        .nav-pills .nav-link {
            color: #000 !important;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #00bc8c;
        }
    </style>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#profile" data-toggle="tab">Profile</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#editProfile" data-toggle="tab">Edit Profile</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="#changePassword" data-toggle="tab">Change Password</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        <!-- Profile Tab -->
                        <div class="active tab-pane py-5" id="profile">
                            <x-Profile />
                            {{-- <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('asset/img/omor.jpg') }}">
                                    </div>
                                    <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                                    <p class="text-muted text-center">{{ Auth::user()->designation }}</p>
                                </div>
                            </div> --}}
                        </div>

                        {{-- <!-- Edit Profile Tab -->
                        <div class="tab-pane" id="editProfile">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Designation</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Designation">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}

                        <!-- Change Password Tab -->
                        <div class="tab-pane" id="changePassword">
                            <form class="form-horizontal" @submit.prevent="changePassword">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Old Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" v-model="form.current_password"
                                            placeholder="Old Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" v-model="form.password"
                                            placeholder="New Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" v-model="form.password_confirmation"
                                            placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        new Vue({
            el: '.tab-content',
            data: {
                form: {
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }
            },
            methods: {
                changePassword() {
                    axios.post("{{ route('password.update') }}", this.form)
                        .then(res => {
                            console.log(res);
                            toastr.success(res.data.message);
                            this.form = "";
                            setTimeout(() => {
                                window.location.href = "/";
                            }, 1500);
                        })
                        .catch(err => {
                            if (err.response && err.response.data.errors) {
                                Object.values(err.response.data.errors).forEach(e => toastr.error(e[0]));
                            } else if (err.response && err.response.data.message) {
                                toastr.error(err.response.data.message);
                            } else {
                                toastr.error('Something went wrong!');
                            }
                        });
                }
            },

        });
    </script>
@endsection
