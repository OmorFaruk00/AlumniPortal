@extends('layouts.master')
@section('content')
<section class="content">
    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Create User</h3>
                        <a href="{{ route('user.index') }}" class="btn btn-info">User List</a>
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
                const response = await axios.post('https://api.diu.ac/app_image_upload', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
               toastr.success('User Created Successfully');
                // this.form = "";
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    toastr.success('Something Went Wrong');
                }
            }
        }
    },

});
</script>
@endsection
