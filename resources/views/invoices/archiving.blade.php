@extends('layouts.master')
@section('title', '   الارشفه')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الارشفه
                     </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <a href="{{ route('invoices.create') }}" class="modal-effect btn btn-sm btn-primary"
                        style="color:white"><i class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                    <th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="wd-15p border-bottom-0"> تاريخ الاستحقاق</th>
                                    <th class="wd-10p border-bottom-0">المنتج</th>
                                    <th class="wd-25p border-bottom-0">القسم</th>
                                    <th class="wd-25p border-bottom-0">الخصم </th>
                                    <th class="wd-25p border-bottom-0">نسبه الضريبه </th>
                                    <th class="wd-25p border-bottom-0">قيمة الضريبه </th>
                                    <th class="wd-25p border-bottom-0"> الاجمالي </th>
                                    <th class="wd-25p border-bottom-0"> الحالة </th>
                                    <th class="wd-25p border-bottom-0"> ملاحظات </th>
                                    <th class="wd-25p border-bottom-0"> العملبات </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $invoice)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $invoice->invoice_number }} </td>
                                        <td>{{ $invoice->invoice_Date }}</td>
                                        <td>{{ $invoice->Due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>
                                            <a
                                                href="{{ route('invoice_details.edit', $invoice->id) }}">{{ $invoice->section->section_name }}</a>
                                        </td>
                                        <td>{{ $invoice->Discount }}</td>
                                        <td>{{ $invoice->Rate_VAT }}</td>
                                        <td>{{ $invoice->Value_VAT }}</td>
                                        <td>{{ $invoice->Total }}</td>
                                        <td>
                                            @if ($invoice->status == 1)
                                                <span class="text-success">{{ 'مدفوعه' }}</span>
                                            @elseif($invoice->status == 2)
                                                <span class="text-danger">{{ ' غير مدفوعه' }}</span>
                                            @else
                                                <span class="text-warning">{{ 'مدفوعه جزئيا ' }}</span>
                                            @endif



                                        </td>

                                        <td>{{ $invoice->note }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="invoiceActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    خيارات الفاتورة
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="invoiceActions">
                                                    @if ($invoice->deleted_at)
                                                        <!-- استرجاع الفاتورة -->
                                                        <a class="dropdown-item text-success" href="#" data-toggle="modal" data-target="#restoreModal">استرجاع</a>

                                                        <!-- حذف نهائي -->
                                                        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#forceDeleteModal">  <i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp; حذف نهائي
                                                        الفاتورة</a>

                                                     @else
                                                        <!-- تعديل الفاتورة -->
                                                        <a class="dropdown-item text-primary" href="{{ route('invoices.edit', $invoice->id) }}">تعديل</a>
                                                        <!-- تعديل   status الفاتورة -->
                                                        <a class="dropdown-item text-info" href="{{ route('invoices.show', $invoice->id) }}"> تعديل  حاله الدفع</a>

                                                        <!-- حذف موقت -->
                                                        <a class="dropdown-item text-warning" href="#" data-toggle="modal" data-target="#softDeleteModal">حذف موقت</a>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- استرجاع الفاتورة - Modal -->
                                            <form method="post" action="{{ route('invoices.restore', $invoice->id) }}" style="display:inline;">
                                                @csrf
                                                <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="restoreModalLabel">استرجاع الفاتورة</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                هل أنت متأكد من استرجاع الفاتورة؟
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                                <button type="submit" class="btn btn-success">استرجاع</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- حذف نهائي - Modal -->
                                            <form method="post" action="{{ route('invoices.force', $invoice->id) }}" style="display:inline;">
                                                @csrf
                                                @method('delete')
                                                <div class="modal fade" id="forceDeleteModal" tabindex="-1" role="dialog" aria-labelledby="forceDeleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="forceDeleteModalLabel">حذف نهائي</h5>
                                                                <input type="text" value="{{ $invoice->invoice_number }}">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                هل أنت متأكد من الحذف النهائي؟
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                                <button type="submit" class="btn btn-danger">حذف</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- حذف موقت - Modal -->
                                            <form method="post" action="{{ route('invoices.destroy', $invoice->id) }}" style="display:inline;">
                                                @csrf
                                                @method('delete')
                                                <div class="modal fade" id="softDeleteModal" tabindex="-1" role="dialog" aria-labelledby="softDeleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="softDeleteModalLabel">حذف موقت</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                هل أنت متأكد من الحذف الموقت؟
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                                <button type="submit" class="btn btn-warning">حذف</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->



        <!--div-->

    </div>


    <!-- row closed -->

    <!-- Container closed -->

    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
@endsection
