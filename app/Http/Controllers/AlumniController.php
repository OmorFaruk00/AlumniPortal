<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniInfo;
use App\Models\AlumniJobDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    private $avatar;
    private $short_interview_video;
    private $cv;
    private $memories_at_diu;

    public function index()
    {
        return view('alumni.index');
    }
    public function alumniList()
    {
        $allData = collect();

        if (auth()->user()->role === 'admin') {
            Alumni::chunk(500, function ($alumnis) use (&$allData) {
                $allData = $allData->merge($alumnis);
            });
        } else {
            Alumni::where('created_by', auth()->id())
                ->chunk(500, function ($alumnis) use (&$allData) {
                    $allData = $allData->merge($alumnis);
                });
        }

        return response()->json($allData->values());
    }

    public function store(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $validator = Validator::make($data, [
            'transcript_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'batch' => 'required|string|max:255',
            'reg_code' => 'required|string|max:255',
            'passing_year' => 'required|string|max:255',
            'mobiles' => 'required|array',
            'mobiles.*' => 'required|digits:11',
            'emails' => 'required|array',
            'emails.*' => 'required|string|email|max:255|distinct',
            'present_address' => 'required|string|max:255',
            'facebook_link' => 'required|url|string|max:255',
            'linkedin_link' => 'required|url|string|max:255',
            'instagram_link' => 'url|string|max:255',
            'twitter_link' => 'url|string|max:255',
            'workExperiences.*.company_name' => 'required_with:workExperiences.*.company_address,workExperiences.*.start_date,workExperiences.*.end_date,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.company_address' => 'required_with:workExperiences.*.company_name,workExperiences.*.start_date,workExperiences.*.end_date,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.start_date' => 'required_with:workExperiences.*.company_address,workExperiences.*.company_name,workExperiences.*.end_date,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.end_date' => 'required_with:workExperiences.*.company_address,workExperiences.*.start_date,workExperiences.*.company_name,workExperiences.*.responsibility|string|max:255',
            'workExperiences.*.responsibility' => 'required_with:workExperiences.*.company_address,workExperiences.*.start_date,workExperiences.*.end_date,workExperiences.*.company_name|string|max:255',
            'help_alumni' => 'required|boolean',
            'job_seeker' => 'required|boolean',
            'interested_to_join_reunion' => 'required|boolean',
            'interested_to_join_club' => 'required|boolean',

        ], [
            'user_name.regex' => 'User name must be Alphanumeric and contain one of (_@.#&+-) and must be ends with number',
            'emails.*.required' => 'Email is required',
            'emails.*.email' => 'Email must be valid email',
            'emails.*.distinct' => 'Email must not be duplicated',
            'mobiles.*.required' => 'Phone is required',
            'mobiles.*.digits' => 'Phone must be valid phone number',
            'mobiles.*.distinct' => 'Phone must not be duplicated',
            'facebook_link.url' => 'Must Be Valid URL',
            'linkedin_link.url' => 'Must Be Valid Url',
            'instagram_link.url' => 'Must Be Valid Url',
            'twitter_link.url' => 'Must Be Valid Url',
        ]);
        $imageValidator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'memories_at_diu' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'short_interview_video' => 'nullable|mimes:mp4|max:100000',
        ], [
            'short_interview_video.max' => 'Short interview video should be less than 100 MB',
        ]);

        if ($validator->fails()) {
            info($validator->errors());
            return response()->json(['error' => $validator->errors()], 422);
        }
        if ($imageValidator->fails()) {
            info($imageValidator->errors());
            return response()->json(['error' => $imageValidator->errors()], 422);
        }

        try {
            $this->fileUpload($request);
            DB::transaction(function () use ($data) {

                $user = Alumni::create([
                    "name" => $data['name'],
                    "transcript_id" => $data['transcript_id'],
                    "department" => $data['department'],
                    "batch" => $data['batch'],
                    "reg_code" => $data['reg_code'],
                    "phone" => implode(',', $data['mobiles']),
                    "email" => implode(',', $data['emails']),
                    "present_address" => $data['present_address'],
                    "facebook_link" => $data['facebook_link'],
                    "linkedin_link" => $data['linkedin_link'],
                    "instagram_link" => $data['instagram_link'],
                    "twitter_link" => $data['twitter_link'],
                    "help_alumni" => $data['help_alumni'],
                    "job_seeker" => $data['job_seeker'],
                    "avatar" => $this->avatar,
                    "short_interview_video" => $this->short_interview_video,
                    "cv" => $this->cv,
                    "cv" => $this->cv,
                    "memories_at_diu" => $this->memories_at_diu,
                    "created_by" => auth()->user()->id,
                ]);
                collect($data['workExperiences'])->map(function ($val) use ($user) {
                    if ($val["company_name"] && $val["company_address"] && $val["start_date"] && $val["end_date"] && $val["department"] && $val["responsibility"]) {
                        AlumniJobDetail::create([
                            'alumni_id' => $user->id,
                            'company_name' => $val['company_name'],
                            "company_address" => $val['company_address'],
                            "start_date" => $val['start_date'],
                            "end_date" => $val['end_date'],
                            "department" => $val['department'],
                            "responsibility" => $val['responsibility']
                        ]);
                    }
                });

                AlumniInfo::find($data['transcript_id'])->update(['status' => 1]);
            });
            return response([
                "status" => "success",
                "message" => "Alumni added successfully",
                "status_code" => 200,
            ], 200);
        } catch (\Throwable $th) {
            info($th);
            return response([
                "status" => "error",
                "message" => $th->getMessage(),
                "status_code" => 500,
            ], 500);
        }
    }

    protected function fileUpload($request)
    {
        $jsonString = $request->input('data');
        $data = json_decode($jsonString, true);
        $transcriptId = $data['transcript_id'] ?? null;;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = 'alumni_' . $transcriptId . '.' . $extension;
            $file->move(public_path('uploads/alumni'), $filename);
            $this->avatar = 'uploads/alumni/' . $filename;
        }
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $extension = $file->getClientOriginalExtension();
            $filename = 'cv_' . $transcriptId . '.' . $extension;
            $file->move(public_path('uploads/cv'), $filename);
            $this->cv = 'uploads/cv/' . $filename;
        }
        if ($request->hasFile('memories_at_diu')) {
            $file = $request->file('memories_at_diu');
            $extension = $file->getClientOriginalExtension();
            $filename = 'memories_at_diu_' . $transcriptId . '.' . $extension;
            $file->move(public_path('uploads/memories_at_diu'), $filename);
            $this->memories_at_diu = 'uploads/memories_at_diu/' . $filename;
        }

        if ($request->file('short_interview_video')) {
            $file = $request->file('short_interview_video');
            $extension = $file->getClientOriginalExtension();
            $filename =  $transcriptId . '.' . $extension;
            $filepath = Storage::disk('alumni')->putFileAs('short_interview_video', $request->file('short_interview_video'), $filename);
            $this->short_interview_video = $filepath;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alumni =  AlumniInfo::find($id);
        return view('alumni.create', compact('alumni'));
    }

    public function assignAlumni()
    {
        $alumnis =  AlumniInfo::where('assign_to', auth()->user()->id)->where('status', 0)->get();
        return view('alumni.assign_alumni', compact('alumnis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $requestuest, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
