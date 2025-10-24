@extends('layouts.master')
@section('content')
    <section class="content">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Create User</h3>
                            <a href="{{ route('user.index') }}" class="btn btn-success">User List</a>
                        </div>
                    </div>

                    <div class="card-body" id="app">
                        <!-- Alert -->


                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" v-model="form.name" class="form-control" placeholder="Enter Name">
                                <small v-if="errors.name" class="text-danger">@{{ errors.name[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" v-model="form.email" class="form-control" placeholder="Enter Email">
                                <small v-if="errors.email" class="text-danger">@{{ errors.email[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" v-model="form.phone" class="form-control" placeholder="Enter Phone">
                                <small v-if="errors.phone" class="text-danger">@{{ errors.phone[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" v-model="form.designation" class="form-control"
                                    placeholder="Enter Designation">
                                <small v-if="errors.designation" class="text-danger">@{{ errors.designation[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" v-model="form.password" class="form-control" placeholder="Password">
                                <small v-if="errors.password" class="text-danger">@{{ errors.password[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" v-model="form.password_confirmation" class="form-control"
                                    placeholder="Confirm Password">
                            </div>

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" @change="handleFileUpload" class="form-control">
                                <small v-if="errors.image" class="text-danger">@{{ errors.image[0] }}</small>
                            </div>

                            <button type="submit" class="btn btn-success float-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script>
        window.laravelToken = "{{ session('token') }}";
        new Vue({
            el: '#app',
            data: {
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    designation: '',
                    password: '',
                    password_confirmation: '',
                    image: null
                },
                token: window.laravelToken || '',

                errors: {},
                message: '',
                alertType: 'alert-danger'
            },
            methods: {
                handleFileUpload(event) {
                    this.form.image = event.target.files[0];
                },
                async submitForm() {
                    this.errors = {};
                    this.message = '';

                    const formData = new FormData();
                    for (let key in this.form) {
                        formData.append(key, this.form[key]);
                    }

                    try {
                        const response = await axios.post('/user', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        toastr.success('User Created Successfully');
                        this.form = "";
                    } catch (error) {
                        if (error.response) {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            } else if (error.response.status === 401 ) {
                                toastr.error(error.response.data.message || 'Unauthorized Access');
                            } else {
                                toastr.error('Something Went Wrong');
                            }
                        }

                    }
                }
            },

        });
    </script>
@endsection
