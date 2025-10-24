@extends('layouts.master')
@section('content')
    <section class="signup" id="app">
        <div class="">
            <div class="">
                <div class="">
                    <div class="">
                        <div class="card" style="border-radius: 15px">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h2 class="card-title">Create Alumni</h2>
                                    <a href="{{ route('alumni.index') }}" class="btn btn-success">Alumni List</a>
                                </div>
                            </div>
                            <div class="card-body p-4">

                                <form @submit.prevent>
                                    <h4 class="pb-3 text-info">Student Information</h4>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Name</label>
                                                <input type="text" id="form3Example1cg" class="form-control"
                                                    v-model="name" readonly="readonly" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Department</label>
                                                <input type="text" id="form3Example1cg" class="form-control"
                                                    v-model="department" readonly="readonly" />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Batch</label>
                                                <input type="text" id="form3Example1cg" class="form-control"
                                                    v-model="batch" readonly="readonly" />
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Shift</label>
                                                <input type="text" id="form3Example1cg" class="form-control"
                                                    v-model="shift" readonly="readonly" />
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Reg_code</label>
                                                <input type="text" id="form3Example1cg" class="form-control"
                                                    v-model="reg_code" readonly="readonly" />
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Session</label>
                                                <input type="text" id="form3Example1cg" class="form-control"
                                                    v-model="session" readonly="readonly" />
                                            </div>
                                        </div> --}}
                                    </div>

                                    <hr />
                                    <h4 class="pb-3 text-info">Contact Information</h4>
                                    <label class="form-label">Mobile Number</label>
                                    <h6 class="text-danger my-1" v-if="mobileError" v-text='mobileError'>

                                    </h6>
                                    <div class="mobiles">
                                        <div class="form-row" v-for="(mobile, index) in mobiles" :key="index">
                                            <div class="form-group col-12">
                                                <input v-model="mobiles[index]" type="tel" class="form-control"
                                                    placeholder="Enter number ex: 01XXXXXXXXX" />
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="d-flex float-right">
                                                    <button class="btn btn-danger mr-3" @click="remove_mobile(index)"
                                                        v-show="index || (!index && mobile.length > 20)">
                                                        <i class="fa fa-minus mr-2"></i>Remove
                                                    </button>
                                                    <button @click="add_mobile" type="button" :disabled="loading"
                                                        class="btn btn-info">
                                                        <i class="fa fa-plus"></i>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="email">
                                        <label class="form-label">Email</label>
                                        <h6 class="text-danger my-1" v-if="emailError" v-text='emailError'>

                                        </h6>
                                        <div class="form-row" v-for="(email, index) in emails" :key="index">
                                            <div class="form-group col-12">
                                                <input v-model="emails[index]" type="email" class="form-control"
                                                    placeholder="Enter email" />
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="d-flex float-right">
                                                    <button class="btn btn-danger mr-3" @click="remove_email(index)"
                                                        v-show="index || (!index && email.length > 25)">
                                                        <i class="fa fa-minus mr-2"></i>Remove
                                                    </button>
                                                    <button @click="add_email" type="button" class="btn btn-info"
                                                        :disabled="loading">
                                                        <i class="fa fa-plus"></i>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-outline mb-2">
                                        <label class="form-label mb-2 mt-3" for="form3Example1cg">Present Address</label>
                                        <!-- Corrected textarea -->
                                        <textarea id="form3Example1cg" class="form-control" placeholder="Enter address" v-model="present_address"></textarea>

                                        <h6 class="text-danger mt-1" v-if="error.present_address"
                                            v-text="error.present_address[0]"></h6>
                                    </div>
                                    <hr />
                                    <h4 class="pb-3 text-info">Job Details</h4>

                                    <div class="work-experiences">
                                        <div class="form-row" v-for="(experience, index) in workExperiences"
                                            :key="index">
                                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                                <label class="form-label">Company Name</label>
                                                <input v-model="experience.company_name"
                                                    :name="`workExperiences[${index}][company_name]`" type="text"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                                <label class="form-label">Company Address</label>
                                                <input v-model="experience.company_address"
                                                    :name="`workExperiences[${index}][company_address]`" type="text"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                                <label class="form-label">Start Date</label>
                                                <input v-model="experience.start_date"
                                                    :name="`workExperiences[${index}][start_date]`" type="date"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                                <label class="form-label">End Date</label>
                                                <input v-model="experience.end_date"
                                                    :name="`workExperiences[${index}][end_date]`" type="text"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                                <label class="form-label">Department</label>
                                                <input v-model="experience.department"
                                                    :name="`workExperiences[${index}][department`" type="text"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                                <label class="form-label">Responsibility</label>
                                                <input v-model="experience.responsibility"
                                                    :name="`workExperiences[${index}][responsibility]`" type="text"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-12 col-lg-12 col-sm-12">
                                                <h6 class="text-danger mt-1" v-if="error.work_xperiences"
                                                    v-text='error.work_xperiences[0]'>
                                                </h6>
                                                <h6 class="text-danger mt-1" v-if="experienceError"
                                                    v-text='experienceError'>

                                                </h6>

                                                <div class="d-flex float-right">
                                                    <button class="btn btn-danger mr-3" @click="remove_Experience(index)"
                                                        v-show=" index || (!index && workExperiences.length > 200)">
                                                        <i class="fa fa-minus mr-2"></i>Remove
                                                    </button>
                                                    <button @click="add_Experience" type="button" :disabled="loading"
                                                        class="btn btn-info d-flex float-right">
                                                        <i class="fa fa-plus pt-1 pr-2"></i>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 class="pb-3 text-info">Social Links</h4>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Facebook</label>
                                                <input type="url" id="form3Example1cg" class="form-control"
                                                    placeholder="Enter link" v-model="facebook_link" />
                                                <h6 class="text-danger mt-1" v-if="error.facebook_link"
                                                    v-text='error.facebook_link[0]'>

                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">LinkedIn</label>
                                                <input type="url" id="form3Example1cg" class="form-control"
                                                    placeholder="Enter link" v-model="linkedin_link" />
                                                <h6 class="text-danger mt-1" v-if="error.linkedin_link"
                                                    v-text='error.linkedin_link[0]'>

                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Instagram
                                                </label>
                                                <input type="url" id="form3Example1cg" class="form-control"
                                                    placeholder="Enter link" v-model="instagram_link" />
                                                <h6 class="text-danger mt-1" v-if="error.instagram_link"
                                                    v-text='error.instagram_link[0]'>

                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-outline mb-2">
                                                <label class="form-label mb-2" for="form3Example1cg">Twitter
                                                </label>
                                                <input type="url" id="form3Example1cg" class="form-control"
                                                    placeholder="Enter link" v-model="twitter_link" />
                                                <h6 class="text-danger mt-1" v-if="error.twitter_link"
                                                    v-text='error.twitter_link[0]'>

                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="form-outline mb-4">
                                        <label class="form-label mb-2" for="form3Example1cg">Picture</label>
                                        <h6 class="text-danger mt-1" v-if="error.avatar" v-text='error.avatar[0]'>

                                        </h6>
                                        <input type="file" id="form3Example1cg" class="form-control"
                                            @change="avatar = $event.target.files[0]" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label mb-2" for="form3Example1cg">CV</label>
                                        <h6 class="text-danger mt-1" v-if="error.cv" v-text='error.cv[0]'>

                                        </h6>
                                        <input type="file" id="form3Example1cg" class="form-control"
                                            @change="cv = $event.target.files[0]" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label mb-2" for="form3Example1cg">Short Interview Video
                                        </label>
                                        <h6 class="text-danger mt-1" v-if="error.short_interview_video"
                                            v-text='error.short_interview_video[0]'>

                                        </h6>
                                        <input type="file" id="form3Example1cg" class="form-control"
                                            @change="short_interview_video = $event.target.files[0]" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label mb-2" for="form3Example1cg">Memories at DIU
                                        </label>
                                        <h6 class="text-danger mt-1" v-if="error.memories_at_diu"
                                            v-text='error.memories_at_diu[0]'>

                                        </h6>
                                        <input type="file" id="form3Example1cg" class="form-control"
                                            @change="memories_at_diu = $event.target.files[0]" />
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="d-flex mb-4">
                                                <h6 class="mr-3">
                                                    Do you like to help Diu alumni
                                                    <input type="radio" id="" value="0"
                                                        class="ml-5 mr-2 pt-5" v-model="help_alumni" />Yes
                                                    <input type="radio" id="" value="1"
                                                        class="ml-3 mr-2 pt-5" v-model="help_alumni" />No
                                                </h6>
                                            </div>
                                            <h6 class="text-danger" v-if="error.help_alumni"
                                                v-text='error.help_alumni[0]'>
                                            </h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="d-flex">
                                                <h6 class="mr-3">
                                                    Looking for jobs
                                                    <input type="radio" id="" value="0"
                                                        class="ml-5 mr-2 pt-5" v-model="job_seeker" />Yes
                                                    <input type="radio" id="" value="1"
                                                        class="ml-3 mr-2 pt-5" v-model="job_seeker" />No
                                                </h6>
                                            </div>
                                            <h6 class="text-danger mt-1" v-if="error.job_seeker"
                                                v-text='error.job_seeker[0]'>
                                            </h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="d-flex">
                                                <h6 class="mr-3">
                                                    Interested to Join Reunion
                                                    <input type="radio" id="" value="0"
                                                        class="ml-5 mr-2 pt-5" v-model="interested_to_join_reunion" />Yes
                                                    <input type="radio" id="" value="1"
                                                        class="ml-3 mr-2 pt-5" v-model="interested_to_join_reunion" />No
                                                </h6>
                                            </div>
                                            <h6 class="text-danger mt-1" v-if="error.interested_to_join_reunion"
                                                v-text='error.interested_to_join_reunion[0]'>

                                            </h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="d-flex">
                                                <h6 class="mr-3">
                                                    Interested to Join Club
                                                    <input type="radio" id="" value="0"
                                                        class="ml-5 mr-2 pt-5" v-model="interested_to_join_club" />Yes
                                                    <input type="radio" id="" value="1"
                                                        class="ml-3 mr-2 pt-5" v-model="interested_to_join_club" />No
                                                </h6>
                                            </div>
                                            <h6 class="text-danger mt-1" v-if="error.interested_to_join_club"
                                                v-text='error.interested_to_join_club[0]'>
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button @click="storeData" type="button"
                                            class="btn btn-info btn-block btn-lg text-body" :disabled="loading">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                alumni: {!! json_encode($alumni) !!},
                loading: false,
                name: {!! json_encode($alumni->name ?? '') !!},
                batch: {!! json_encode($alumni->batch ?? '') !!},
                department: {!! json_encode($alumni->department ?? '') !!},
                reg_code: {!! json_encode($alumni->regcode ?? '') !!},
                passing_year: {!! json_encode($alumni->passing_year ?? '') !!},
                mobiles: [{!! json_encode($alumni->PHONE_NO ?? '') !!}],
                emails: [{!! json_encode($alumni->EMAIL ?? '') !!}],
                present_address: {!! json_encode($alumni->PARMANENT_ADD ?? '') !!},
                workExperiences: [{
                    company_name: "",
                    company_address: "",
                    start_date: "",
                    end_date: "",
                    department: "",
                    responsibility: "",
                }, ],
                facebook_link: {!! json_encode($alumni->Facebook_Link ?? '') !!},
                linkedin_link: {!! json_encode($alumni->LinkedIn_Link ?? '') !!},
                instagram_link: "",
                twitter_link: "",
                avatar: "",
                cv: "",
                short_interview_video: "",
                help_alumni: "",
                job_seeker: "",
                interested_to_join_reunion: "",
                interested_to_join_club: '',
                memories_at_diu: '',
                transcript_id: {!! json_encode($alumni->id ?? '') !!},
                error: "",
            },
            methods: {
                storeData() {
                    const alumni = new FormData();
                    alumni.append("data", JSON.stringify(this._data));
                    alumni.append("avatar", this.avatar);
                    alumni.append("cv", this.cv);
                    alumni.append("short_interview_video", this.short_interview_video);
                    alumni.append("memories_at_diu", this.memories_at_diu);

                    this.loading = true;
                    axios
                        .post(`/alumni`, alumni, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((res) => {
                            this.loading = false;
                            toastr.success('User Created Successfully');
                            setTimeout(() => {
                                window.location.href = '/assign-alumni';
                            }, 2000);

                        })
                        .catch((err) => {
                            if (err.response.status == 422) {
                                this.error = err.response.data.error;
                                toastr.error('Validation error');
                                this.loading = false;
                            } else {
                                toastr.error("Something Went Wrong");

                            }
                            this.loading = false;
                        });

                },

                add_mobile() {
                    if (this.mobiles.length <= 3) {
                        this.mobiles.push("");
                    }
                },
                remove_mobile(index) {
                    this.mobiles.splice(index, 1);
                },
                add_email() {
                    if (this.mobiles.length <= 3) {
                        this.emails.push("");
                    }
                },
                remove_email(index) {
                    this.emails.splice(index, 1);
                },
                add_Experience() {
                    if (this.workExperiences.length <= 11) {
                        this.workExperiences.push({
                            company_name: "",
                            company_address: "",
                            start_date: "",
                            end_date: "",
                            department: "",
                            responsibility: "",
                        });
                    }
                },
                remove_Experience(index) {
                    this.workExperiences.splice(index, 1);
                },


            },

            computed: {
                experienceError() {
                    let message;
                    for (let i in this.error) {
                        let ar = i.split(".");
                        if (ar[0] === "workExperiences") {
                            message = "please fill all the work experience fields";
                            break;
                        } else {
                            message = "";
                        }
                    }
                    return message;
                },
                emailError() {
                    let message;
                    for (let i in this.error) {
                        let ar = i.split(".");
                        if (ar[0] === "emails") {
                            message = this.error[i][0];
                            break;
                        } else {
                            message = "";
                        }
                    }
                    return message;
                },
                mobileError() {
                    let message;
                    for (let i in this.error) {
                        let ar = i.split(".");
                        if (ar[0] === "mobiles") {
                            message = this.error[i][0];
                            break;
                        } else {
                            message = "";
                        }
                    }
                    return message;
                },
            },



        });
    </script>
@endsection
