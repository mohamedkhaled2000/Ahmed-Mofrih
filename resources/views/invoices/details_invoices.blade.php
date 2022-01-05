@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل فاتورة
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
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


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
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
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a>
                                            </li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                        <tr>

                                                            <th class="border-bottom-0">رقم الفاتورة</th>
                                                            <th class="border-bottom-0">تاريخ القاتورة</th>
                                                            <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                            <th class="border-bottom-0">المنتج</th>
                                                            <th class="border-bottom-0">القسم</th>
                                                            <th class="border-bottom-0">مبلغ التحصيل</th>
                                                            <th class="border-bottom-0">مبلغ العمولة</th>
                                                            <th class="border-bottom-0">الخصم</th>
                                                            <th class="border-bottom-0">قيمة الضريبة</th>
                                                            <th class="border-bottom-0">نسبة الضريبة</th>
                                                            <th class="border-bottom-0">الاجمالي</th>
                                                            <th class="border-bottom-0">الحالة</th>
                                                            <th class="border-bottom-0">ملاحظات</th>
                                                        </tr>
                                                        </thead>
                                                    <tbody>




                                                        <tr>

                                                            <td>{{ $invoices->invoice_number }}</td>

                                                            <td>{{ $invoices->invoice_Date }}</td>

                                                            <td>{{ $invoices->Due_date }}</td>
                                                            <td>{{ $invoices->product }}</td>
                                                            <td>

                                                                {{ $invoices->section->section_name }}
                                                            </td>
                                                            <td>{{ $invoices->Amount_collection }}</td>
                                                            <td>{{ $invoices->Amount_Commission }}</td>
                                                            <td>{{ $invoices->Discount }}</td>
                                                            <td>{{ $invoices->Value_VAT }}</td>
                                                            <td> {{ $invoices->Rate_VAT }} </td>
                                                            <td>{{ $invoices->Total }}</td>

                                                            <td>

                                                                @if ($invoices->Value_Status == 1)

                                                                    <span
                                                                        class="badge badge-pill badge-success">{{ $invoices->Status }}</span>

                                                                @elseif($invoices->Value_Status == 3)

                                                                    <span
                                                                        class="badge badge-pill badge-danger">{{ $invoices->Status }}</span>

                                                                @else

                                                                    <span
                                                                        class="badge badge-pill badge-warning">{{ $invoices->Status }}</span>

                                                                @endif
                                                            </td>

                                                            <td>{{ $invoices->note }}</td>

                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr>
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

                                                        @php
                                                            $i = 0;
                                                        @endphp
                                                        @foreach ($details as $X)

                                                            @php
                                                                $i++;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $X->invoice_number }}</td>

                                                                <td>{{ $X->product }}</td>

                                                                <td>{{ $X->section->section_name }}</td>
                                                                <td>

                                                                    @if ($X->Value_Status == 1)

                                                                        <span
                                                                            class="badge badge-pill badge-success">{{ $X->Status }}</span>

                                                                    @elseif($X->Value_Status == 3)

                                                                        <span
                                                                            class="badge badge-pill badge-danger">{{ $X->Status }}</span>

                                                                    @else

                                                                        <span
                                                                            class="badge badge-pill badge-warning">{{ $X->Status }}</span>

                                                                    @endif
                                                                </td>
                                                                <td>{{ $X->Payment_Date }}</td>
                                                                <td>{{ $X->note }}</td>
                                                                <td>{{ $X->created_at }}</td>
                                                                <td>{{ $X->user }}</td>







                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">

                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                        enctype="multipart/form-data">
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

                                                <br>

                                                <div class="tab-pane" id="tab3">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="example1" class="table key-buttons text-md-nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="border-bottom-0">#</th>
                                                                        <th class="border-bottom-0">اسم الملف</th>
                                                                        <th class="border-bottom-0">قام الاضافه </th>
                                                                        <th class="border-bottom-0">تاريخ لاضافه</th>
                                                                        <th class="border-bottom-0">العمليات</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $i = 0;
                                                                    @endphp

                                                                    @foreach ($attachments as $y)

                                                                        @php
                                                                            $i++;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $i }}</td>
                                                                            <td>{{ $y->file_name }}</td>
                                                                            <td>{{ $y->Created_by }}</td>
                                                                            <td>{{ $y->created_at }}</td>
                                                                            <td>

                                                                                <a class="btn btn-outline-success btn-sm"
                                                                                    href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $y->file_name }}"
                                                                                    role="button"><i
                                                                                        class="fas fa-eye"></i>&nbsp;
                                                                                    عرض</a>

                                                                                <a class="btn btn-outline-info btn-sm"
                                                                                    href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $y->file_name }}"
                                                                                    role="button"><i
                                                                                        class="fas fa-download"></i>&nbsp;
                                                                                    تحميل</a>


                                                                                <button
                                                                                    class="btn btn-outline-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-file_name="{{ $y->file_name }}"
                                                                                    data-invoice_number="{{ $y->invoice_number }}"
                                                                                    data-id_file="{{ $y->id }}"
                                                                                    data-target="#delete_file">حذف</button>


                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
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
                    </div>
                    <!-- /div -->
                </div>

            </div>
            <!-- /row -->

            <!-- delete -->
            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('delete_file') }}" method="post">

                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p class="text-center">
                                <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                </p>

                                <input type="hidden" name="id_file" id="id_file" value="">
                                <input type="hidden" name="file_name" id="file_name" value="">
                                <input type="hidden" name="invoice_number" id="invoice_number" value="">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
