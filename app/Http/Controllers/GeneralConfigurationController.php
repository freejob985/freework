<?php

namespace App\Http\Controllers;

use App\Utility\SettingsUtility;
use Gate;
use Illuminate\Http\Request;
use DB;

class GeneralConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function CourseProgresss($id)
    {

        if ($id == "active") {
            //dd(11);
            DB::table('Maintenance')->where('id', '=', 1)->update(['Status' => "Not activate"]);
            return back()->with('success', 'Status changed to Active !');
        } else {
            // dd(1);
            DB::table('Maintenance')->where('id', '=', 1)->update(['Status' => "active"]);
            return back()->with('delete', 'Status changed to Deactive !');
        }
    }

    public function index()
    {
        if (Gate::allows('system_configuration')) {
            return view('admin.default.system_configurations.general_config.index');
        } else {
            flash(__('You do not have access permission!'))->warning();
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except(['_token']);

        if (!empty($inputs)) {
            foreach ($inputs as $type => $value) {
                SettingsUtility::save_settings($type, trim($value));
                if ($type == 'site_name') {
                    $system_config = new SystemConfigurationController;
                    $system_config->overWriteEnvFile("APP_NAME", trim($value));
                }
                if ($type == 'timezone') {
                    $system_config = new SystemConfigurationController;
                    $system_config->overWriteEnvFile('APP_TIMEZONE', trim($value));
                }
            }
        }

        flash("Settings updated successfully")->success();
        return back();
    }
}
