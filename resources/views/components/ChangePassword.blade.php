    <form class="form-horizontal" id="password">
        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputName" placeholder="Old Password" v-model="old_password">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail" placeholder="New Password" v-model="new_password">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputName2" class="col-sm-2 col-form-label">Confirm Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName2" placeholder="Confirm Password" v-model="password_confirmation">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-success" @click="changePassword">Submit</button>
            </div>
        </div>
    </form>
    <script>
        new Vue({
            el: '#password',
            data: {
                   form: {
                    old_password:'',
                    new_password: '',
                    password_confirmation: '',

                },
            },
            methods: {
                changePassword() {
                    // alert('ok');
                    axios.post('change-password')
                        .then(response => {
                            console.log(response);
                            //  window.location.href = "{{ route('home') }}";
                        })
                        .catch(error => {
                            this.error =  error.response.data.message;;

                        });
                },
            },
            created() {
                // alert('ok');
            },
        });
    </script>
