<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\User;
use App\Utility\EmailUtility;
use App\Utility\NotificationUtility;
use Auth;
use DB;
use Illuminate\Http\Request;

class Developer extends Controller
{

    public function Reasons($id, $prog, $services = null)
    {

        return view('admin.default.Developer.rejection', compact('id', 'prog', 'services'));
    }
    public function remove_words($words)
    {
        $url = "/http://sub.digi-gate.com/";
        $words = preg_replace($url, '', $words); // remove numbers
        return trim($words);
    }
    public function Single(Request $request)
    {

        $url = $request->input('link')
        $parts = explode("/", $url);
        echo $parts[count($parts) - 1];

        dd($parts[count($parts) - 1]);

        $user = Auth::user()->id;
        $id = DB::table('notifications')->where('receiver_id', $user)->where('link', $link)->value('id');

        dd($id);
    }
    public function Reasons_send(Request $request)
    {
        $this->validate($request, [
            'Code' => 'required',

        ], [
            'Code.required' => 'موضوع الاشعار فارغ',
        ]);
        $msg = $request->input('Code');
        $id = $request->input('id');
        $prog = $request->input('prog');
        $services = $request->input('services');

        //   dd($request->all());
        $slug = DB::table('projects')->where('id', $prog)->value('slug');
        $slug_services = DB::table('freelancer_services')->where('id', $prog)->value('slug');
        //   $reservation= DB::table('freelancer_services')->find( $prog);
        // dd($slug_services);------------------------------------------
        $email = DB::table('users')->where('id', $id)->value('email');
        if ($services == "services") {
            // route('service.edit', $service->slug);
            NotificationUtility::set_notification(
                "freelancer_proposal_for_project",
                $msg,
                route('service.edit', $slug_services),
                $id,
                1,
                'freelancer'
            );
        } else {
            //  route('projects.edit',)
            NotificationUtility::set_notification(
                "Project_rejected",
                $msg,
                env('APP_URL') . "/projects/" . encrypt($prog) . "/edit",
                $id,
                1,
                'client'
            );

            EmailUtility::send_email(
                "Notice of project rejection",
                $msg,
                $email,
                route('project.details', ['slug' => $slug])
            );
        }

        return redirect()->back()->with('alert-success', 'تم ارسال الاشعار');
    }

    public function login_user_get($id)
    {

        if (!Auth::check()) {
            $user = User::find($id);
            Auth::login($user);
            return redirect()->route('dashboard');

        } else {
            Auth::logout();
            return redirect()->route('user.edit');

        }
    }

    public function project_approval(Request $request)
    {
        // dd($request->status);
        $project = Service::findOrFail($request->id);

        $project->project_approval = $request->status;
        if ($project->save()) {
            //dd("Catch errors for script and full tracking ( 1 )");
            return 1;
        } else {
            //    dd("Catch errors for script and full tracking ( 2 )");
            return 0;
        }
    }

}
