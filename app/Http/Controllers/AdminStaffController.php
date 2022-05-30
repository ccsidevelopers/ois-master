<?php

namespace App\Http\Controllers;

use App\AcknowledgeForm;
use App\Generals\AuditQueries;
use App\Generals\EmailQueries;
use App\Generals\ScriptTrimmer;
use App\handler;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Generals\Trimmer;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use ZanySoft\Zip\Zip;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;


class
AdminStaffController extends Controller
{
    public function getAdminStaffPanel()
    {
        $webStatus = DB::table('downs')
            ->select(['web_status'])
            ->first();

        if ($webStatus->web_status === 1) {
            Auth::logout();
            return view('errors.down');
        } else {
            if (Auth::user() == null) {
                return redirect()->route('/');
            } else if (Auth::user()->hasRole('Admin Staff')) {
                $javs = DB::table('javascript_magic')
                    ->select('unique')
                    ->where('id', '1')
                    ->get()[0]->unique;

                $pos = DB::table('emp_position')
                    ->select([
                        'id',
                        'position_name'
                    ])
                    ->get();

                $archi = DB::table('archipelagos')
                    ->select([
                        'id',
                        'archipelago_name'
                    ])
                    ->get();

                $get_items = DB::table('item_details_admin_inventory')
                    ->select('item_type', 'type')
                    ->get();

                $data = array(
                    'position' => $pos,
                    'archipelagos' => $archi,
                    'item_selection' => $get_items
                );

                return view('admin_staff.admin-staff-master', compact('javs'))->with($data);
            }
            return redirect()->route('privilege-error');
        }
    }

    //floyd
    public function adminStaffTable()
    {

        $adminlist = DB::table('item_requests')
            ->join
            (
                'request_listitem', 'request_listitem.item_request_id', '=', 'item_requests.id'
            )
            ->select
            ([
                'request_listitem.item_name as name',
                'request_listitem.item_desc as description',
                'request_listitem.item_purp as purpose',
                'request_listitem.item_qty as quantity',
                'item_requests.itmreq_datetime as date',
                'item_requests.itmreq_receiver as receiver',
                'item_requests.itmreq_dept as department',
                'item_requests.itmreq_branch as branch',
                'item_requests.itmreq_requestor as requestor',
                'request_listitem.id as req_id'
            ])
            ->where('request_listitem.item_status', 'Requested');

        return DataTables::of($adminlist)
            ->editColumn('supplier_list', function ($query) {
                $suppliers = DB::table('supplier_list')
                    ->select('supp_name', 'id')
                    ->get();

                $send = '';
                $select = '';
                foreach ($suppliers as $supplier) {

                    $send .= '<option  value = "' . $supplier->id . '">' . $supplier->supp_name . '</option>';

                    $select = '<select class="form-control select2" style="width: 100%; " id = "supplier_class-' . ($query->req_id) . '">' . $send . '</select>';
                }
                return $select;
            })
            ->rawColumns([
                'supplier_list'
            ])
            ->toJson();
    }

    public function adminStaffSubmit(Request $request)
    {

        $insertSubmit = DB::table('item_requests')
            ->join
            (
                'request_listitem',
                'request_listitem.item_request_id',
                '=',
                'item_requests.id'
            )
            ->select
            (
                'item_requests.itmreq_datetime as datetime'
            )
            ->where('request_listitem.id', $request->acctID)
            ->get();

        DB::table('request_listitem')
            ->where('id', $request->acctID)
            ->update([
                'item_status' => 'Submitted'
            ]);

        DB::table('request_status')
            ->insert
            (
                [
                    'request_id' => $request->acctID,
                    'supplier_id' => $request->suppID,
                    'request_status' => 'Submitted',
                    'date_time_request' => $insertSubmit[0]->datetime
                ]
            );

        return response()->json('success');
    }

    public function adminStaffHold(Request $request)
    {

        $insertSubmit = DB::table('item_requests')
            ->join
            (
                'request_listitem',
                'request_listitem.item_request_id',
                '=',
                'item_requests.id'
            )
            ->select
            (
                'item_requests.itmreq_datetime as datetime'
            )
            ->where('request_listitem.id', $request->acctID)
            ->get();


        DB::table('request_listitem')
            ->where('id', $request->acctID)
            ->update([
                'item_status' => 'Hold'
            ]);

        DB::table('request_status')
            ->insert
            (
                [
                    'request_id' => $request->acctID,
                    'supplier_id' => $request->suppID,
                    'request_status' => 'Hold',
                    'date_time_request' => $insertSubmit[0]->datetime
                ]
            );
        return response()->json('success');
    }

    public function adminStaffCancel(Request $request)
    {
        $insertSubmit = DB::table('item_requests')
            ->join
            (
                'request_listitem',
                'request_listitem.item_request_id',
                '=',
                'item_requests.id'
            )
            ->select
            (
                'item_requests.itmreq_datetime as datetime'
            )
            ->where('request_listitem.id', $request->acctID)
            ->get();

        DB::table('request_listitem')
            ->where('id', $request->acctID)
            ->update([
                'item_status' => 'Cancelled'
            ]);
        DB::table('request_status')
            ->insert
            (
                [
                    'request_id' => $request->acctID,
                    'supplier_id' => $request->suppID,
                    'request_status' => 'Cancelled',
                    'date_time_request' => $insertSubmit[0]->datetime
                ]
            );
        return response()->json('success');
    }

    public function adminStaffSubmitStatusTable()
    {

        $submitted = DB::table('request_status')
            ->join
            (
                'request_listitem',
                'request_listitem.id',
                '=',
                'request_status.request_id'
            )
            ->join
            (
                'supplier_list',
                'supplier_list.id',
                '=',
                'request_status.supplier_id'
            )
            ->join
            (
                'item_requests',
                'item_requests.itmreq_datetime',
                '=',
                'request_status.date_time_request'
            )
            ->select
            ([
                'request_listitem.id as req_id',
                'request_listitem.item_name as name',
                'request_listitem.item_desc as description',
                'request_listitem.item_purp as purpose',
                'request_listitem.item_qty as quantity',
                'item_requests.itmreq_datetime as date',
                'item_requests.itmreq_receiver as receiver',
                'item_requests.itmreq_dept as department',
                'item_requests.itmreq_branch as branch',
                'item_requests.itmreq_requestor as requestor',
                'supplier_list.supp_name as supplier'
            ])
            ->where('request_status.request_status', 'Submitted');

        return DataTables::of($submitted)
            ->make(true);
    }


    public function adminStaffHoldStatusTable()
    {

        $submitted = DB::table('request_status')
            ->join
            (
                'request_listitem',
                'request_listitem.id',
                '=',
                'request_status.request_id'
            )
            ->join
            (
                'supplier_list',
                'supplier_list.id',
                '=',
                'request_status.supplier_id'
            )
            ->join
            (
                'item_requests',
                'item_requests.itmreq_datetime',
                '=',
                'request_status.date_time_request'
            )
            ->select
            ([
                'request_listitem.id as req_id',
                'request_listitem.item_name as name',
                'request_listitem.item_desc as description',
                'request_listitem.item_purp as purpose',
                'request_listitem.item_qty as quantity',
                'item_requests.itmreq_datetime as date',
                'item_requests.itmreq_receiver as receiver',
                'item_requests.itmreq_dept as department',
                'item_requests.itmreq_branch as branch',
                'item_requests.itmreq_requestor as requestor',
                'supplier_list.supp_name as supplier'
            ])
            ->where('request_status.request_status', 'Hold');

        return DataTables::of($submitted)
            ->make(true);
    }


    public function adminStaffCancelStatusTable()
    {

        $submitted = DB::table('request_status')
            ->join
            (
                'request_listitem',
                'request_listitem.id',
                '=',
                'request_status.request_id'
            )
            ->join
            (
                'supplier_list',
                'supplier_list.id',
                '=',
                'request_status.supplier_id'
            )
            ->join
            (
                'item_requests',
                'item_requests.itmreq_datetime',
                '=',
                'request_status.date_time_request'
            )
            ->select
            ([
                'request_listitem.id as req_id',
                'request_listitem.item_name as name',
                'request_listitem.item_desc as description',
                'request_listitem.item_purp as purpose',
                'request_listitem.item_qty as quantity',
                'item_requests.itmreq_datetime as date',
                'item_requests.itmreq_receiver as receiver',
                'item_requests.itmreq_dept as department',
                'item_requests.itmreq_branch as branch',
                'item_requests.itmreq_requestor as requestor',
                'supplier_list.supp_name as supplier'
            ])
            ->where('request_status.request_status', 'Cancelled');

        return DataTables::of($submitted)
            ->make(true);
    }

    public function adminStaffSupplierTable()
    {

        $submitted = DB::table('supplier_list')
            ->join('category_list', 'category_list.id', '=', 'supplier_list.category_id')
            ->select
            ([
                'supplier_list.id as id',
                'supplier_list.supp_name as name',
                'supplier_list.supp_contact_phone as contact_phone',
                'supplier_list.supp_contact_mobile as contact_mobile',
                'supplier_list.supp_email as email',
                'supplier_list.supp_address as address',
                'supplier_list.supp_contact_person as contact_person',
                'supplier_list.supplier_since as since',
                'category_list.category_name as category'
            ]);

        return DataTables::of($submitted)
            ->make(true);
    }

    public function adminStaffGetCategory()
    {

        $category = DB::table('category_list')
            ->select('category_name')
            ->get();

        return \response()->json($category);

    }

    public function adminStaffAddSupplierExistingCategory(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();

        $validator = Validator::make($request->all(),
            [
                'suppName' => 'required',
                'suppDate' => 'required',
                'suppAddress' => 'required',
                'suppPerson' => 'required',
                'selectedCategory' => 'required'
            ]);

        $existing = DB::table('supplier_list')
            ->where('supp_name', $request->suppName)
            ->count();


        if ($validator->fails()) {
            return \response()->json(['error' => 'required']);
        } else {

            if ($existing > 0) {
                return \response()->json(['exist' => 'exist']);
            } else {
                if ($request->suppPhone == null) {
                    $nullPhone = "None";
                } else {
                    $nullPhone = $request->suppPhone;
                }
                if ($request->suppMobile == null) {
                    $nullMobile = "None";
                } else {
                    $nullMobile = $request->suppMobile;
                }
                if ($request->suppEmail == null) {
                    $nullEmail = "None";
                } else {
                    $nullEmail = $request->suppEmail;
                }

                $file = $request->file('suppFile');
                if ($file != null) {
                    $name = ($trimmer->trims($request->suppName)) . '-B.I FILE' . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path('/supplier_bi/'), $name);
                    $path = '/supplier_bi/' . $name;
                } else {
                    $path = '';
                }

                $category = DB::table('category_list')
                    ->select('id')
                    ->where('category_name', $request->selectedCategory)
                    ->get();
                DB::table('supplier_list')
                    ->insert
                    ([
                        'supp_name' => $removeScript->scripttrim($trimmer->trims($request->suppName)),
                        'supplier_since' => $request->suppDate,
                        'supp_contact_phone' => $removeScript->scripttrim($nullPhone),
                        'supp_contact_mobile' => $removeScript->scripttrim($nullMobile),
                        'supp_email' => $removeScript->scripttrim($nullEmail),
                        'supp_address' => $removeScript->scripttrim($trimmer->trims($request->suppAddress)),
                        'supp_contact_person' => $removeScript->scripttrim($trimmer->trims($request->suppPerson)),
                        'category_id' => $category[0]->id,
                        'supp_bi' => $path
                    ]);
                return \response()->json(['success' => 'success']);
            }
        }
    }

    public function adminStaffAddSupplierNewCategory(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $validator = Validator::make($request->all(),
            [
                'suppName' => 'required',
                'suppDate' => 'required',
                'suppAddress' => 'required',
                'suppPerson' => 'required',
                'newInput' => 'required'
            ]);
        $existing = DB::table('supplier_list')
            ->where('supp_name', $request->suppName)
            ->count();

        $existingCategory = DB::table('category_list')
            ->where('category_name', $request->newInput)
            ->count();

        if ($validator->fails()) {
            return \response()->json(['error' => 'required']);
        } else {
            if ($existing > 0) {
                return \response()->json(['exist' => 'exist']);
            } else if ($existingCategory > 0) {
                return \response()->json(['existCategory' => 'existCategory']);
            } else {
                if ($request->suppPhone == null) {
                    $nullPhone = "None";
                } else {
                    $nullPhone = ($trimmer->trims($request->suppPhone));
                }
                if ($request->suppMobile == null) {
                    $nullMobile = "None";
                } else {
                    $nullMobile = ($trimmer->trims($request->suppMobile));
                }
                if ($request->suppEmail == null) {
                    $nullEmail = "None";
                } else {
                    $nullEmail = ($trimmer->trims($request->suppEmail));;
                }
                $file = $request->file('suppFile');

                if ($file != null) {
                    $name = ($trimmer->trims($request->suppName)) . '-B.I FILE' . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path('/supplier_bi/'), $name);
                    $path = '/supplier_bi/' . $name;
                } else {
                    $path = '';
                }

                DB::table('category_list')
                    ->insert
                    ([
                        'category_name' => ($trimmer->trims($request->newInput))
                    ]);
                $category = DB::table('category_list')
                    ->select('id')
                    ->where('category_name', $request->newInput)
                    ->get();


                DB::table('supplier_list')
                    ->insert
                    ([
                        'supp_name' => $removeScript->scripttrim($trimmer->trims($request->suppName)),
                        'supplier_since' => $request->suppDate,
                        'supp_contact_phone' => $removeScript->scripttrim($nullPhone),
                        'supp_contact_mobile' => $removeScript->scripttrim($nullMobile),
                        'supp_email' => $removeScript->scripttrim($nullEmail),
                        'supp_address' => $removeScript->scripttrim($trimmer->trims($request->suppAddress)),
                        'supp_contact_person' => $removeScript->scripttrim($trimmer->trims($request->suppPerson)),
                        'category_id' => $category[0]->id
                    ]);
                return \response()->json(['success' => 'success']);
            }
        }
    }

    public function adminStaffCheckCategory(Request $request)
    {
        $getid = $request->checkcategory;

        $getcount = DB::table('category_list')
            ->select('category_name')
            ->where('category_name', $getid)
            ->count();
        return response()->json($getcount);
    }

    public function AddItemProfile(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $validator = Validator::make($request->all(),
            [
                'itemModel' => 'required',
                'itemAmount' => 'required',
            ]);
        if ($validator->fails()) {
            return \response()->json(['error' => 'required']);
        } else {

            $getItem = DB::table('item_profile')
                ->insertGetId
                ([
                    'item_category' => $removeScript->scripttrim($request->itemType),
                    'item_brand_model' => $removeScript->scripttrim($request->itemModel),
                    'item_date_purchased' => $request->itemDate,
                    'item_amount' => $removeScript->scripttrim($request->itemAmount),
                    'item_color' => $removeScript->scripttrim($request->itemColor),
                    'item_remarks' => $removeScript->scripttrim($request->itemRemarks),
                    'item_status' => 'available',
                    'item_specs_status' => $removeScript->scripttrim($request->itemSpec),
                    'warranty_label' => $removeScript->scripttrim($request->itemWarranty),
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            $logs = new AuditQueries();

            $logs->Item_log('ITEM CREATED', $getItem, 0, Auth::user()->id, '');

            $logs->assign_items('ADDED A ' . $trimmer->trims($request->itemColor) . ' ' . $trimmer->trims($request->itemType) . ' WITH BRAND/MODEL ' . $trimmer->trims($request->itemModel), '', '', Auth::user()->id, $request->itemRemarks);

            $file = $request->file('itemImage');
            if ($file != null) {
                $name = $getItem . '-' . $request->itemPO . '.' . $file->getClientOriginalExtension();
                Image::make(file_get_contents($file) . ($file->getClientOriginalName()))->resize(215, 215)->save(public_path('item_pic/' . $name));
                $linkName = 'item_pic/' . $name;
                $logs->assign_items('UPLOADED PROFILE PHOTO TO ITEM ID:' . $getItem, '', '', Auth::user()->id, '');
            } else {
                $linkName = '';
            }
            $file3 = $request->file('itemQuotation');
            if ($file3 != null) {
                $name3 = $getItem . '-' . $request->itemModel . '-Quotation' . '.' . $file3->getClientOriginalExtension();
                $file3->move(storage_path('/item_purchase/' . $getItem . '/Quotation/'), $name3);
                $pathQuot = '/item_purchase/' . $getItem . '/Quotation/' . $name3;
                $logs->assign_items('UPLOADED QUOTATION DOCUMENT TO ITEM ID:' . $getItem, '', '', Auth::user()->id, '');
            } else {
                $pathQuot = '';
            }

            DB::table('item_profile')
                ->where('id', $getItem)
                ->update
                ([
                    'item_photo_path' => $linkName,
                    'quotation_path' => $pathQuot
                ]);

            $file4 = $request->file('itemFile');
            $getcount = DB::table('purchase_order')
                ->select('po_number')
                ->where('po_number', $request->itemPO)
                ->count();

            if ($getcount > 0) {
                $getPath = DB::table('purchase_order')
                    ->select('po_file_path')
                    ->where('po_number', $request->itemPO)
                    ->get();

                if ($getPath[0]->po_file_path != '') {
                    if ($file4 != null) {
                        $image_path = $getPath[0]->po_file_path;
                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }
                        $name4 = $getItem . '-' . $request->itemPO . '.' . $file4->getClientOriginalExtension();
                        $file4->move(storage_path('/item_purchase/' . $getItem . '/P.O/'), $name4);
                        $path = '/item_purchase/' . $getItem . '/P.O/' . $name4;
                        $logs->assign_items('REPLACED P.O DOCUMENT FROM P.O NUMBER ' . $request->itemPO . ' FROM ITEM ID:' . $getItem, '', '', Auth::user()->id, '');
                    } else {
                        $path = '';
                    }
                } else {
                    if ($file4 != null) {
                        $name4 = $getItem . '-' . $request->itemPO . '.' . $file4->getClientOriginalExtension();
                        $file4->move(storage_path('/item_purchase/' . $getItem . '/P.O/'), $name4);
                        $path = '/item_purchase/' . $getItem . '/P.O/' . $name4;
                        $logs->assign_items('ADDED P.O DOCUMENT TO P.O NUMBER' . $request->itemPO . ' FROM ITEM ID:' . $getItem, '', '', Auth::user()->id, '');
                    } else {
                        $path = '';
                    }
                }

                DB::table('purchase_order')
                    ->where('po_number', $request->itemPO)
                    ->update
                    ([
                        'po_number' => $removeScript->scripttrim($request->itemPO),
                        'po_file_path' => $path,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
                $getsamePo = DB::table('purchase_order')
                    ->select('id')
                    ->where('po_number', $request->itemPO)
                    ->get();
                DB::table('po_pivot')
                    ->insert
                    ([
                        'item_id' => $getItem,
                        'po_id' => $getsamePo[0]->id,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                return \response()->json(['success' => 'success']);
            } else {
                if ($file4 != null) {
                    $name4 = $getItem . '-' . $request->itemPO . '.' . $file4->getClientOriginalExtension();
                    $file4->move(storage_path('/item_purchase/' . $getItem . '/P.O/'), $name4);
                    $path = '/item_purchase/' . $getItem . '/P.O/' . $name4;
                    $logs->assign_items('ADDED P.O DOCUMENT TO P.O NUMBER' . $request->itemPO . ' FROM ITEM ID:' . $getItem, '', '', Auth::user()->id, '');
                } else {
                    $path = '';
                }
                $getPo = DB::table('purchase_order')
                    ->insertGetID
                    ([
                        'po_number' => $removeScript->scripttrim($request->itemPO),
                        'po_file_path' => $path,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('po_pivot')
                    ->insert
                    ([
                        'item_id' => $getItem,
                        'po_id' => $getPo,
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
                return \response()->json(['success' => 'success']);
            }
        }

    }

    public function showItemProfile()
    {
        $getData = DB::table('item_profile')
            ->leftjoin('item_to_ar', 'item_to_ar.item_id', '=', 'item_profile.id')
            ->leftjoin('ar_to_employee', 'ar_to_employee.id', '=', 'item_to_ar.ar_to_employee_id')
            ->leftjoin('users_profile', 'users_profile.id', '=', 'ar_to_employee.emp_id')
            ->leftjoin('po_pivot', 'po_pivot.item_id', '=', 'item_profile.id')
            ->leftjoin('purchase_order', 'purchase_order.id', '=', 'po_pivot.po_id')
            ->select
            ([
                'item_profile.id as id',
                'item_profile.item_category as category',
                'item_profile.item_date_purchased as purchased',
                'item_profile.item_brand_model as model',
                'item_profile.item_remarks as remarks',
                'item_profile.item_color as color',
                'item_profile.item_amount as amount',
                'item_profile.item_specs_status as specs_stat',
                'users_profile.emp_full_name as name',
                'purchase_order.po_number as po'
            ]);

        return DataTables::of($getData)
            ->make(true);
    }

    public function fetchItemDetails(Request $request)
    {
        $getData = DB::table('item_profile')
            ->leftjoin('po_pivot', 'po_pivot.item_id', '=', 'item_profile.id')
            ->leftjoin('purchase_order', 'purchase_order.id', '=', 'po_pivot.po_id')
            ->leftjoin('item_to_ar', 'item_to_ar.item_id', '=', 'item_profile.id')
            ->leftjoin('ar_to_employee', 'ar_to_employee.id', '=', 'item_to_ar.ar_to_employee_id')
            ->leftjoin('users_profile', 'users_profile.id', '=', 'ar_to_employee.emp_id')
            ->select
            ([
                'item_profile.item_category as category',
                'item_profile.item_brand_model as model',
                'item_profile.item_date_purchased as date',
                'item_profile.item_amount as amount',
                'item_profile.item_color as color',
                'item_profile.item_remarks as remarks',
                'item_profile.item_photo_path as picture',
                'users_profile.emp_full_name as full_name',
                'purchase_order.po_number as po',
                'purchase_order.po_file_path as path',
                'item_profile.warranty_label as warranty',
                'item_profile.quotation_path as quotation'
            ])
            ->where('item_profile.id', '=', $request->showItemId)
            ->get();

        return \response()->json([$getData]);

    }

    public function showAvailable()
    {
        $getData = DB::table('item_profile')
            ->select('id', 'item_category', 'item_brand_model')
            ->where('item_status', 'available')
            ->get();
        return DataTables::of($getData)
            ->make(true);
    }

    public function fetchItemsEmp(Request $request)
    {
        $getData = DB::table('item_profile')
            ->join('item_to_ar', 'item_to_ar.item_id', '=', 'item_profile.id')
            ->select('item_profile.id', 'item_profile.item_category', 'item_profile.item_brand_model', 'item_profile.item_color', 'item_profile.item_remarks')
            ->where('item_to_ar.ar_to_employee_id', $request->ar_id)
            ->where('item_profile.item_status', 'assigned')
            ->get();
        return \response()->json($getData);
    }

    public function assigntoEmp(Request $request)
    {
        $trimmer = new Trimmer();
        DB::table('item_profile')
            ->where('id', $request->empIdAssign)
            ->update
            ([
//                'user_id' => $request->viewExpID,
                'item_status' => 'assigned'
            ]);

        DB::table('item_to_ar')
            ->insert([
                'ar_to_employee_id' => $request->ar_employee_id,
                'item_id' => $request->viewExpID
            ]);

        $getName = DB::table('users_profile')
            ->join('ar_to_employee', 'ar_to_employee.emp_id', '=', 'users_profile.id')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.emp_full_name as emp_full_name',
                'users_profile.id as id',
                'branch_list.branch_name as branch'
            ])
            ->where('ar_to_employee.id', $request->ar_employee_id)
            ->get();

        $getAr = DB::table('ar_info')
            ->join('ar_to_employee', 'ar_to_employee.ar_id', '=', 'ar_info.id')
            ->select
            ([
                'ar_info.ar_description as description'
            ])
            ->where('ar_to_employee.id', $request->ar_employee_id)
            ->get();

        $getItemInfo = DB::table('item_profile')
            ->select('item_category', 'item_brand_model')
            ->where('id', $request->empIdAssign)
            ->get();

        $logs = new AuditQueries();

        $logs->Item_log('ITEM ASSIGNED TO ' . $getName[0]->emp_full_name, $request->empIdAssign, $request->viewExpID, Auth::user()->id, $request->remarks);

        $logs->assign_items($trimmer->trims($getItemInfo[0]->item_category) . ' WITH BRAND/MODEL ' . $trimmer->trims($getItemInfo[0]->item_brand_model) . ' ASSIGNED TO ' . $trimmer->trims($getName[0]->emp_full_name) . '(' . $trimmer->trims($getName[0]->branch) . ' branch) WITH A.R DESCRIPTION ' . $trimmer->trims($getAr[0]->description), $getAr[0]->description, $getName[0]->id, Auth::user()->id, $trimmer->trims($request->remarks));
    }

    public function removeAssign(Request $request)
    {
        $getItemInfo = DB::table('item_profile')
            ->select('item_category', 'item_brand_model', 'item_specs_status', 'id')
            ->where('id', $request->remAss)
            ->get();

        return response()->json([$getItemInfo[0]->item_specs_status, $getItemInfo[0]->item_brand_model, $getItemInfo[0]->id]);
    }

    public function admin_staff_ar_upload(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $file = $request->file('ar_file');
        $emp_id = $request->emp_id;
        $desc = $request->desc;
        $remarks = $request->remarks;
        $date_time = Carbon::now('Asia/Manila');

        if ($file != null) {
            if ($file->getClientOriginalExtension() != 'pdf') {
                return 'not pdf';
            } else {
                $date_time_explode = explode(' ', $date_time);
                $date = explode('-', $date_time_explode[0]);
                $date_capso = $date[0] . $date[1] . $date[2];
                $time = explode(':', $date_time_explode[1]);
                $time_capso = $time[0] . $time[1] . $time[2];

                $name = explode('.', $file->getClientOriginalName())[0];

                $file_name = $name . '-' . $date_capso . $time_capso . '.' . $file->getClientOriginalExtension();

                $file->move(storage_path('ar_files/' . $emp_id . '/'), $file_name);
                $path = 'ar_files/' . $emp_id . '/' . $file_name;

                $ar_id = DB::table('ar_info')
                    ->insertGetId([
                        'ar_description' => $removeScript->scripttrim($desc),
                        'ar_remarks' => $removeScript->scripttrim($remarks),
                        'file_path' => $path,
                        'created_at' => $date_time
                    ]);

                DB::table('ar_to_employee')
                    ->insert([
                        'emp_id' => $emp_id,
                        'ar_id' => $ar_id,
                        'created_at' => $date_time
                    ]);

                $getBranch = DB::table('users_profile')
                    ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
                    ->select
                    ([
                        'users_profile.emp_full_name as name',
                        'branch_list.branch_name as branch'
                    ])
                    ->where('users_profile.id', $emp_id)
                    ->get();
                //LOGS HERE

                $logs = new AuditQueries();

                $logs->assign_items('Created Acknowledgement Receipt with Description ' . $trimmer->trims($desc) . ' assigned to ' . $trimmer->trims($getBranch[0]->name) . '(' . $getBranch[0]->branch . ' branch)', $desc, $emp_id, Auth::user()->id, $trimmer->trims($remarks));

                return 'success';
            }
        } else {
            return 'select file';
        }
    }

    public function admin_staff_ar_table(Request $request)
    {
        $ar_table = DB::table('ar_to_employee')
            ->join('users_profile', 'users_profile.id', '=', 'ar_to_employee.emp_id')
            ->join('ar_info', 'ar_info.id', '=', 'ar_to_employee.ar_id')
            ->select([
                'ar_to_employee.id as id',
                'ar_to_employee.emp_id as emp_id',
                'users_profile.emp_first_name as first_name',
                'users_profile.emp_middle_name as middle_name',
                'users_profile.emp_last_name as last_name',
                'ar_info.ar_description as description',
                'ar_info.ar_remarks as remarks',
                'ar_info.file_path as path',
                'ar_to_employee.created_at as time_created'
            ]);

        return DataTables::of($ar_table)
            ->toJson();

    }

    public function admin_get_ar_description(Request $request)
    {
        $get_desc = DB::table('ar_info')
            ->join('ar_to_employee', 'ar_to_employee.ar_id', '=', 'ar_info.id')
            ->select([
                'ar_to_employee.id as id',
                'ar_info.ar_description as ar_description',
                'ar_info.ar_remarks as ar_remarks',
                'ar_info.file_path as file_path',
                'ar_info.created_at as created_at',
            ])
            ->where('ar_to_employee.emp_id', $request->emp_id)
            ->get();

        return response()->json($get_desc);
    }

    public function itemHistory(Request $request)
    {
        $getLogs = DB::table('item_logs')
            ->leftjoin('users', 'users.id', '=', 'item_logs.user_id')
            ->select
            ([
                'item_logs.id as id',
                'users.name as name',
                'item_logs.activities as activities',
                'item_logs.activity_remarks as activity_remarks',
                'item_logs.created_at as date'
            ])
            ->where('item_logs.item_id', $request->emp_id)
            ->orderBy('id', 'desc');

        return DataTables::of($getLogs)
            ->toJson();
    }

    public function ArLogs()
    {
        $getData = DB::table('assign_logs')
            ->leftjoin('users', 'users.id', '=', 'assign_logs.user_id')
            ->leftjoin('users_profile', 'users_profile.id', '=', 'assign_logs.emp_id')
            ->select
            ([
                'users.name as username',
                'users_profile.emp_full_name as name',
                'assign_logs.activities as activities',
                'assign_logs.remarks as remarks',
                'assign_logs.created_at as time'
            ])
            ->orderBy('assign_logs.id', 'desc');

        return DataTables::of($getData)
            ->make(true);
    }

    public function PoDownload(Request $request)
    {

        $id = base64_decode($request->id);
        $getPath = DB::table('item_profile')
            ->join('po_pivot', 'po_pivot.item_id', '=', 'item_profile.id')
            ->join('purchase_order', 'purchase_order.id', '=', 'po_pivot.po_id')
            ->select
            ([
                'purchase_order.po_file_path as path'
            ])
            ->where('po_pivot.item_id', $id)
            ->get();

        if (Auth::user()->hasRole('Admin Staff')) {
            return response()->download(storage_path($getPath[0]->path));
        } else {
            return response('');
        }
    }

    public function updateItem(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $getData = DB::table('item_profile')
            ->join('po_pivot', 'po_pivot.item_id', '=', 'item_profile.id')
            ->join('purchase_order', 'purchase_order.id', '=', 'po_pivot.po_id')
            ->select
            ([
                'item_profile.item_category as category',
                'item_profile.item_brand_model as model',
                'item_profile.item_date_purchased as date',
                'item_profile.item_amount as amount',
                'item_profile.item_color as color',
                'item_profile.item_remarks as remarks',
                'item_profile.warranty_label as warranty',
                'purchase_order.po_number as po',
                'purchase_order.po_file_path as po_path'
            ])
            ->where('item_profile.id', $request->itemIdEdit)
            ->get();

        $array1 = array('ITEM CATEGORY' => $getData[0]->category, 'ITEM BRAND AND MODEL' => $getData[0]->model, 'ITEM PURCHASE DATE' => $getData[0]->date,
            'ITEM AMOUNT' => $getData[0]->amount, 'ITEM COLOR' => $getData[0]->color, 'ITEM REMARKS' => $getData[0]->remarks, 'P.O number' => $getData[0]->po,
            'WARRANTY_LABEL' => $getData[0]->warranty);
        $array2 = array('ITEM CATEGORY' => $request->itemType, 'ITEM BRAND AND MODEL' => $request->itemModel, 'ITEM PURCHASE DATE' => $request->itemDate,
            'ITEM AMOUNT' => $request->itemAmount, 'ITEM COLOR' => $request->itemColor, 'ITEM REMARKS' => $request->itemRemarks, 'P.O number' => $request->itemPO,
            'WARRANTY_LABEL' => $request->itemWarranty);

        $emplogs = '';
        for ($i = 0; $i < count($array1); $i++) {
            $allKeys1 = array_keys($array1);
            $allKeys2 = array_keys($array2);
            if ($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]]) {
                $emplogs .= $allKeys1[$i] . '(FROM ' . $array1[$allKeys1[$i]] . ' TO ' . $array2[$allKeys2[$i]] . '), ';
            }
        }
        $logs = new AuditQueries();
        if ($emplogs != null) {
            $logs->assign_items('UPDATED ' . $trimmer->trims($emplogs) . ' FROM ITEM ID :  ' . $request->itemIdEdit, '', '', Auth::user()->id, '');
        }

        $existing = DB::table('purchase_order')
            ->where('po_number', $request->itemPO)
            ->count();

        $getpic = DB::table('item_profile')
            ->select('item_photo_path', 'quotation_path', 'item_brand_model')
            ->where('id', $request->itemIdEdit)
            ->get();

        $file2 = $request->file('itemImage');
        $linkName = '';
        if (count($getpic) > 0) {
            if ($file2 != null) {
                $image_path = $getpic[0]->item_photo_path;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $name = $request->itemIdEdit . '-' . $request->itemPO . '.' . $file2->getClientOriginalExtension();
                Image::make(file_get_contents($file2) . ($file2->getClientOriginalName()))->resize(215, 215)->save(public_path('item_pic/' . $name));
                $linkName = 'item_pic/' . $name;

                $logs->assign_items('UPDATED ITEM PROFILE PICTURE FROM ITEM ID :  ' . $request->itemIdEdit, '', '', Auth::user()->id, '');
            } else {
                $linkName = '';
            }
        } else {
            if ($file2 != null) {
                $name = $request->itemIdEdit . '-' . $request->itemPO . '.' . $file2->getClientOriginalExtension();
                Image::make(file_get_contents($file2) . ($file2->getClientOriginalName()))->resize(215, 215)->save(public_path('item_pic/' . $name));
                $linkName = 'item_pic/' . $name;
                $logs->assign_items('ADDED ITEM PROFILE PICTURE TO ITEM ID :  ' . $request->itemIdEdit, '', '', Auth::user()->id, '');
            } else {
                $linkName = '';
            }
        }
        $file4 = $request->file('itemQuotation');
        if ($file4 != null) {
            $image_path = $getpic[0]->quotation_path;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $name4 = $request->itemIdEdit . '-' . $getpic[0]->item_brand_model . '-Quotation' . '.' . $file4->getClientOriginalExtension();
            $file4->move(storage_path('/item_purchase/' . $request->itemIdEdit . '/Quotation/'), $name4);
            $pathQuo = '/item_purchase/' . $request->itemIdEdit . '/Quotation/' . $name4;

            $logs->assign_items('UPDATED QUOTATION FILE OF ITEM ID :  ' . $request->itemIdEdit, '', '', Auth::user()->id, '');
        } else {
            $pathQuo = $getpic[0]->quotation_path;
        }

        DB::table('item_profile')
            ->where('id', $request->itemIdEdit)
            ->update
            ([
                'item_category' => $removeScript->scripttrim($request->itemType),
                'item_brand_model' => $removeScript->scripttrim($request->itemModel),
                'item_date_purchased' => $removeScript->scripttrim($request->itemDate),
                'item_amount' => $removeScript->scripttrim($request->itemAmount),
                'item_color' => $removeScript->scripttrim($request->itemColor),
                'item_remarks' => $removeScript->scripttrim($request->itemRemarks),
                'item_photo_path' => $linkName,
                'warranty_label' => $removeScript->scripttrim($request->itemWarranty),
                'quotation_path' => $pathQuo,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);
        $file = $request->file('itemFile');

        if ($existing > 0) {
            $getId = DB::table('purchase_order')
                ->select('id', 'po_file_path')
                ->where('po_number', $request->itemPO)
                ->get();
            $path = '';
            if ($getId[0]->po_file_path == "") {
                if ($file != null) {
                    $name = $request->itemIdEdit . '-' . $request->itemPO . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path('/item_purchase/'), $name);
                    $path = '/item_purchase/' . $name;

                    $logs->assign_items('ADDED P.O FILE TO PURCHASE NUMBER: ' . $request->itemPO . ' FROM ITEM ID : ' . $request->itemIdEdit, '', '', Auth::user()->id, '');
                } else {
                    $path = '';
                }
            } else if ($getId[0]->po_file_path != "") {
                if ($file != null) {
                    $file_path = $getData[0]->po_path;
                    if (File::exists($file_path)) {
                        File::delete($file_path);
                    }
                    $name = $request->itemIdEdit . '-' . $request->itemPO . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path('/item_purchase/'), $name);
                    $path = '/item_purchase/' . $name;
                    $logs->assign_items('UPDATED P.O FILE FROM PURCHASE NUMBER: ' . $request->itemPO . ' FROM ITEM ID : ' . $request->itemIdEdit, '', '', Auth::user()->id, '');
                } else {
                    $path = '';
                }

            }
            DB::table('purchase_order')
                ->where('po_number', $request->itemPO)
                ->update
                ([
                    'po_file_path' => $path
                ]);
            DB::table('po_pivot')
                ->where('item_id', $request->itemIdEdit)
                ->update
                ([
                    'po_id' => $getId[0]->id
                ]);
            return \response()->json(['success' => 'success']);
        } else {
            if ($file != null) {
                $name = $request->itemIdEdit . '-' . $request->itemPO . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('/item_purchase/'), $name);
                $path = '/item_purchase/' . $name;

                $logs->assign_items('ADDED P.O FILE TO NEW PURCHASE NUMBER:' . $request->itemPO . ' FROM ITEM ID : ' . $request->itemIdEdit, '', '', Auth::user()->id, '');
            } else {
                $path = '';
            }

            $getSomePo = DB::table('purchase_order')
                ->insertGetId
                ([
                    'po_number' => $removeScript->scripttrim($request->itemPO),
                    'po_file_path' => $path
                ]);

            DB::table('po_pivot')
                ->where('item_id', $request->itemIdEdit)
                ->update([
                    'po_id' => $getSomePo
                ]);
            return \response()->json(['success' => 'success']);
        }
    }

    public function arAssigned(Request $request)
    {
        $getSome = DB::table('ar_info')
            ->join('ar_to_employee', 'ar_to_employee.ar_id', '=', 'ar_info.id')
            ->join('users_profile', 'users_profile.id', '=', 'ar_to_employee.emp_id')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.emp_full_name as fullname',
                'users_profile.emp_position as position',
                'users_profile.emp_profile_pic as emp_pic',
                'branch_list.branch_name as branch',
                'ar_info.ar_description as desc',
                'ar_info.id as ar_id',
            ])
            ->where('ar_info.id', $request->ar_info_id)
            ->get();

        return response()->json($getSome);
    }

    public function arTableItem(Request $request)
    {
        $getData = DB::table('ar_info')
            ->join('ar_to_employee', 'ar_to_employee.ar_id', '=', 'ar_info.id')
            ->join('item_to_ar', 'item_to_ar.ar_to_employee_id', '=', 'ar_to_employee.id')
            ->join('item_profile', 'item_profile.id', '=', 'item_to_ar.item_id')
            ->select
            ([
                'item_profile.id as id',
                'item_profile.item_category as category',
                'item_profile.item_brand_model as model',
                'item_profile.item_amount as amount',
                'item_profile.item_color as color',
                'item_profile.item_remarks as remarks'
            ])
            ->where('ar_info.id', $request->emp_id);
        return DataTables::of($getData)
            ->make(true);
    }

    public function fundRequest(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $validator = Validator::make($request->all(),
            [
                'fundAmount' => 'required',
                'fundParticular' => 'required',
                'fundAccount' => 'required',
                'fundRequestor' => 'required',
            ]);
        if ($validator->fails()) {
            return \response()->json(['error' => 'required']);
        } else {
            DB::table('admin_fund_request')
                ->insert
                ([
                    'request_month' => $request->fundMonth,
                    'request_branch' => $removeScript->scripttrim($request->fundBranch),
                    'request_amount' => $request->fundAmount,
                    'request_particular' => $removeScript->scripttrim($request->fundParticular),
                    'request_account' => $removeScript->scripttrim($request->fundAccount),
                    'statement_date' => $request->fundStatement,
                    'due_date' => $request->fundDue,
                    'date_requested' => $request->fundRequestDate,
                    'requested_processed' => $removeScript->scripttrim($request->fundRequestor),
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            $logs = new AuditQueries();

            $logs->assign_items('ADDED A FUND REQUEST FOR ' . $trimmer->trims($request->fundParticular) . ' WITH AN AMOUNT OF ' . $request->fundAmount .
                ', REQUESTED AND PROCESSED BY: ' . $trimmer->trims($request->fundRequestor) . ' FROM ' . $trimmer->trims($request->fundBranch) . ' BRANCH', '', '', Auth::user()->id, '');
            return \response()->json(['success' => 'success']);
        }
    }

    public function fundTable()
    {
        $getData = DB::table('admin_fund_request')
            ->select('id', 'request_month', 'request_branch', 'request_amount', 'request_particular', 'request_account', 'statement_date', 'due_date', 'date_requested', 'requested_processed');

        return DataTables::of($getData)
            ->make(true);
    }

    public function fundGet(Request $request)
    {
        $getSome = DB::table('admin_fund_request')
            ->select('request_month', 'request_branch', 'request_amount', 'request_particular', 'request_account', 'statement_date', 'due_date', 'date_requested', 'requested_processed')
            ->where('id', $request->id)
            ->get();

        return response()->json($getSome);
    }

    public function fundUpdate(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $id = $request->fundUpdateId;

        $validator = Validator::make($request->all(),
            [
                'newFundAmount' => 'required',
                'newFundParticular' => 'required',
                'newFundAccount' => 'required',
                'newFundRequestor' => 'required',
            ]);
        if ($validator->fails()) {
            return \response()->json(['error' => 'required']);
        } else {
            $getFund = DB::table('admin_fund_request')
                ->select('request_month', 'request_branch', 'request_amount', 'request_particular', 'request_account', 'statement_date', 'due_date', 'date_requested', 'requested_processed')
                ->where('id', $id)
                ->get();

            $array1 = array('REQUESTED MONTH' => $getFund[0]->request_month, 'BRANCH REQUEST' => $getFund[0]->request_branch, 'REQUESTED AMOUNT' => $getFund[0]->request_amount,
                'REQUEST PURPOSE' => $getFund[0]->request_particular, 'ACCOUNT NUMBER OF REQUEST' => $getFund[0]->request_account, 'STATEMENT DATE' => $getFund[0]->statement_date,
                'DUE DATE' => $getFund[0]->due_date, 'REQUESTED DATE' => $getFund[0]->date_requested, 'REQUESTOR' => $getFund[0]->requested_processed);

            $array2 = array('REQUESTED MONTH' => $request->newFundMonth, 'REQUEST FROM BRANCH' => $request->newFundBranch, 'REQUESTED AMOUNT' => $request->newFundAmount,
                'REQUEST PURPOSE' => $request->newFundParticular, 'ACCOUNT NUMBER OF REQUEST' => $request->newFundAccount, 'STATEMENT DATE' => $request->newFundStatement,
                'DUE DATE' => $request->newDueDate, 'REQUESTED DATE' => $request->newDateRequested, 'REQUESTOR' => $request->newFundRequestor);


            if ($array1 != $array2) {
                $emplogs = '';
                for ($i = 0; $i < count($array1); $i++) {
                    $allKeys1 = array_keys($array1);
                    $allKeys2 = array_keys($array2);
                    if ($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]]) {
                        $emplogs .= $allKeys1[$i] . '(FROM ' . $array1[$allKeys1[$i]] . ' TO ' . $array2[$allKeys2[$i]] . '), ';
                    }
                }
                if ($emplogs != null) {
                    $logs = new AuditQueries();
                    $logs->assign_items('UPDATED ' . $trimmer->trims($emplogs) . ' FROM THE FUND REQUEST ID :  ' . $id, '', '', Auth::user()->id, '');
                }
                DB::table('admin_fund_request')
                    ->where('id', $id)
                    ->update
                    ([
                        'request_month' => $request->newFundMonth,
                        'request_branch' => $removeScript->scripttrim($request->newFundBranch),
                        'request_amount' => $request->newFundAmount,
                        'request_particular' => $removeScript->scripttrim($request->newFundParticular),
                        'request_account' => $removeScript->scripttrim($request->newFundAccount),
                        'statement_date' => $request->newFundStatement,
                        'due_date' => $request->newDueDate,
                        'date_requested' => $request->newDateRequested,
                        'requested_processed' => $removeScript->scripttrim($request->newFundRequestor),
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }
    }

    public function fundRemove(Request $request)
    {
        $trimmer = new Trimmer();

        $getData = DB::table('admin_fund_request')
            ->select('requested_processed', 'request_amount', 'request_branch')
            ->where('id', $request->fundUpdateId)
            ->get();

        $logs = new AuditQueries();
        $logs->assign_items('DELETED A FUND REQUEST, REQUESTED BY: ' . $trimmer->trims($getData[0]->requested_processed) . ' FROM ' . $trimmer->trims($getData[0]->request_branch) . ' BRANCH WITH THE AMOUNT OF ' . $getData[0]->request_amount, '', '', Auth::user()->id, '');

        DB::table('admin_fund_request')
            ->where('id', $request->fundUpdateId)
            ->delete();

    }

    public function outgoingEmpItems()
    {
        $getData = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch',
                'users_profile.emp_position as position'
            ])
            ->where('users_profile.emp_status', 'Off-Boarding');
        return DataTables::of($getData)
            ->editColumn('ar_list', function ($query) {
                $getArLists = DB::table('users_profile')
                    ->join('ar_to_employee', 'ar_to_employee.emp_id', '=', 'users_profile.id')
                    ->join('ar_info', 'ar_info.id', '=', 'ar_to_employee.ar_id')
                    ->select
                    ([
                        'ar_info.id as id',
                        'ar_info.ar_description as desc',
                        'ar_info.ar_remarks as remarks'
                    ])
                    ->where('users_profile.id', ($query->id))
                    ->get();

                $arShow = '';
                foreach ($getArLists as $getArlist) {
                    $arShow .= 'A.R id :' . $getArlist->id . ', ' . $getArlist->desc . '(' . $getArlist->remarks . ')<br> ';
                }
                return $arShow;
            })
            ->editColumn('item_list', function ($query) {
                $getItemLists = DB::table('users_profile')
                    ->join('ar_to_employee', 'ar_to_employee.emp_id', '=', 'users_profile.id')
                    ->join('item_to_ar', 'item_to_ar.ar_to_employee_id', '=', 'ar_to_employee.id')
                    ->join('ar_info', 'ar_info.id', '=', 'ar_to_employee.ar_id')
                    ->join('item_profile', 'item_profile.id', '=', 'item_to_ar.item_id')
                    ->select
                    ([
                        'item_profile.id as id',
                        'item_profile.item_color as color',
                        'item_profile.item_category as category',
                        'item_profile.item_brand_model as model',
                        'item_profile.item_remarks as remarks',
                        'ar_info.id as ar_id'
                    ])
                    ->where('users_profile.id', ($query->id))
                    ->get();
                $itemShow = '';

                foreach ($getItemLists as $getItemList) {
                    $itemShow .= 'Item id: ' . $getItemList->id . ', ' . $getItemList->color . ' ' . $getItemList->category .
                        ' ' . $getItemList->model . ' ' . $getItemList->remarks . '(' . 'AR id : ' . $getItemList->ar_id . ')<br>';
                }
                return $itemShow;
            })
            ->rawColumns
            ([
                'ar_list',
                'item_list'
            ])
            ->toJson();
    }

    public function getAuth()
    {
        $getAuth = DB::table('users')
            ->select('authrequest')
            ->where('id', Auth::user()->id)
            ->get();

        return response()->json($getAuth);
    }

    public function updateSpecStat(Request $request)
    {
        $removeScript = new ScriptTrimmer();
        $trimmer = new Trimmer();
        $getData = DB::table('item_profile')
            ->select('item_specs_status', 'item_brand_model')
            ->where('id', $request->remAss)
            ->get();
        $logs = new AuditQueries();

        $array1 = array('ITEM STATUS' => $getData[0]->item_specs_status);
        $array2 = array('ITEM STATUS' => $request->showSpecStat);

        $emplogs = '';
        for ($i = 0; $i < count($array1); $i++) {
            $allKeys1 = array_keys($array1);
            $allKeys2 = array_keys($array2);
            if ($array1[$allKeys1[$i]] != $array2[$allKeys2[$i]]) {
                $emplogs .= $allKeys1[$i] . '(FROM ' . $array1[$allKeys1[$i]] . ' TO ' . $array2[$allKeys2[$i]] . '), ';
            }
        }
        if ($emplogs != null) {
            $logs->assign_items('UPDATED ' . $trimmer->trims($emplogs) . ' FROM ' . $trimmer->trims($getData[0]->item_brand_model) . ' WITH ITEM ID :  ' . $request->remAss, '', '', Auth::user()->id, '');
        }

        $getName = DB::table('users_profile')
            ->select('emp_full_name')
            ->where('id', $request->viewExpID)
            ->get();

        $file = $request->file('clearanceForm');
        if ($file != null) {
            $name = $request->remAss . ' - ' . $getName[0]->emp_full_name . ' - Clearance Form' . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('/clearance_form/' . $request->remAss . '/'), $name);
            $path = '/clearance_form/' . $request->remAss . '/' . $name;

            DB::table('clearance_form')
                ->insert
                ([
                    'emp_id' => $request->viewExpID,
                    'item_id' => $request->remAss,
                    'clearance_path' => $path
                ]);
            $logs->assign_items('UPLOADED CLEARANCE FORM FOR UNASSIGNING ITEM ID :  ' . $request->remAss . ' FOR ' . $getName[0]->emp_full_name, '', '', Auth::user()->id, '');
        }
        DB::table('item_profile')
            ->where('id', $request->remAss)
            ->update
            ([
                'user_id' => '',
                'item_status' => 'available',
                'item_specs_status' => $removeScript->scripttrim($request->showSpecStat)
            ]);

        DB::table('item_to_ar')
            ->where('ar_to_employee_id', $request->ar_employee_id)
            ->where('item_id', $request->remAss)
            ->delete();

        $getName = DB::table('users_profile')
            ->join('ar_to_employee', 'ar_to_employee.emp_id', '=', 'users_profile.id')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.emp_full_name as emp_full_name',
                'branch_list.branch_name as branch'
            ])
            ->where('users_profile.id', $request->viewExpID)
            ->get();

        $getItemInfo = DB::table('item_profile')
            ->select('item_category', 'item_brand_model', 'item_specs_status', 'id')
            ->where('id', $request->remAss)
            ->get();

        $getAr = DB::table('ar_info')
            ->join('ar_to_employee', 'ar_to_employee.ar_id', '=', 'ar_info.id')
            ->select
            ([
                'ar_info.ar_description as description'
            ])
            ->where('ar_to_employee.id', $request->ar_employee_id)
            ->get();


        $logs->Item_log('ITEM UNASSIGNED FROM ' . $getName[0]->emp_full_name, $request->remAss, $request->viewExpID, Auth::user()->id, $removeScript->scripttrim($request->remarks));

        $logs->assign_items($trimmer->trims($getItemInfo[0]->item_category) . ' WITH BRAND/MODEL ' . $trimmer->trims($getItemInfo[0]->item_brand_model) . ' UNASSIGNED FROM ' . $trimmer->trims($getName[0]->emp_full_name) . '(' . $trimmer->trims($getName[0]->branch) . ' branch) WITH A.R DESCRIPTION ' . $trimmer->trims($getAr[0]->description), $trimmer->trims($getAr[0]->description), $request->viewExpID, Auth::user()->id, $trimmer->trims($request->remarks));
    }

    public function generalRequestTable()
    {
        $adminlist = DB::table('item_requests')
            ->join
            (
                'request_listitem', 'request_listitem.item_request_id', '=', 'item_requests.id'
            )
            ->select
            ([
                'request_listitem.item_name as name',
                'request_listitem.item_desc as description',
                'request_listitem.item_purp as purpose',
                'request_listitem.item_qty as quantity',
                'item_requests.itmreq_datetime as date',
                'item_requests.itmreq_receiver as receiver',
                'item_requests.itmreq_dept as department',
                'item_requests.itmreq_branch as branch',
                'item_requests.itmreq_requestor as requestor',
                'request_listitem.id as req_id'
            ])
            ->where('request_listitem.item_status', 'Requested');

        return DataTables::of($adminlist)
            ->make(true);
    }

    public function getItemDetails(Request $request)
    {
        $getData = DB::table('item_profile')
            ->join('po_pivot', 'po_pivot.item_id', '=', 'item_profile.id')
            ->join('purchase_order', 'purchase_order.id', '=', 'po_pivot.po_id')
            ->select
            ([
                'item_profile.item_photo_path as photo',
                'item_profile.item_category as category',
                'item_profile.item_brand_model as model',
                'item_profile.item_date_purchased as date',
                'purchase_order.po_number as po',
                'item_profile.item_amount as amount',
                'item_profile.item_color as color',
                'item_profile.item_remarks as remarks',
                'item_profile.warranty_label as warranty'
            ])
            ->where('item_profile.id', $request->itemIdEdit)
            ->get();

        return response()->json($getData);
    }

    public function poTable()
    {
        $getData = DB::table('item_profile')
            ->join('po_pivot', 'po_pivot.item_id', '=', 'item_profile.id')
            ->join('purchase_order', 'purchase_order.id', '=', 'po_pivot.po_id')
            ->select
            ([
                'item_profile.id as id',
                'purchase_order.po_number as po',
                'purchase_order.po_file_path as path'
            ]);
        return DataTables::of($getData)
            ->make(true);
    }

    public function dlQuote(Request $request)
    {
        $id = base64_decode($request->id);
        $getPath = DB::table('item_profile')
            ->select('quotation_path')
            ->where('id', $id)
            ->get();

        if (Auth::user()->hasRole('Admin Staff')) {
            return response()->download(storage_path($getPath[0]->quotation_path));
        } else {
            return response('');
        }
    }

    public function dlSupp(Request $request)
    {
        $id = base64_decode($request->id);
        $getPath = DB::table('supplier_list')
            ->select('supp_bi')
            ->where('id', $id)
            ->get();

        if (Auth::user()->hasRole('Admin Staff')) {
            return response()->download(storage_path($getPath[0]->supp_bi));
        } else {
            return response('');
        }
    }

    public function totalReq()
    {
        $getData = DB::table('admin_fund_request')
            ->select('request_amount')
            ->get();
        return response()->json($getData);
    }

    public function dlFormat(Request $request)
    {
        $id = base64_decode($request->id);

        $headers = ["Content-Type" => "application/zip"];

        $getPath = DB::table('hr_forms_files')
            ->select('under_file_path')
            ->where('upload_id', $id)
            ->get();

        $getTitle = DB::table('hr_forms')
            ->select('file_title', 'created_at')
            ->where('id', $id)
            ->get();

        $code_date_time = explode(' ', $getTitle[0]->created_at);
        $code_date = explode('-', $code_date_time[0]);
        $code_time = explode(':', $code_date_time[1]);

        $fileName = $getTitle[0]->file_title . '_' . $code_date[0] . $code_date[1] . $code_date[2] . $code_time[0] . $code_time[1] . $code_time[2] . ".zip";

        if (Auth::user()->hasRole('Admin Staff')) {
            foreach ($getPath as $path) {
                Zip::create(storage_path('/hr_general_forms/' . $id . '/' . $fileName))
                    ->add(storage_path() . $path->under_file_path)
                    ->close();
            }

            return response()
                ->download(storage_path('/hr_general_forms/' . $id . '/' . $fileName), $fileName, $headers)
                ->deleteFileAfterSend(true);
        } else {
            return response('');
        }
    }

    public function admin_staff_general_upload_mult(Request $request)
    {
        $code_date_time = explode(' ', Carbon::now('Asia/Manila'));
        $code_date = explode('-', $code_date_time[0]);
        $code_time = explode(':', $code_date_time[1]);

        $fileCount = $request->countFiles;
        $path = '';

        $getId = DB::table('hr_forms')
            ->insertGetId
            ([
                'file_title' => $request->docTitle,
                'file_desc' => $request->docDesc,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        for ($i = 0; $i < $fileCount; $i++) {
            $file = $request->file('file-' . $i . '');

            $name = $request->docTitle . '-' . $i . '-' . $code_date[0] . $code_date[1] . $code_date[2] . $code_time[0] . $code_time[1] . $code_time[2] . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('/hr_general_forms/' . $getId . '/'), $name);
            $path = '/hr_general_forms/' . $getId . '/' . $name;

            DB::table('hr_forms_files')
                ->insert
                ([
                    'upload_id' => $getId,
                    'under_file_path' => $path,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
        }
        $logs = new AuditQueries();
        $logs->assign_items('' . $fileCount . ' file/s uploaded with Title: ' . $request->docTitle . ', Description : ' . $request->docDesc, '', '', Auth::user()->id, '');
        $logs->create_profile_log('' . $fileCount . ' file/s uploaded with Title: ' . $request->docTitle . ', Description : ' . $request->docDesc, '', Auth::user()->id);
    }

    public function admin_staff_employee_table()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'users_profile.emp_approval as approval',
                'users_profile.emp_status_tagging as tag'
            ])
            ->where('users_profile.emp_approval', '!=', 'Approved')
            ->where('users_profile.emp_approval', '!=', 'R-Denied');

        return DataTables::of($getEmployees)
            ->make(true);
    }

    public function admin_staff_get_employees_not_approve()
    {
        $getEmp = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'branch_list.branch_name as branch'
            ])
            ->where(function ($query) {
                $query->where('users_profile.emp_approval', 'Requested')
                    ->orWhere('users_profile.emp_approval', 'R-Approved')
                    ->orWhere('users_profile.emp_approval', 'Returned');
            })
            ->orderBy('users_profile.id', 'DESC')
            ->get();

        return response()->json($getEmp);
    }

    public function admin_staff_employee_appprove_table()
    {
        $getEmployees = DB::table('users_profile')
            ->join('branch_list', 'branch_list.id', '=', 'users_profile.branch_id')
            ->join('user_benefits', 'user_benefits.user_id', '=', 'users_profile.id')
            ->select
            ([
                'users_profile.id as id',
                'users_profile.emp_full_name as name',
                'users_profile.emp_position as position',
                'branch_list.branch_name as branch',
                'users_profile.emp_status as con_status',
                'users_profile.emp_process_status as emp_status',
                'users_profile.emp_date_hired as hired',
                'users_profile.emp_end_date as end',
                'users_profile.emp_gender as gender',
                'users_profile.emp_date_birth as birth',
                'users_profile.emp_marital_status as marital',
                'users_profile.emp_dependents as dependents',
                'users_profile.emp_approval as approval',
                'users_profile.emp_status_tagging as tag'
            ])
            ->where('users_profile.emp_approval', 'Approved');

        return DataTables::of($getEmployees)
            ->make(true);
    }

    public function admin_staff_archive_general_files(Request $request)
    {
        DB::table('hr_forms')
            ->where('id', $request->id)
            ->update([
                'status' => 'Archived',
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        return 'ok';
    }

    public function admin_staff_archieved_general_forms_table()
    {
        $getData = DB::table('hr_forms')
            ->select('id', 'file_title', 'file_desc')
            ->where('status', 'Archived')
            ->orderByDesc('id');

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_encode_item_login(Request $req)
    {
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            if (Auth::user()->archive == 'False') {
                if (Auth::user()->hasRole('Admin Staff')) {
                    return Auth::user()->id;
                } else {
                    Auth::logout();
                    return 'not admin staff';
                }
            } else {
                Auth::logout();
                return 'error';
            }

        } else {
            Auth::logout();
            return 'error';
        }
    }

    public function admin_staff_submit_item_to_inventory(Request $request)
    {
        $script = new ScriptTrimmer();
        $now = Carbon::now('Asia/Manila');
        $equipmentId = '';

        $equipmentId = DB::table('equipments')
            ->insertGetId([
                'barcode' => $request->barcode,
                'type' => $request->what_type,
                'item_price' => $request->item_price,
                'item_details_type' => $request->item_det_type,
                'item_brand' => $request->item_brand,
                'item_description' => $request->item_desc,
                'item_invoice_number' => $request->item_invoice,
                'item_warranty' => $request->item_war,
                'current_status' => $request->item_condition,
                'status' => $request->item_status,
                'created_at' => $now
            ]);

        if ($request->what_type == 'Employee Equipment') {
            DB::table('equipment_to_user')
                ->insert([
                    'equipment_id' => $equipmentId,
                    'employee_id' => $script->scripttrim($request->emp_id),
                    'position' => $script->scripttrim($request->emp_pos),
                    'branch_id' => $script->scripttrim($request->item_branch),
                    'status' => $request->item_status,
                    'created_at' => $now
                ]);
        } else if ($request->what_type == 'Branch Asset') {
            DB::table('equipment_to_branch')
                ->insert([
                    'equipment_id' => $equipmentId,
                    'branch_id' => $script->scripttrim($request->item_branch),
                    'status' => $request->item_status,
                    'created_at' => $now
                ]);
        }

        DB::table('assign_logs')
            ->insert([
                'equipment_id' => $equipmentId,
                'user_id' => Auth::user()->id,
                'activities' => Auth::user()->name . ' Added an item to the inventory tagged as ' . $request->item_status,
                'remarks' => '-',
                'created_at' => $now
            ]);


        return response()->json($equipmentId);


    }

    public function admin_staff_upload_pictures_fine(Request $request, $bar_code)
    {

        $get_id = DB::table('equipments')
            ->select('id', 'barcode')
            ->orderBy('id', 'desc')
            ->where('barcode', $bar_code)
//            ->first()->id;
            ->get()[0]->id;

        $uploader = new handler();

//        $id = $uploader->id;

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array(); // all files types allowed by default

// Specify max file size in bytes.
        $uploader->sizeLimit = null;

// Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method = $uploader->ismethod();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.

        if ($method == "POST") {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done


            if (isset($_GET["done"])) {
                $result = $uploader->combineChunks(('admin_inventory/' . $get_id));
            } // Handles upload requests
            else {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                if (!File::isDirectory(storage_path('admin_inventory/' . $get_id))) {
                    File::makeDirectory(storage_path('admin_inventory/' . $get_id));
                }
                $result = $uploader->handleUpload(storage_path('admin_inventory/' . $get_id));
                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }

            echo json_encode($result);
        } // for delete file requests
        else if ($method == "DELETE") {
            $result = $uploader->handleDelete("files");
            echo json_encode($result);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
        }
    }

    public function admin_staff_get_item_history(Request $request)
    {
        $getHist = DB::table('equipment_to_user')
            ->join('assign_logs', 'assign_logs.equipment_id', '=', 'equipment_to_user.equipment_id')
            ->join('users', 'users.id', '=', 'assign_logs.user_id')
            ->where('equipment_to_user.equipment_id', $request->eq_id)
            ->select([
                'equipment_to_user.status as status',
                'equipment_to_user.employee_id as emp_id',
                'equipment_to_user.created_at as datetime_added',
                'users.name as name'
            ])
            ->orderByDesc('equipment_to_user.id')
            ->groupBy('equipment_to_user.id')
            ->get();

        return $getHist;
    }

    public function admin_staff_update_item_to_inventory(Request $request)
    {
        $trim = new ScriptTrimmer();
        $eq_id = base64_decode($request->id);

        if ($request->what == 'emp') {
            $check_if_exist = DB::table('equipment_to_user')
                ->where('equipment_id', $eq_id)
                ->orderByDesc('id')
                ->get();

            if (count($check_if_exist) > 0) {
                if ($check_if_exist[0]->employee_id == $trim->scripttrim($request->emp_id)) {
                    DB::table('equipment_to_user')
                        ->where('id', $check_if_exist[0]->id)
                        ->update([
                            'status' => $request->item_status,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('equipments')
                        ->where('id', $eq_id)
                        ->update([
                            'current_status' => $request->item_condition,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('assign_logs')
                        ->insert([
                            'equipment_id' => $eq_id,
                            'user_id' => Auth::user()->id,
                            'activities' => Auth::user()->name . ' updates the status of an equipment tagged as: ' . $request->item_status,
                            'remarks' => $trim->scripttrim($request->remarks),
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                } else {
                    DB::table('equipment_to_user')
                        ->insert([
                            'equipment_id' => $eq_id,
                            'employee_id' => $trim->scripttrim($request->emp_id),
                            'branch_id' => $request->branch,
                            'status' => $request->item_status,
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('equipments')
                        ->where('id', $eq_id)
                        ->update([
                            'current_status' => $request->item_condition,
                            'updated_at' => Carbon::now('Asia/Manila')
                        ]);

                    DB::table('assign_logs')
                        ->insert([
                            'equipment_id' => $eq_id,
                            'user_id' => Auth::user()->id,
                            'activities' => Auth::user()->name . ' updates the status of an equipment tagged as: ' . $request->item_status,
                            'remarks' => $trim->scripttrim($request->remarks),
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            } else {
                return 'not existing';
            }
        } else if ($request->what == 'branch') {
            $check_if_exist = DB::table('equipment_to_branch')
                ->where('equipment_id', $eq_id)
                ->orderByDesc('id')
                ->get();

            if (count($check_if_exist) > 0) {
                DB::table('equipment_to_branch')
                    ->where('equipment_id', $eq_id)
                    ->update([
                        'equipment_id' => $eq_id,
                        'branch_id' => $request->branch,
                        'status' => 'N/A',
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('equipments')
                    ->where('id', $eq_id)
                    ->update([
                        'current_status' => $request->item_condition,
                        'updated_at' => Carbon::now('Asia/Manila')
                    ]);

                DB::table('assign_logs')
                    ->insert([
                        'equipment_id' => $eq_id,
                        'user_id' => Auth::user()->id,
                        'activities' => Auth::user()->name . ' updates the status of an equipment condition : ' . $request->item_condition,
                        'remarks' => $trim->scripttrim($request->remarks),
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            } else {
                return 'not existing';
            }
        }

        if (!File::isDirectory(storage_path('admin_inventory/' . $eq_id))) {
            return 'success';
        } else {
            File::deleteDirectory(storage_path('admin_inventory/' . $eq_id));

            return 'success';
        }
    }

    public function admin_staff_nation_wide_inventory(Request $request)
    {
        $item = $request->itemTosearch;
        $branch = $request->branchTosearch;
        $search = $request->search;

        $inventory = DB::table('equipments')
            ->leftjoin('equipment_to_user', 'equipment_to_user.equipment_id', '=', 'equipments.id')
            ->leftjoin('users_atm', 'users_atm.emp_id_no', '=', 'equipment_to_user.employee_id')
            ->leftJoin('users_profile', 'users_profile.id', '=', 'users_atm.user_id')
            ->leftjoin('archipelagos as emp_branch', 'emp_branch.id', '=', 'equipment_to_user.branch_id')
            ->leftjoin('equipment_to_branch', 'equipment_to_branch.equipment_id', '=', 'equipments.id')
            ->leftjoin('archipelagos as branch', 'branch.id', '=', 'equipment_to_branch.branch_id')
            ->select([
                'equipments.id as id',
                'equipments.barcode as barcode',
                'equipments.type as eq_specs',
                'equipments.item_price as eq_price',
                'equipments.item_details_type as eq_det',
                'equipments.item_brand as item_brand',
                'equipments.item_description as item_description',
                'equipments.item_warranty as item_warranty',
                'emp_branch.archipelago_name as emp_branch',
                'emp_branch.id as emp_branch_id',
                'equipment_to_user.employee_id as employee_id',
                'branch.archipelago_name as branch',
                'branch.id as branch_id',
                'equipments.status as status',
                'equipments.current_status as cur_status',
                'equipments.created_at as datetime',
                'equipments.updated_at as updated_at',
                'users_profile.emp_full_name as emp_fName'
            ])
            ->orderByDesc('equipments.id')
            ->groupBy('equipments.id')
            ->where(function ($query) use ($search) {
                if ($search != '') {
                    return $query->where('equipments.type', $search);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($branch) {
                if ($branch != '') {
                    return $query->where('branch.id', $branch)
                        ->orwhere('emp_branch.id', $branch);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($item) {
                if ($item != '') {
                    return $query->where('equipments.item_details_type', $item);
                } else {
                    return true;
                }
            });

        return DataTables::of($inventory)
            ->make(true);
    }

    public function admin_staff_getProv(Request $request)
    {
        $getProv = DB::table('provinces')
            ->join('municipalities', 'municipalities.province_id', '=', 'provinces.id')
            ->where('provinces.name', $request->prov_name)
            ->select('municipalities.id', 'municipalities.muni_name')
            ->get();

        return $getProv;
    }

    public function admin_get_all_latest_item_pic(Request $request)
    {
        $file_name_array = [];
        $directory = storage_path('admin_inventory/' . $request->id);
        $filecount = glob("$directory/*");


        for ($ctr = 0; $ctr < count($filecount); $ctr++) {
            $file_name_array[$ctr] = explode($request->id . '/', $filecount[$ctr])[1];
        }

        $item = DB::table('equipments')
            ->leftjoin('equipment_to_user', 'equipment_to_user.equipment_id', '=', 'equipments.id')
            ->leftjoin('users_atm', 'users_atm.emp_id_no', '=', 'equipment_to_user.employee_id')
            ->leftJoin('users_profile', 'users_profile.id', '=', 'users_atm.user_id')
            ->leftJoin('branch_list as emp_branch', 'emp_branch.id', '=', 'users_profile.branch_id')
            ->leftjoin('equipment_to_branch', 'equipment_to_branch.equipment_id', '=', 'equipments.id')
            ->leftJoin('branch_list as branch', 'branch.id', '=', 'equipment_to_branch.branch_id')
            ->leftjoin('assign_logs', 'assign_logs.equipment_id', 'equipments.id')
            ->leftjoin('emp_position', 'emp_position.id', '=', 'equipment_to_user.position')
            ->where('equipments.barcode', $request->barcode)
            ->select([
                'equipments.id as id',
                'equipments.barcode as barcode',
                'equipments.type as type',
                'equipments.item_price as item_price',
                'equipments.item_details_type as item_details_type',
                'equipments.item_brand as item_brand',
                'equipments.item_description as item_description',
                'equipments.item_invoice_number as item_invoice_number',
                'equipments.item_warranty as item_warranty',
                'emp_branch.branch_name as emp_branch',
                'emp_branch.id as emp_branch_id',
                'equipment_to_user.employee_id as employee_id',
                'branch.branch_name as branch',
                'branch.id as branch_id',
                'equipment_to_user.status as status',
                'emp_position.position_name as position',
                'equipments.current_status as cur_status',
                'assign_logs.remarks as remarks',
                'equipments.current_status as current_status',
                'equipments.created_at as created_at',
                'equipments.updated_at as updated_at',
                'users_profile.emp_full_name as emp_fName'
            ])
            ->orderByDesc('equipment_to_user.id')
            ->orderByDesc('assign_logs.id')
            ->get();


        return response()->json([$request->id, $file_name_array, $item]);
    }

    public function admin_staff_update_item_description (Request $request){
        
        DB::table('equipments')
        ->where('id', $request->id)
        ->update([
            'item_description' => $request->item_desc,
            'created_at' => Carbon::now('Asia/Manila')
        ]);

        DB::table('assign_logs')
        ->insert([
            'equipment_id' => $request->id,
            'user_id' => Auth::user()->id,
            'activities' => Auth::user()->name . ' updated the item description',
            'created_at' => Carbon::now('Asia/Manila')
        ]);
    }

    public function admin_staff_update_item_status(Request $request)
    {
        $trims = new ScriptTrimmer();
        $zipper = new Zipper();


        $barcodeee = DB::table('equipments')
            ->where('id', $request->id)
            ->select('barcode')
            ->get();

        if ($request->file_count > 0) {
         $general_formID = DB::table('hr_forms')
                ->insertGetId([
                    'file_title' =>'Disposal of Item('.$barcodeee[0]->barcode.')',
                    'file_desc' => $trims->scripttrim($request->added_rem),
                    'file_path' => '',
                    'status' => '',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);
            DB::table('hr_forms_files')
                ->insert([
                    'upload_id' => $general_formID,
                    'under_file_path' => '/hr_general_forms/'.$general_formID.'/Disposal of Item('.$barcodeee[0]->barcode.').zip',
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            for ($i = 0; $i < $request->file_count; $i++) {
                $file1 = $request->file('file_' . $i);
                $file1->move(storage_path('inventory_disposal/' . $barcodeee[0]->barcode), $barcodeee[0]->barcode . '_' . $i . '.' . $file1->getClientOriginalExtension());
            }
            if($request->new_status == 'Disposal'){

                $testFile = storage_path('inventory_disposal/' . $barcodeee[0]->barcode);
                if (File::exists($testFile)) {
                    $fileDirectory = glob("$testFile/*");

                    $zipper->make(storage_path('hr_general_forms/'.$general_formID.'/Disposal of Item('.$barcodeee[0]->barcode.')') . '.zip')
                        ->add($fileDirectory);
                    $zipper->close();
                }
            }
        }

        DB::table('equipments')
            ->where('id', $request->id)
            ->update([
                'current_status' => $request->new_status,
                'created_at' => Carbon::now('Asia/Manila')
            ]);



        DB::table('assign_logs')
            ->insert([
                'equipment_id' => $request->id,
                'user_id' => Auth::user()->id,
                'activities' => Auth::user()->name . ' updated an item to inventory',
                'remarks' => $trims->scripttrim($request->added_rem),
                'created_at' => Carbon::now('Asia/Manila')
            ]);
    }

    public function admin_staff_get_logs_invent(Request $request)
    {
        $getLogs = DB::table('assign_logs')
            ->join('users', 'users.id', '=', 'assign_logs.user_id')
            ->where('assign_logs.equipment_id', $request->id)
            ->select([
                'users.name as name',
                'assign_logs.activities as act',
                'assign_logs.created_at as datetime'
            ])
            ->get();

        return response()->json($getLogs);
    }

    public function monitoring_generate_barcodes(Request $request)
    {
        $count = $request->count;
        $i = 0;
        $barcodes = [];
        $barcodes_encoded = [];
        $tracking = '';
        $userArchipelago = [];
        $branchCode = '';

        $userArchipelago = DB::table('users')
            ->join('provinces', 'provinces.id', 'users.branch')
            ->join('regions', 'regions.id', 'provinces.region_id')
            ->join('archipelagos', 'archipelagos.id', 'regions.archipelago_id')
            ->where('users.branch', Auth::user()->branch)
            ->select([
                'archipelagos.archipelago_name as archi'
            ])
            ->get();

        if (count($userArchipelago) > 0) {
            if ($userArchipelago[0]->archi == 'LUZON') {
                $branchCode = 'LUZ';
            } else if ($userArchipelago[0]->archi == 'VISAYAS') {
                $branchCode = 'VIS';
            } else if ($userArchipelago[0]->archi == 'MINDANAO') {
                $branchCode = 'MIN';
            }
        }

        $date = Carbon::now('Asia/Manila');
        $date = explode(' ', $date);
        $hour = explode(':', $date[1]);
        $dateClean = explode('-', $date[0]);

        for ($i = 0; $i <= $count - 1; $i++) {
            $tracking = $branchCode . '-O' . $dateClean[0][2] . $dateClean[0][3] . $dateClean[1] . $dateClean[2] . '-M' . strtoupper(Str::random(5)) . $i . '-S' . $hour[0] . $hour[1] . $hour[2];
            $barcodes_encoded[$i] = $tracking;
        }

        return $barcodes_encoded;
    }

    public function admin_staff_quantity_mon_table(Request $request)
    {
        $item = $request->item;
        $branch = $request->branch;
        $search = $request->search;

        $inventory = DB::table('equipments')
            ->leftjoin('equipment_to_user', 'equipment_to_user.equipment_id', '=', 'equipments.id')
            ->leftjoin('users_atm', 'users_atm.emp_id_no', '=', 'equipment_to_user.employee_id')
            ->leftJoin('users_profile', 'users_profile.id', '=', 'users_atm.user_id')
            ->leftjoin('archipelagos as emp_branch', 'emp_branch.id', '=', 'equipment_to_user.branch_id')
            ->leftjoin('equipment_to_branch', 'equipment_to_branch.equipment_id', '=', 'equipments.id')
            ->leftjoin('archipelagos as branch', 'branch.id', '=', 'equipment_to_branch.branch_id')
            ->select([
                'equipments.item_details_type as item',
                'emp_branch.archipelago_name as employee_branch',
                'branch.archipelago_name as branch',
                \DB::raw('count(equipments.item_details_type) as count'),
            ])
            ->orderByDesc('equipments.id')
//            ->groupBy('equipments.id')
            ->groupBy('equipments.item_details_type')
            ->where(function ($query) use ($search) {
                if ($search != '') {
                    return $query->where('equipments.type', $search);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($branch) {
                if ($branch != '') {
                    return $query->where('branch.id', $branch)
                        ->orwhere('emp_branch.id', $branch);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($item) {
                if ($item != '') {
                    return $query->where('equipments.item_details_type', $item);
                } else {
                    return true;
                }
            });

        return DataTables::of($inventory)
            ->editColumn('branch', function ($data) {
                if ($data->employee_branch == null) {
                    return $data->branch;
                } else {
                    return $data->employee_branch;
                }
            })
            ->rawColumns([
                'branch'
            ])
            ->make(true);
    }

    public function admin_staff_availability_mon_table(Request $request)
    {
        $item = $request->item;
        $branch = $request->branch;
        $search = $request->search;
        $position = $request->position;
        $cur_stats = $request->current_status;
        $availability = $request->availability;

        $inventory = DB::table('equipments')
            ->leftjoin('equipment_to_user', 'equipment_to_user.equipment_id', '=', 'equipments.id')
            ->leftjoin('users_atm', 'users_atm.emp_id_no', '=', 'equipment_to_user.employee_id')
            ->leftJoin('users_profile', 'users_profile.id', '=', 'users_atm.user_id')
            ->leftjoin('archipelagos as emp_branch', 'emp_branch.id', '=', 'equipment_to_user.branch_id')
            ->leftjoin('equipment_to_branch', 'equipment_to_branch.equipment_id', '=', 'equipments.id')
            ->leftjoin('archipelagos as branch', 'branch.id', '=', 'equipment_to_branch.branch_id')
            ->select([
                'equipments.id as id',
                'equipments.barcode as barcode',
                'equipment_to_user.status as user_avail',
                'equipment_to_branch.status as branch_avail',
                'equipments.current_status as current_status1',
                'emp_branch.archipelago_name as employee_branch',
                'branch.archipelago_name as branch',
            ])
            ->orderByDesc('equipments.id')
            ->where(function ($query) use ($search) {
                if ($search != '') {
                    return $query->where('equipments.type', $search);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($branch) {
                if ($branch != '') {
                    return $query->where('branch.id', $branch)
                        ->orwhere('emp_branch.id', $branch);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($item) {
                if ($item != '') {
                    return $query->where('equipments.item_details_type', $item);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($position) {
                if ($position != '') {
                    return $query->where('equipment_to_user.position', $position);
                } else {
                    return true;
                }
            })
            ->where(function ($query) use ($availability) {
                if ($availability != '') {
                    return $query->where('equipment_to_branch.status', $availability)
                        ->orwhere('equipment_to_user.status', $availability);
                }
            })
            ->where(function ($query) use ($cur_stats) {
//                return $query->where('equipments.current_status', $cur_stats);

                if ($cur_stats != '') {
                    return $query->where('equipments.current_status', $cur_stats);
                } else {
                    return true;
//                    return $query->where('equipments.current_status', 'Good Condition');
                }
            });

        return DataTables::of($inventory)
            ->editColumn('branch', function ($data) {
                if ($data->employee_branch == null) {
                    return $data->branch;
                } else {
                    return $data->employee_branch;
                }
            })
            ->editColumn('avail_status', function ($data) {
                if ($data->user_avail == null) {
                    if ($data->branch_avail == '') {
                        return 'N/A';
                    } else {
                        return $data->branch_avail;
                    }
                } else if ($data->branch_avail == null) {
                    return $data->user_avail;
                }
            })
            ->rawColumns([
                'branch',
                'avail_status'
            ])
            ->make(true);
    }

    public function admin_staff_view_items_to_remove_table()
    {
        $items = DB::table('item_details_admin_inventory')
            ->select([
                'item_details_admin_inventory.id as id',
                'item_details_admin_inventory.item_type as item_name',
                'item_details_admin_inventory.type as type',
                'item_details_admin_inventory.created_at as datetime',
            ]);

        return DataTables::of($items)
            ->make(true);
    }

    public function admin_staff_delete_item_name(Request $request)
    {
        DB::table('item_details_admin_inventory')
            ->where('id', $request->id)
            ->delete();

        return 'ok';
    }

    public function admin_staff_add_item_to_nationwide_names(Request $request)
    {
        $checker = DB::table('item_details_admin_inventory')
            ->where('item_type', $request->item_name)
            ->where('type', $request->item_spec)
            ->count();

        if ($checker > 0) {
            return 'double';
        } else {
            DB::table('item_details_admin_inventory')
                ->insert([
                    'item_type' => $request->item_name,
                    'type' => $request->item_spec,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            return 'ok';
        }

    }

    public function admin_staff_requi_table()
    {
        $getData = DB::table('admin_requisition')
            ->join('users', 'users.id', '=', 'admin_requisition.user_id')
            ->select
            ([
                'admin_requisition.id as id',
                'users.name as send_name',
                'admin_requisition.req_reason as tor',
                'admin_requisition.date_request as dor',
                'admin_requisition.requestor_name as req_name',
                'admin_requisition.office_loc_dep_pos as office_loc',
                'admin_requisition.date_needed as date_need',
                'admin_requisition.approved_by as app_by',
                'admin_requisition.approval_date as app_date'
            ])
            ->where('admin_requisition.request_status', 'Pending')
            ->where('admin_requisition.out_status', 'Approved');

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_get_details_requisition(Request $request)
    {
        $getData = DB::table('admin_requisition')
            ->where('id', $request->id)
            ->get();

        $getChecks = DB::table('admin_requisition_checks')
            ->select('check_name')
            ->where('request_id', $request->id)
            ->get();

        $getItems = DB::table('admin_requisition_items')
            ->select('brand_item_desc', 'item_quantity', 'item_unit_price', 'total_amount')
            ->where('request_id', $request->id)
            ->get();

        return response()->json([$getData, $getChecks, $getItems]);
    }

    public function admin_staff_approve_requi(Request $request)
    {
        $getData = DB::table('admin_requisition')
            ->select('requestor_name', 'requested_for_id', 'office_loc_dep_pos', 'user_id', 'admin_approver_id')
            ->where('id', $request->id)
            ->get();

        DB::table('admin_requisition_categ')
            ->insert
            ([
                'req_id' => $request->id,
                'req_tor' => $request->tor,
                'req_categ' => $request->categ,
                'req_type_1' => $request->type_1,
                'req_type_2' => $request->type_2,
                'req_others' => $request->others,
                'req_remarks' => $request->remarks,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        DB::table('admin_requisition')
            ->where('id', $request->id)
            ->update
            ([
                'request_status' => 'Approved',
                'admin_approver_id' => Auth::user()->id,
                'date_time_approved' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $logs = new AuditQueries();

        $logs->assign_items('Approved a request '.$getData[0]->requestor_name.' for an employee with ID no. '.$getData[0]->requested_for_id.' ('.$getData[0]->office_loc_dep_pos.'), pending for P.O Creation', '','',Auth::user()->id, $request->remarks);
    }

    public function admin_staff_requi_table_approved()
    {
        $getData = DB::table('admin_requisition')
            ->join('users', 'users.id', '=', 'admin_requisition.user_id')
            ->join('users as admin_id', 'admin_id.id', '=', 'admin_requisition.admin_approver_id')
            ->select
            ([
                'admin_requisition.id as id',
                'users.name as send_name',
                'admin_requisition.req_reason as tor',
                'admin_requisition.date_request as dor',
                'admin_requisition.requestor_name as req_name',
                'admin_requisition.office_loc_dep_pos as office_loc',
                'admin_requisition.date_needed as date_need',
                'admin_requisition.approved_by as app_by',
                'admin_requisition.approval_date as app_date',
                'admin_id.name as admin_name'
            ])
            ->where(function ($query) {
                return $query->where('admin_requisition.request_status', '=', 'Approved')
                    ->orwhere('admin_requisition.request_status', '=', 'Done');
            })
            ->where('admin_requisition.out_status', 'Approved');

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_requi_table_denied()
    {
        $getData = DB::table('admin_requisition')
            ->join('users', 'users.id', '=', 'admin_requisition.user_id')
            ->join('users as admin_id', 'admin_id.id', '=', 'admin_requisition.admin_approver_id')
            ->select
            ([
                'admin_requisition.id as id',
                'users.name as send_name',
                'admin_requisition.req_reason as tor',
                'admin_requisition.date_request as dor',
                'admin_requisition.requestor_name as req_name',
                'admin_requisition.office_loc_dep_pos as office_loc',
                'admin_requisition.date_needed as date_need',
                'admin_requisition.approved_by as app_by',
                'admin_requisition.approval_date as app_date',
                'admin_requisition.approver_remarks as rem',
                'admin_requisition.date_time_denied as dtDenied',
                'admin_id.name as admin_name'
            ])
            ->where('admin_requisition.request_status', 'Denied')
            ->where('admin_requisition.out_status', 'Approved');

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_deny_requi(Request $request)
    {
        $getData = DB::table('admin_requisition')
            ->select('requestor_name', 'requested_for_id', 'office_loc_dep_pos', 'user_id', 'admin_approver_id')
            ->where('id', $request->id)
            ->get();

        DB::table('admin_requisition')
            ->where('id', $request->id)
            ->update
            ([
                'request_status' => 'Denied',
                'admin_approver_id' => Auth::user()->id,
                'approver_remarks' => $request->remarks,
                'date_time_denied' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $logs = new AuditQueries();

        $logs->assign_items('Denied a request '.$getData[0]->requestor_name.' for an employee with ID no. '.$getData[0]->requested_for_id.' ('.$getData[0]->office_loc_dep_pos.')', '','',Auth::user()->id, $request->remarks);
    }

    public function admin_staff_submit_accred_sup(Request $request)
    {

        $code_date_time = explode(' ', Carbon::now('Asia/Manila'));
        $code_date = explode('-', $code_date_time[0]);
        $code_time = explode(':', $code_date_time[1]);

        $fileLength = $request->countFiles;
        $arrayTerms = json_decode($request->storeTerms);

        $stat = '';

        if ($request->checkifNewCateg == 'new') {
            DB::table('category_list')
                ->insert
                ([
                    'category_name' => strtoupper($request->supplierCat)
                ]);
        }

        if($request->requestEncode == 'New')
        {
            $stat = 'Pending';
        }
        else if($request->requestEncode == 'Existing')
        {
            $stat = 'Management Approved';
        }

        if ($request->id != 'new')
        {
            DB::table('admin_accredited_suppliers')
                ->where('id', $request->id)
                ->update
                ([
                    'admin_id' => Auth::user()->id,
                    'category' => strtoupper($request->supplierCat),
                    'supp_name' => $request->accred_supp_name,
                    'con_num' => $request->accred_supp_con_num,
                    'supp_address' => $request->accred_supp_address,
                    'contact_person' => $request->accred_sup_contact_person,
                    'sup_email' => $request->accred_sup_email,
                    'email_subj' => $request->accred_sup_email_subj,
                    'date_bi' => $request->accred_sup_date_bi,
                    'sup_bir' => $request->accred_sup_bir,
                    'sup_tin' => $request->accred_sup_tin,
                    'sup_tor' => $request->accred_sup_tor,
                    'sup_categorization' => $request->accred_sup_categorization,
                    'sup_descrip' => $request->accred_sup_descrip,
                    'sup_proposal' => $request->accred_sup_proposal,
                    'sup_results' => $request->accred_sup_results,
//                    'approval_status' => $stat,
                      'other_info_sup' => $request->accred_sup_discounts,
                    'updated_at' => Carbon::now('Asia/Manila')
                ]);

            if (count($arrayTerms) > 0) {
                DB::table('admin_accredited_suppliers_terms')
                    ->where('supp_id', $request->id)
                    ->delete();

                for ($a = 0; $a < count($arrayTerms); $a++) {
                    DB::table('admin_accredited_suppliers_terms')
                        ->insert
                        ([
                            'supp_id' => $request->id,
                            'supp_term' => $arrayTerms[$a],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }


            if ($fileLength > 0) {
                for ($i = 0; $i < $fileLength; $i++) {
                    $file = $request->file('file-' . $i . '');

                    if ($file != null) {
                        $final_name = '';
                        $name = $file->getClientOriginalName();

                        $checkFile = DB::table('admin_accredited_suppliers_files')
                            ->where('supplier_id', $request->id)
                            ->where('file_name', $name)
                            ->count();

                        if ($checkFile > 0) {
                            $final_name = $checkFile . '_' . $name;
                        } else {
                            $final_name = $name;
                        }

                        $file->move(storage_path('/accredited_suppliers/' . $request->id . '/'), $final_name);
//                $path = '/accredited_suppliers/' . $getId . '/' . $name;

                        DB::table('admin_accredited_suppliers_files')
                            ->insert
                            ([
                                'supplier_id' => $request->id,
                                'file_name' => $final_name,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                }
            }
        }
        else
        {
            $getId = DB::table('admin_accredited_suppliers')
                ->insertGetId
                ([
                    'admin_id' => Auth::user()->id,
                    'category' => strtoupper($request->supplierCat),
                    'supp_name' => $request->accred_supp_name,
                    'con_num' => $request->accred_supp_con_num,
                    'supp_address' => $request->accred_supp_address,
                    'contact_person' => $request->accred_sup_contact_person,
                    'sup_email' => $request->accred_sup_email,
                    'email_subj' => $request->accred_sup_email_subj,
                    'date_bi' => $request->accred_sup_date_bi,
                    'sup_bir' => $request->accred_sup_bir,
                    'sup_tin' => $request->accred_sup_tin,
                    'sup_tor' => $request->accred_sup_tor,
                    'sup_categorization' => $request->accred_sup_categorization,
                    'sup_descrip' => $request->accred_sup_descrip,
                    'sup_proposal' => $request->accred_sup_proposal,
                    'sup_results' => $request->accred_sup_results,
                    'approval_status' =>$stat,
                    'other_info_sup' => $request->accred_sup_discounts,
                    'created_at' => Carbon::now('Asia/Manila')
                ]);

            if (count($arrayTerms) > 0) {
                for ($a = 0; $a < count($arrayTerms); $a++) {
                    DB::table('admin_accredited_suppliers_terms')
                        ->insert
                        ([
                            'supp_id' => $getId,
                            'supp_term' => $arrayTerms[$a],
                            'created_at' => Carbon::now('Asia/Manila')
                        ]);
                }
            }

            if ($fileLength > 0) {
                for ($i = 0; $i < $fileLength; $i++) {
                    $file = $request->file('file-' . $i . '');

                    if ($file != null) {
                        $name = $file->getClientOriginalName();
                        $file->move(storage_path('/accredited_suppliers/' . $getId . '/'), $name);
//                $path = '/accredited_suppliers/' . $getId . '/' . $name;

                        DB::table('admin_accredited_suppliers_files')
                            ->insert
                            ([
                                'supplier_id' => $getId,
                                'file_name' => $name,
                                'created_at' => Carbon::now('Asia/Manila')
                            ]);
                    }
                }
            }
        }
    }

    public function admin_staff_accred_sup_table()
    {
        $getData = DB::table('admin_accredited_suppliers')
            ->select
            ([
                'admin_accredited_suppliers.id',
                'admin_accredited_suppliers.category',
                'admin_accredited_suppliers.supp_name',
                'admin_accredited_suppliers.contact_person',
                'admin_accredited_suppliers.created_at'
            ])
            ->where('admin_accredited_suppliers.approval_status', 'Management Approved');

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_get_indiv_accred(Request $request)
    {
        $getData = DB::table('admin_accredited_suppliers')
//            ->select('category', 'supp_name', 'con_num', 'supp_address', 'contact_person', 'sup_email', 'email_subj', 'date_bi',
//                'sup_bir', 'sup_tin', 'sup_tor', 'sup_categorization', 'sup_descrip', 'sup_proposal', 'sup_results')
            ->where('id', $request->id)
            ->get();

        $getFilesList = DB::table('admin_accredited_suppliers_files')
            ->select('supplier_id', 'file_name')
            ->where('supplier_id', $request->id)
            ->get();

        $getTerms = DB::table('admin_accredited_suppliers_terms')
            ->select('supp_term')
            ->where('supp_id', $request->id)
            ->get();

        return response()->json([$getData, $getFilesList, $getTerms]);
    }

    public function admin_staff_remove_selected_supplier_file(Request $request)
    {
        DB::table('admin_accredited_suppliers_files')
            ->where('supplier_id', $request->id)
            ->where('file_name', $request->name)
            ->delete();

        if (File::exists(storage_path('/accredited_suppliers/' . $request->id . '/' . $request->name))) {
            File::delete(storage_path('/accredited_suppliers/' . $request->id . '/' . $request->name));
        }
    }

    public function admin_staff_eq_proc_table()
    {
        $getData = DB::table('admin_requisition')
            ->join('admin_requisition_categ', 'admin_requisition_categ.req_id', '=', 'admin_requisition.id')
            ->select
            ([
                'admin_requisition.id as id',
                'admin_requisition.requestor_name as name',
                'admin_requisition.date_request as date',
                'admin_requisition_categ.req_tor as tor',
                'admin_requisition_categ.req_categ as categ',
                'admin_requisition_categ.req_type_1 as type_1',
                'admin_requisition_categ.req_type_2 as type_2',
                'admin_requisition_categ.req_others as others',
                'admin_requisition_categ.req_remarks as rem'
            ])
            ->where('admin_requisition.out_status', 'Approved')
            ->where('admin_requisition.request_status', 'Approved')
            ->where(function ($query) {
                return $query->where('admin_requisition.finance_status', '=', '')
                    ->orwhere('admin_requisition.finance_status', '=', null);
            });

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_sup_list_for_po()
    {
        $getData = DB::table('admin_accredited_suppliers')
            ->select('id', 'supp_name')
            ->where('approval_status', 'Management Approved')
            ->get();

        return response()->json($getData);
    }

    public function admin_staff_get_info_accred_to_po(Request $request)
    {
        $getData = DB::table('admin_accredited_suppliers')
            ->select('con_num', 'supp_address', 'contact_person', 'sup_email', 'created_at')
            ->where('id', $request->id)
            ->get();

        $getTerms = DB::table('admin_accredited_suppliers_terms')
            ->select('id', 'supp_term')
            ->where('supp_id', $request->id)
            ->get();

        return response()->json([$getData, $getTerms]);
    }

    public function admin_staff_insert_po_final(Request $request)
    {
        $brand = $request->dataBrand;
        $addNotesArr = $request->addNotesArr;

        $getId = DB::table('admin_purchase_order')
            ->insertGetId
            ([
                'requi_id' => $request->id,
                'prepared_by' => Auth::user()->id,
                'supplier_id' => $request->selectSupForPO,
                'term_payment' => $request->termsSupForPO,
                'po_no' => $request->poNumber,
                'po_date' => $request->poDate,
                'delivery_date' => $request->dateDeliverPO,
                'total_amount' => $request->totalAmtPO,
                'twelve_vat' => $request->twelveVatPO,
                'grand_total' => $request->grandTotalPO,
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        if (count($brand) > 0) {
            for ($i = 0; $i < count($brand); $i++) {
                DB::table('admin_purchase_order_items')
                    ->insert
                    ([
                        'po_id' => $getId,
                        'brand_item_desc' => $brand[$i][0],
                        'quantity' => $brand[$i][1],
                        'unit_price' => $brand[$i][2],
                        'total_amount' => $brand[$i][3],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);
            }
        }

        $remComp = '';

        if (count($addNotesArr) > 0) {
            for ($v = 0; $v < count($addNotesArr); $v++) {
                DB::table('admin_purchase_order_notes')
                    ->insert
                    ([
                        'po_id' => $getId,
                        'additional_notes' => $addNotesArr[$v],
                        'created_at' => Carbon::now('Asia/Manila')
                    ]);

                $remComp .= $addNotesArr[$v] .'/';
            }
        }

        DB::table('admin_requisition')
            ->where('id', $request->id)
            ->update
            ([
                'finance_status' => 'Finance Process',
                'updated_at' => Carbon::now('Asia/Manila')
            ]);

        $logs = new AuditQueries();

        $logs->assign_items('Created a P.O with P.O no: '.$request->poNumber.' for requisition no: '.$request->id.' for Finance Process', '','',Auth::user()->id, $remComp);
    }

    public function admin_staff_eq_proc_table_finance()
    {
        $getData = DB::table('admin_requisition')
            ->join('admin_requisition_categ', 'admin_requisition_categ.req_id', '=', 'admin_requisition.id')
            ->select
            ([
                'admin_requisition.id as id',
                'admin_requisition.requestor_name as name',
                'admin_requisition.date_request as date',
                'admin_requisition_categ.req_tor as tor',
                'admin_requisition_categ.req_categ as categ',
                'admin_requisition_categ.req_type_1 as type_1',
                'admin_requisition_categ.req_type_2 as type_2',
                'admin_requisition_categ.req_others as others',
                'admin_requisition.finance_status as fin_stat'
            ])
            ->where('admin_requisition.out_status', 'Approved')
            ->where('admin_requisition.request_status', 'Approved')
            ->where(function ($query) {
                return $query->where('finance_status', '=', 'Finance Process')
                    ->orwhere('finance_status', '=', 'Finance Done');
            });

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_get_attach_rem_fin(Request $request)
    {
        $getData = DB::table('admin_requisition')
            ->select('finance_remarks')
            ->where('id', $request->id)
            ->get();

        $getData2 = DB::table('admin_requisition_finance_files')
            ->select('file_name')
            ->where('requi_id', $request->id)
            ->get();

        return response()->json([$getData, $getData2]);
    }

    public function admin_staff_change_to_done_requi(Request $request)
    {
        DB::table('admin_requisition')
            ->where('id', $request->id)
            ->update
            ([
                'request_status' => 'Done',
                'done_remarks' => $request->confirm_done,
                'updated_at' => Carbon::now('Asia/Manila')
            ]);


        $logs = new AuditQueries();

        $logs->assign_items('Finished the process of requisition no: '.$request->id.'', '','',Auth::user()->id,  $request->confirm_done);
    }

    public function admin_staff_gen_requi_table()
    {
        $getData = DB::table('admin_requisition')
            ->leftjoin('admin_requisition_categ', 'admin_requisition_categ.req_id', '=', 'admin_requisition.id')
            ->leftjoin('admin_purchase_order', 'admin_purchase_order.requi_id', '=', 'admin_requisition.id')
            ->leftjoin('admin_accredited_suppliers', 'admin_accredited_suppliers.id', '=', 'admin_purchase_order.supplier_id')
            ->join('users', 'users.id', '=', 'admin_requisition.user_id')
            ->leftjoin('users_atm', 'users_atm.emp_id_no', '=', 'admin_requisition.requested_for_id')
            ->leftjoin('users_profile', 'users_profile.id', '=',  'users_atm.user_id')
            ->select
            ([
                'admin_requisition.id as id',
                'admin_requisition.date_request as date_req',
                'admin_requisition_categ.req_tor as req_tor',
                'admin_requisition_categ.req_categ as req_categ',
                'admin_requisition_categ.req_type_1 as req_type_1',
                'admin_requisition_categ.req_type_2 as req_type_2',
                'admin_requisition_categ.req_others as others',
                'users.name as send_name',
                'admin_requisition.requestor_name as req_name',
                'admin_requisition.office_loc_dep_pos as office_loc',
                'admin_requisition.date_needed as date_need',
                'admin_requisition.approved_by as app_by',
                'admin_requisition.approval_date as app_date',
                'admin_requisition.request_status as req_stat',
                'admin_requisition.out_status as out_stat',
                'admin_requisition.finance_status as fin_stat',
                'users_profile.emp_full_name as emp_name',
                'admin_accredited_suppliers.supp_name as supp_name',
                'admin_requisition.requested_for as req_emp_name'
            ])
            ->groupBy('admin_requisition.id');

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_eq_proc_done_table()
    {
        $getData = DB::table('admin_requisition')
            ->join('admin_requisition_categ', 'admin_requisition_categ.req_id', '=', 'admin_requisition.id')
            ->select
            ([
                'admin_requisition.id as id',
                'admin_requisition.requestor_name as name',
                'admin_requisition.date_request as date',
                'admin_requisition_categ.req_tor as tor',
                'admin_requisition_categ.req_categ as categ',
                'admin_requisition_categ.req_type_1 as type_1',
                'admin_requisition_categ.req_type_2 as type_2',
                'admin_requisition_categ.req_others as others',
                'admin_requisition.finance_status as fin_stat',
                'admin_requisition.done_remarks as done_rem'
            ])
            ->where('admin_requisition.out_status', 'Approved')
            ->where('admin_requisition.request_status', 'Done')
            ->where(function ($query) {
                return $query->where('finance_status', '=', 'Finance Process')
                    ->orwhere('finance_status', '=', 'Finance Done');
            });

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_accred_for_compa_table()
    {
        $getData = DB::table('admin_accredited_suppliers')
            ->select
            ([
                'admin_accredited_suppliers.id',
                'admin_accredited_suppliers.category',
                'admin_accredited_suppliers.supp_name',
                'admin_accredited_suppliers.contact_person',
                'admin_accredited_suppliers.created_at'
            ])
            ->where('admin_accredited_suppliers.approval_status', 'Pending');

        return DataTables::of($getData)
            ->make(true);
    }

    public function admin_staff_submit_management_approval(Request $request)
    {
        $arraySup = $request->arraySupSelected;
        $sups = '';

        $getID = DB::table('admin_accredited_supplier_management_app')
            ->insertGetId
            ([
                'pass_id' => Auth::user()->id,
                'categ_sup' => $request->categoryToPass,
                'eq_desc_sup' => $request->equipmentToBuy,
                'sup_rem' => $request->remarksComparison,
                'req_stat' => 'Pending',
                'created_at' => Carbon::now('Asia/Manila')
            ]);

        if(count($arraySup) > 0)
        {
            for($i = 0; $i < count($arraySup); $i++)
            {
                DB::table('admin_accredited_suppliers')
                    ->where('id', $arraySup[$i])
                    ->update
                    ([
                        'approval_status' => 'Management Pending',
                        'pivot_request' => $getID
                    ]);

                $getSupName = DB::table('admin_accredited_suppliers')
                    ->where('id', $arraySup[$i])
                    ->select('supp_name')
                    ->get();

                $sups .= $getSupName[0]->supp_name . ', ';
            }
        }

        $logs = new AuditQueries();
        $logs->assign_items('Submitted suppliers with names, '.$sups.' to Management for accreditation approval', '','',Auth::user()->id,  $request->remarksComparison);

        $emailSend = new EmailQueries();
        $emailSend->sendRequestSupplierManager($request, $sups);
     }

     public function admin_staff_monit_sup_approval()
     {
         $getData = DB::table('admin_accredited_supplier_management_app')
             ->join('users', 'users.id', '=', 'admin_accredited_supplier_management_app.pass_id')
             ->select
             ([
                 'admin_accredited_supplier_management_app.id as id',
                 'admin_accredited_supplier_management_app.created_at as dt',
                 'users.name as pass_name',
                 'admin_accredited_supplier_management_app.categ_sup as categ',
                 'admin_accredited_supplier_management_app.eq_desc_sup as equi',
                 'admin_accredited_supplier_management_app.sup_rem as rem',
                 'admin_accredited_supplier_management_app.req_stat as stat',
             ]);

         return DataTables::of($getData)
             ->make(true);
     }

     public function admin_staff_accred_sup_table_denied()
     {
         $getData = DB::table('admin_accredited_suppliers')
             ->select
             ([
                 'admin_accredited_suppliers.id',
                 'admin_accredited_suppliers.category',
                 'admin_accredited_suppliers.supp_name',
                 'admin_accredited_suppliers.contact_person',
                 'admin_accredited_suppliers.created_at'
             ])
             ->where('admin_accredited_suppliers.approval_status', 'Management Denied');

         return DataTables::of($getData)
             ->make(true);
     }

    public function admin_staff_get_management_info_app(Request $request)
    {
        $getReq = DB::table('admin_accredited_supplier_management_app')
            ->leftjoin('users', 'users.id', '=', 'admin_accredited_supplier_management_app.app_id')
            ->select
            ([
                'users.name as name',
                'admin_accredited_supplier_management_app.approver_remarks as rem',
                'admin_accredited_supplier_management_app.categ_sup as categ',
                'admin_accredited_supplier_management_app.eq_desc_sup as desc',
                'admin_accredited_supplier_management_app.sup_rem as rem',
                'admin_accredited_supplier_management_app.req_stat as stat',
                'admin_accredited_supplier_management_app.approver_remarks as app_rem'
            ])
            ->where('admin_accredited_supplier_management_app.id', $request->id)
            ->get();

        $getSup = DB::table('admin_accredited_suppliers')
            ->select('id', 'category', 'supp_name', 'approval_status')
            ->where('pivot_request', $request->id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([$getReq, $getSup]);
    }

    public function admin_send_ar_notif(Request $req)
    {
        $email = new EmailQueries();

       $form_id = DB::table('acknowledge_forms')
        ->insertGetId([
            'emp_id' => $req->user_id,
            'office_loc_dep_pos' => $req->officeLocDept,
            'cnum_email' => $req->contNumEmail,
            'lbc_branch' => $req->LbcBranch,
            'admin_id' => Auth::user()->id,
            'status' => '',
            'created_at' => Carbon::now('Asia/Manila')
           ]);


        DB::table('acknowledge_form_details')
            ->insert([
                'form_id' => $form_id,
                'encoded_items' => $req->json_data,
                'attachment_bool' => $req->checkBox,
                'created_at' => Carbon::now('Asia/Manila'),
            ]);

        $json_data = $req->json_data;
        $convert_json = json_decode($json_data);

       $email->admin_ar_notify($form_id);

        return 'success';
    }

    public function acknowledge_names(Request $request)
    {
        $searchLetter = $request->term;

        $resultNames = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->select
            ([
                'users.name',
                'users.email',
                'users.id'
            ])
            ->where(function ($query) {
                return $query->where('role_user.role_id', '!=', 1)
                    ->where('role_user.role_id', '!=', 6)
                    ->where('role_user.role_id', '!=', 14)
                    ->where('role_user.role_id', '!=', 999);
            })
            ->where('users.name', 'like', '%' . $searchLetter . '%')
            ->take(5)
            ->get();
        if(count($resultNames) == 0)
        {
         $resultTags[] = 'No result FOUND';
        } else {
        foreach ($resultNames as $resultName){
            $resultTags[] =
                [
                    'label' =>$resultName->name,
                    'email' =>$resultName->email,
                    'id' =>$resultName->id,
                ];
            }
        }
        return response()->json($resultTags);
    }

    public function get_ar_monitoring_table()
    {
        $Ar_monitoring_table = DB::table('acknowledge_forms')
            ->join('users', 'users.id', '=', 'acknowledge_forms.emp_id')
            ->join('acknowledge_form_details', 'acknowledge_form_details.form_id', '=', 'acknowledge_forms.id')
            ->select
            ([
                'users.name as employee_name',
                'acknowledge_forms.created_at as created_at',
                'acknowledge_forms.id as id',
                'acknowledge_forms.status as status',
            ])
        ->orderByDesc('acknowledge_forms.id');

        return DataTables::of($Ar_monitoring_table)
        ->make(true);
    }

    public function fetch_ar_monitoring (Request $request)
    {
        $viewAcknowledge = DB::table('acknowledge_forms')
            ->join('users', 'users.id', '=', 'acknowledge_forms.emp_id')
            ->join('acknowledge_form_details', 'acknowledge_form_details.form_id', '=', 'acknowledge_forms.id')
            ->select
            ([
                'users.name as Employee_name',
                'acknowledge_forms.id as id',
                'acknowledge_form_details.encoded_items as encoded_items',
                'acknowledge_form_details.attachment_bool as attachment_bool',
                'acknowledge_forms.office_loc_dep_pos as office_loc_dep_pos',
                'acknowledge_forms.cnum_email as cnum_email',
                'acknowledge_forms.lbc_branch as LBC_Branch',
                'acknowledge_forms.status as status',
                'acknowledge_forms.updated_at as updated_at',
                'acknowledge_forms.created_at as created_at'
            ])
            ->where('acknowledge_forms.id', $request->id)
            ->get();
        $encoded_items = json_decode($viewAcknowledge[0]->encoded_items);
        return response()->json([$viewAcknowledge, $encoded_items]);

    }
}