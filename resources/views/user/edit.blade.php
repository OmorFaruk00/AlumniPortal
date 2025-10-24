@extends('layouts.master')
@section('content')
    <section class="content">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Edit User</h3>
                            <a href="{{ route('user.index') }}" class="btn btn-success">User List</a>
                        </div>
                    </div>

                    <div class="card-body" id="app">
                        <form @submit.prevent="updateForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" v-model="form.name" class="form-control">
                                <small v-if="errors.name" class="text-danger">@{{ errors.name[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" v-model="form.email" class="form-control">
                                <small v-if="errors.email" class="text-danger">@{{ errors.email[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" v-model="form.phone" class="form-control">
                                <small v-if="errors.phone" class="text-danger">@{{ errors.phone[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" v-model="form.designation" class="form-control">
                                <small v-if="errors.designation" class="text-danger">@{{ errors.designation[0] }}</small>
                            </div>

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" @change="handleFileUpload" class="form-control">
                                <div v-if="form.image_url">
                                    <img :src="form.image_url" class="mt-2 rounded" width="100">
                                </div>
                                <small v-if="errors.image" class="text-danger">@{{ errors.image[0] }}</small>
                            </div>

                            <button type="submit" class="btn btn-success float-right">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        new Vue({
            el: '#app',
            data: {
                form: {
                    id: "{{ $user->id }}",
                    name: "{{ $user->name }}",
                    email: "{{ $user->email }}",
                    phone: "{{ $user->phone }}",
                    designation: "{{ $user->designation }}",
                    password: '',
                    password_confirmation: '',
                    image: null,
                    image_url: "{{ $user->image ? asset($user->image) : '' }}"
                },
                errors: {}
            },
            methods: {
                handleFileUpload(event) {
                    this.form.image = event.target.files[0];
                },
                async updateForm() {
                    this.errors = {};
                    let formData = new FormData();
                    for (let key in this.form) {
                        if (this.form[key] !== null) {
                            formData.append(key, this.form[key]);
                        }
                    }
                    formData.append('_method', 'PUT');

                    try {
                        const response = await axios.post('/user/' + this.form.id, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        toastr.success('User Updated Successfully');
                        // window.location.reload();
                    } catch (error) {
                        if (error.response) {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            } else if (error.response.status === 401) {
                                toastr.error(error.response.data.message || 'Unauthorized Access');
                            } else {
                                toastr.error('Something Went Wrong');
                            }
                        }

                    }
                }
            }
        });
    </script>
@endsection
