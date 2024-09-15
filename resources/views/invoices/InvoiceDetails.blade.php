@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قايمه الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتوره</span>
            </div>
        </div>

    </div>

    <!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">

                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                الفاتورة</a></li>
                                        <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                        <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab4">
                                            <table class="table table-striped" style="text-align:center">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">رقم الفاتورة</th>
                                                        <td>{{ $invoices->invoice_number }}</td>
                                                        <th scope="row">تاريخ الاصدار</th>
                                                        <td>{{ $invoices->invoice_Date }}</td>
                                                        <th scope="row">تاريخ الاستحقاق</th>
                                                        <td>{{ $invoices->Due_date }}</td>
                                                        <th scope="row">القسم</th>
                                                        <td>{{ $invoices->Section->section_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">المنتج</th>
                                                        <td>{{ $invoices->product }}</td>
                                                        <th scope="row">مبلغ التحصيل</th>
                                                        <td>{{ $invoices->Amount_collection }}</td>
                                                        <th scope="row">مبلغ العمولة</th>
                                                        <td>{{ $invoices->Amount_Commission }}</td>
                                                        <th scope="row">الخصم</th>
                                                        <td>{{ $invoices->Discount }}</td>
                                                    </tr>


                                                    <tr>
                                                        <th scope="row">نسبة الضريبة</th>
                                                        <td>{{ $invoices->Rate_VAT }}</td>
                                                        <th scope="row">قيمة الضريبة</th>
                                                        <td>{{ $invoices->Value_VAT }}</td>
                                                        <th scope="row">الاجمالي مع الضريبة</th>
                                                        <td>{{ $invoices->Total }}</td>
                                                        <th scope="row">الحالة الحالية</th>



                                                        @if ($invoices->status == 1)
                                                            <td><span
                                                                    class="badge badge-pill badge-success">{{ 'مدفوعه' }}</span>
                                                            </td>
                                                        @elseif($invoices->status == 2)
                                                            <td><span
                                                                    class="badge badge-pill badge-danger">{{ ' غير مدفوعه' }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge badge-pill badge-warning">{{ 'مدفوعه جزئيا ' }}</span>
                                                            </td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">ملاحظات</th>
                                                        <td>{{ $invoices->note }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab5">
                                            <table class="table center-aligned-table mb-0 table-hover"
                                                style="text-align:center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th>رقم الفاتورة</th>
                                                        <th>نوع المنتج</th>
                                                        <th>القسم</th>
                                                        <th>حالة الدفع</th>
                                                        <th>تاريخ الدفع </th>
                                                        <th>ملاحظات</th>
                                                        <th>تاريخ الاضافة </th>
                                                        <th>المستخدم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($details as $detail)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $detail->invoice_number }}</td>
                                                            <td>{{ $detail->product }}</td>
                                                            <td>{{ $invoices->Section->section_name }}</td>
                                                            @if ($detail->status == 1)
                                                                <td><span class="badge badge-pill badge-success">
                                                                        {{ 'مدفوعه' }} </span>
                                                                </td>
                                                            @elseif($detail->status == 2)
                                                                <td><span class="badge badge-pill badge-danger">
                                                                        {{ ' غير مدفوعه' }} </span>
                                                                </td>
                                                            @else
                                                                <td><span class="badge badge-pill badge-warning">
                                                                        {{ 'مدفوعه جزئيا ' }}</span>
                                                                </td>
                                                            @endif
                                                            <td>{{ $detail->Payment_Date }}</td>
                                                            <td>{{ $detail->note }}</td>
                                                            <td>{{ $detail->created_at }}</td>
                                                            <td>{{ $detail->user }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab6">


                                             <div class="card-body">
                                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                <h5 class="card-title">اضافة مرفقات</h5>
                                                <form method="post" action={{ route('attachments.store') }} enctype="multipart/form-data" >
                                                    {{ csrf_field() }}
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile"
                                                            name="file_name" required>
                                                        <input type="hidden" id="customFile" name="invoice_number"
                                                            value="{{ $invoices->invoice_number }}">
                                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                                            value="{{ $invoices->id }}">
                                                        <label class="custom-file-label" for="customFile">حدد
                                                            المرفق</label>
                                                    </div><br><br>
                                                    <button type="submit" class="btn btn-primary btn-sm "
                                                        name="uploadedFile">تاكيد</button>
                                                </form>
                                            </div>
                                             <table class="table center-aligned-table mb-0 table-hover"
                                                style="text-align:center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th> اسم الملف</th>
                                                        <th>قام بالاضافة</th>
                                                        <th>تاريخ الاضافة </th>
                                                        <th>العمليات</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($attachments as $attachment)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $attachment->file_name }}</td>
                                                            <td>{{ $attachment->created_by }}</td>
                                                            <td>{{ $attachment->created_at }}</td>
                                                            <td>
                                                                <a class="btn btn-outline-success btn-sm"
                                                                    href="{{ url('openFile') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                    role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                    عرض</a>

                                                                <a class="btn btn-outline-info btn-sm"
                                                                  href="{{ url('getFile') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                    role="button"><i class="fas fa-download"></i>&nbsp;
                                                                    تحميل</a>





                                                                <a class="btn btn-outline-danger btn-sm"
                                                                    data-target="#modaldemo3" data-toggle="modal"
                                                                    href="">حذف </a>

                                                                <form method="post"
                                                                    action="{{ route('invoice_details.destroy', $attachment->id) }}"
                                                                    style="display:inline;">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <!-- Large Modal -->
                                                                    <div class="modal" id="modaldemo3">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content modal-content-demo">
                                                                                <div class="modal-header">
                                                                                    <h6 class="modal-title">Large Modal</h6>
                                                                                    <button aria-label="Close"
                                                                                        class="close" data-dismiss="modal"
                                                                                        type="button"><span
                                                                                            aria-hidden="true">&times;</span></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <h6> هل انت متاكد حذف
                                                                                        {{ $attachment->file_name }}</h6>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button
                                                                                        class="btn ripple btn-danger">حذف</button>
                                                                                    <button class="btn ripple btn-secondary"
                                                                                        data-dismiss="modal"
                                                                                        type="button">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--End Large Modal -->

                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- /div -->



        <!-- /div -->


    </div>

    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
@endsection
