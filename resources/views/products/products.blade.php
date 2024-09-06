@extends('layouts.master')
@section('title', ' قايمة الاقسام')

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
                <h4 class="content-title mb-0 my-auto">الاقسام</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قايمة
                    الاقسام</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <!-- row -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a class="btn ripple btn-primary" data-target="#modaldemo1" data-toggle="modal" href="">اضافه
                            قسم</a>
                    </div>
                    {{--  @if (Session('success'))
                    @error('section_name')
                    <div class="alert alert-danger">{{ Session('success') }}</div>
                    @enderror
                    @endif  --}}

                    @if(session('success'))
                   <div class="alert alert-success">{{ session('success') }}</div>

                    @endif

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" data-page-length="50" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0"> اسم المنتج</th>
                                    <th class="wd-15p border-bottom-0"> اسم القسم</th>
                                    <th class="wd-20p border-bottom-0"> الوصف </th>
                                    <th class="wd-15p border-bottom-0"> العمليات </th>


                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $product)
                                <tr>
                                    <td>{{ $loop->index }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->section->section_name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        <div class="d-inline">
                                            <a class="btn ripple btn-primary" title="edit" href="{{ route('products.edit', $product->id) }}">تعديل</a>


                                                        <a class="btn ripple btn-danger" data-target="#modaldemo3" data-toggle="modal" href="">حذف </a>

                                                        <form method="post" action="{{ route('products.destroy', $product->id) }}" style="display:inline;">
                                                            @csrf
                                                            @method('delete')
                                            <!-- Large Modal -->
                                        <div class="modal" id="modaldemo3">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Large Modal</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6> هل انت متاكد حذف {{ $product->name }}</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn ripple btn-danger" >حذف</button>
                                                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End Large Modal -->

                                        </form>
                                        </div>


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

        <!-- Basic modal -->
        <div class="modal" id="modaldemo1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة القسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <form method="post" action="{{ route('products.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>اسم القسم</label>
                                <input name="name" value="{{ old('name') }}" class="form-control">
                            </div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror




                            <div class="form-group">
                                <label>وصف القسم</label>
                                <select class="form-control" name="section_id">
                                    <option class="form-control">Select Section</option>

                                    @foreach ($sections as $section )
                                    <option class="form-control" value="{{ $section->id }}"> {{ $section->section_name }} </option>
                                    @endforeach

                                </select>
                            </div>
                            @error('section_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label>وصف القسم</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" >حقظ</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                        </div>



                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->






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
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

@endsection
