<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShippingDistrict;
use App\Models\ShippingDivision;
use App\Models\ShippingState;
use Illuminate\Http\Request;

class ShippingAreaController extends Controller
{
    public function allDivisions()
    {

        $data = ShippingDivision::latest()->get();
        return view('admin.shipping.division.all_divisions', compact('data'));
    }

    public function addDivision($id = 0)
    {

        if ($id > 0) {
            $data = ShippingDivision::findOrFail($id);
            return view('admin.shipping.division.add_division', compact('data'));

        } else {
            return view('admin.shipping.division.add_division');

        }

    }


    public function saveDivision(Request $request, $id = 0)
    {
        if ($id > 0) {
            ShippingDivision::findOrFail($id)->update([
                'division_name' => $request->division_name
            ]);
        } else {
            ShippingDivision::insert([
                'division_name' => $request->division_name,
                'created_at' => date('Y-m-d')
            ]);
        }
        $notification = array(
            'message' => 'Division Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_divisions')->with($notification);
    }

    public function deleteDivision($id)
    {
        ShippingDivision::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Division Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_divisions')->with($notification);
    }


    public function allDistricts()
    {
        $data = ShippingDistrict::all();

        return view('admin.shipping.district.all_districts', compact('data'));
    }

    public function addDistrict($id = 0)
    {
        if ($id > 0) {
            $data = ShippingDistrict::findOrFail($id);
            $divisions = ShippingDivision::orderBy('division_name', 'ASC')->get();
            return view('admin.shipping.district.add_district', compact('data', 'divisions'));
        } else {
            $divisions = ShippingDivision::orderBy('division_name', 'ASC')->get();
            return view('admin.shipping.district.add_district', compact('divisions'));

        }

    }

    public function saveDistrict(Request $request, $id = 0)
    {
        if ($id > 0) {
            ShippingDistrict::findOrFail($id)->update([
                'district_name' => $request->district_name,
                'division_id' => $request->division
            ]);
        } else {
            ShippingDistrict::insert([
                'district_name' => $request->district_name,
                'division_id' => $request->division,
                'created_at' => date('Y-m-d')
            ]);
        }
        $notification = array(
            'message' => 'District Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_districts')->with($notification);
    }

    public function deleteDistrict($id)
    {
        ShippingDistrict::findOrFail($id)->delete();
        $notification = array(
            'message' => 'District Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_districts')->with($notification);
    }



    public function allStates()
    {
        $data = ShippingState::latest()->get();
        return view('admin.shipping.state.all_states', compact('data'));
    }


    public function addState($id = 0)
    {
        if ($id > 0) {
            $data = ShippingState::findOrFail($id);
            $divisions = ShippingDivision::orderBy('division_name', 'ASC')->get();
            $districts = ShippingDistrict::orderBy('district_name', 'ASC')->get();
            return view('admin.shipping.state.add_state', compact('data', 'divisions', 'districts'));
        } else {
            $divisions = ShippingDivision::orderBy('division_name', 'ASC')->get();
            $districts = ShippingDistrict::orderBy('district_name', 'ASC')->get();
            return view('admin.shipping.state.add_state', compact('divisions', 'districts'));

        }

    }


    public function saveState(Request $request, $id = 0)
    {
        if ($id > 0) {
            ShippingState::findOrFail($id)->update([
                'state_name' => $request->state_name,
                'division_id' => $request->division,
                'district_id' => $request->district

            ]);
        } else {
            ShippingState::insert([
                'state_name' => $request->state_name,
                'division_id' => $request->division,
                'district_id' => $request->district,
                'created_at' => date('Y-m-d')
            ]);
        }
        $notification = array(
            'message' => 'State Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_states')->with($notification);
    }


    public function getDistrictAjax(Request $request)
    {
        $division_id = $request->division_id;

        $districts = ShippingDistrict::where('division_id', $division_id)->get();
        return $districts;
    }

    public function deleteState($id)
    {
        ShippingState::findOrFail($id)->delete();
        $notification = array(
            'message' => 'State Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect('admin/all_states')->with($notification);
    }
}