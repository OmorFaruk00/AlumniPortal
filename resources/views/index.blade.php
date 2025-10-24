<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DIU | Alumni Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('asset/img/url.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <!-- Font Awesome 5.15.4 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="{{ asset('asset/css/adminlte.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('asset/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">
</head>

<body class="hold-transition login-page">


    <div class="login-box" id="app">
        <div class=" text-center pb-4">
            <img src="{{ asset('asset/img/logo.png') }}" alt="" height="120px">
        </div>
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            {{-- <img src="https://www.citybankplc.com/dist/img/logo/citylogo.png" alt="" height="120px"> --}}
            <div class="card-header text-center">
                <p class="h1"><b>Alumni </b>Portal</p>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <div v-if="error" class="alert alert-danger text-center">
                    <p v-text="error"></p>
                </div>

                <div>
                    <div class="input-group mb-4">
                        <input type="email" class="form-control" placeholder="Email" v-model="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" class="form-control" placeholder="Password" v-model="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-success btn-block" @click="login()">Sign In</button>
                        </div>
                    </div>
                </div>



                {{-- <p class="mb-1">
                    <a href="#">I forgot my password</a>
                </p> --}}

            </div>
        </div>
    </div>

    <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('asset/js/adminlte.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                email: 'omorfaruk5020@gmail.com',
                password: 'Diu@2025',
                error: '',
            },
            methods: {
                login() {
                    axios.post('login', {
                            email: this.email,
                            password: this.password,
                        })
                        .then(response => {
                            console.log(response);
                            window.location.href = "{{ route('dashboard') }}";
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                this.error = error.response.data.message;
                            } else {
                                this.error = 'Something Went Wrong';
                            }

                        });
                },
            },
            created() {},
        });
    </script>

</body>

</html>
