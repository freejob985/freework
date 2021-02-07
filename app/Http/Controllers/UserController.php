<?php

namespace App\Http\Controllers;

use App\Models\FreelancerAccount;
use App\Models\UserProfile;
use App\User;
use Cache;
use DB;
use Gate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all_freelancers(Request $request)
    {
        if (Gate::allows('freelancers_index')) {
            $sort_search = null;
            $col_name = null;
            $query = null;
            $freelancers = UserProfile::where('user_role_id', '2');
            if ($request->search != null || $request->type != null) {
                if ($request->has('search')) {
                    $sort_search = $request->search;
                    $user_ids = User::where(function ($user) use ($sort_search) {
                        $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
                    })->pluck('id')->toArray();
                    $freelancers = $freelancers->where(function ($freelancer) use ($user_ids) {
                        $freelancer->whereIn('user_id', $user_ids);
                    });
                }
                if ($request->type != null) {
                    $var = explode(",", $request->type);
                    $col_name = $var[0];
                    $query = $var[1];
                    $freelancers = $freelancers->orderBy($col_name, $query);
                }

                $freelancers = $freelancers->paginate(10);
            } else {
                $freelancers = $freelancers->orderBy('created_at', 'desc')->paginate(10);
            }

            return view('admin.default.freelancers.index', compact('freelancers', 'sort_search', 'col_name', 'query'));
        } else {
            flash('You do not have access permission')->error();
            return back();
        }
    }

    public function all_clients(Request $request)
    {
        $sort_search = null;
        $col_name = null;
        $query = null;
        $clients = UserProfile::where('user_role_id', '3');
        if ($request->search != null || $request->type != null) {
            if ($request->has('search')) {
                $sort_search = $request->search;
                $user_ids = User::where(function ($user) use ($sort_search) {
                    $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
                })->pluck('id')->toArray();
                $clients = $clients->where(function ($client) use ($user_ids) {
                    $client->whereIn('user_id', $user_ids);
                });
            }
            if ($request->type != null) {
                $var = explode(",", $request->type);
                $col_name = $var[0];
                $query = $var[1];
                $clients = $clients->orderBy($col_name, $query);
            }

            $clients = $clients->paginate(10);
        } else {
            $clients = $clients->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('admin.default.clients.index', compact('clients', 'sort_search', 'col_name', 'query'));
    }

    public function comprehensive()
    {
        //
        $id = array();
        foreach (DB::table('users')->orderBy('id', 'desc')->where('comprehensive', "1")->get() as $item_item_user) {
            $id[] = $item_item_user->id;
        }
        return $id;
    }
    public function all_comprehensive(Request $request)
    {
        $id_ = $this->comprehensive();
        // dd($id_);
        $sort_search = null;
        $col_name = null;
        $query = null;
        $clients = UserProfile::where('user_role_id', '3');
        if ($request->search != null || $request->type != null) {

            $clients = $clients->paginate(10);
        } else {
            $clients = $clients->orderBy('created_at', 'desc')->whereIn('user_id', $id_)->paginate(10);
        }
        return view('admin.default.comprehensive.index', compact('clients', 'sort_search', 'col_name', 'query'));
    }

    public function Advertisement(Request $request)
    {
        //  dd("Catch errors for script and full tracking ( 1 )");
        $id_ = $this->comprehensive();
        // dd($id_);
        $sort_search = null;
        $col_name = null;
        $query = null;
        $clients = UserProfile::where('user_role_id', '3');
        if ($request->search != null || $request->type != null) {
            $clients = $clients->paginate(10);
        } else {
            $clients = $clients->orderBy('created_at', 'desc')->whereIn('user_id', $id_)->paginate(10);
        }
        return view('admin.default.ads.index', compact('clients', 'sort_search', 'col_name', 'query'));
    }

    public function Advertisement_edit(Request $request, $id)
    {
        $this->validate($request, [
            'page' => 'required',
            'Title' => 'required',
            'Code' => 'required',
            'end' => 'required',
            'status' => 'required',
        ], [
            'page.required' => ' عنوان الصفحة مطلوب',
            'Title.required' => ' عنوان الاعلان مطلوب',
            'Code.required' => ' كود الاعلان مطلوب',
            'end.required' => ' تاريخ الانتهاء مطلوب',
            'status.required' => ' حالة الاعلان مطلوب',

        ]);
        DB::table('ads')
            ->where('id', $id)
            ->update([
                'page' => $request->input('page'),
                'pos' => $request->input('pos'),
                'Title' => $request->input('Title'),
                'Code' => $request->input('Code'),
                'end' => date('Y-m-d', strtotime('+ ' . $request->input('end') . 'days')),
                'status' => $request->input('status'),
            ]);
        return redirect()->back()->with('alert-success', 'تم التعديل بنجاح');
    }

    public function Advertisement_edit_pag($id)
    {
        $ads = DB::table('ads')->find($id);
        return view('admin.default.ads.edit', compact('ads'));
    }

    public function Advertisement_dell($id)
    {
        DB::table('ads')->where('id', '=', $id)->delete();
        return redirect()->back()->with('alert-success', 'ssss');

    }

    public function Advertisement_add(Request $request)
    {
        //  dd("Catch errors for script and full tracking ( 1 )");
        $id_ = $this->comprehensive();
        // dd($id_);
        $sort_search = null;
        $col_name = null;
        $query = null;
        $clients = UserProfile::where('user_role_id', '3');
        if ($request->search != null || $request->type != null) {
            $clients = $clients->paginate(10);
        } else {
            $clients = $clients->orderBy('created_at', 'desc')->whereIn('user_id', $id_)->paginate(10);
        }
        return view('admin.default.ads.show', compact('clients', 'sort_search', 'col_name', 'query'));
    }

    public function Advertisement_add__(Request $request)
    {
        $this->validate($request, [
            'page' => 'required',
            'Title' => 'required',
            'Code' => 'required',
            'end' => 'required',
            'status' => 'required',
        ], [
            'page.required' => ' عنوان الصفحة مطلوب',
            'Title.required' => ' عنوان الاعلان مطلوب',
            'Code.required' => ' كود الاعلان مطلوب',
            'end.required' => ' تاريخ الانتهاء مطلوب',
            'status.required' => ' حالة الاعلان مطلوب',

        ]);
        DB::table('ads')->insert([
            'page' => $request->input('page'),
            'pos' => $request->input('pos'),
            'Title' => $request->input('Title'),
            'Code' => $request->input('Code'),
            'end' => date('Y-m-d', strtotime('+ ' . $request->input('end') . 'days')),
            'status' => $request->input('status'),
        ]);

        //  dd("Catch errors for script and full tracking ( 1 )");
        return redirect()->back()->with('alert-success', 'تم اضافة اعلان جديد ');

    }

    public function CourseProgresss($id)
    {
        $CourseProgress = DB::table('ads')->find($id);
        if ($CourseProgress->status == 0) {
            //dd(11);
            DB::table('ads')->where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('success', 'Status changed to Active !');
        } else {
            // dd(1);
            DB::table('ads')->where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('delete', 'Status changed to Deactive !');
        }
    }

    public function freelancer_details($user_name)
    {
        if (Gate::allows('single_freelancer_details')) {
            $user = User::where('user_name', $user_name)->first();
            $user_profile = UserProfile::where('user_id', $user->id)->where('user_role_id', '2')->first();
            $user_account = FreelancerAccount::where('user_id', $user->id)->first();
            return view('admin.default.freelancers.show', compact('user', 'user_profile', 'user_account'));
        } else {
            flash('You do not have access permission')->error();
            return back();
        }
    }

    public function client_details($user_name)
    {
        $user = User::where('user_name', $user_name)->first();
        $user_profile = UserProfile::where('user_id', $user->id)->where('user_role_id', '3')->first();
        $user_account = FreelancerAccount::where('user_id', $user->id)->first();
        $projects = $user->number_of_projects()->paginate(10);
        return view('admin.default.clients.show', compact('user', 'user_profile', 'user_account', 'projects'));
    }

    public function userOnlineStatus()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id)) {
                echo "User " . $user->name . " is online.";
            } else {
                echo "User " . $user->name . " is offline.";
            }

        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->banned) {
            $user->banned = 0;
            $user->save();
            flash(__('User has been unbanned successfully'))->success();
        } else {
            $user->banned = 1;
            $user->save();
            flash(__('User has been banned successfully'))->success();
        }
        return back();
    }
}
