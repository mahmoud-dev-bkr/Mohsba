@extends('layouts.vertical', ['title' => 'اضافة عميلء'])
@section('content')
      <div class="container-fluid">
            <section id="content-wrapper" class="content-header">
               <div class="row">
                  <div class="col-lg-12 mt-3">
                     <ul class="d-flex align-content-center">
                        <li><span  class="text-dark ml-3">المبيعات</span></li>
                        <li class="text-dark">
                           <i class="fa fa-angle-double-left mx-2 "></i><a href="clients.html">العملاء</a>
                        </li>
                        <li class="text-primary">
                           <i class="fa fa-angle-double-left mx-2 "></i><a href="add-client.html">اضافة عميل</a>
                        </li>
                     </ul>
                  </div>
               </div>
            </section>
            <section>
               <div class="d-flex justify-content-sm-end mx-5">
                  <button class="btn btn-primary mx-2"> <a href="{{ route('client.index') }}" class="text-light">رجوع</a></button>
               </div>
               <div class="container my-3">
                  <div class="row">
                    @if(session()->has('message'))
                    {{dd('vbnm')}}
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                     <div class="col-md-12 hi-mohasba">
                        <h4 class="mx-4">اضافة عميل</h4>
                     </div>
                  </div>
                  <div class="row bg-light pb-4 brdr">
                     <div class="col-md-6 ">
                        <div class="form my-5">
                           <form action="{{ route('client.create.post') }}" method="post">
                            @csrf
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">اسم العميل</label><input name="name" type="text"  class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">رقم الاتصال الأساسي</label><input name="phon" type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">رقم الاتصال الثانوي</label><input name="phon2" type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">البريد الإلكتروني الأساسي</label><input name="email" type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">البريد الإلكتروني الثانوي</label><input name="email2" type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">اسم المنشأة</label><input name="Facility" type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">الموقع الالكتروني</label><input name="webName" type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">الرقم الضريبي</label><input name="Tex_Number" type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">الحالة</label>
                                 <select class="form-control w-75" name="status" id="">
                                    <optgroup>
                                       <option value="1">نشط</option>
                                       <option value="0">غير نشط</option>
                                    </optgroup>
                                 </select>
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">عميل نقاط بيع</label><input name="pointsClient" type="checkbox" class=" m-auto my-2">
                              </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-5 ">
                                <div class="mb-3">
                                    <div class="sub-head"><h5 class="mx-4">عنوان الفوترة</h5></div>
                                    <div class="fatora">
                                        <input placeholder="اسم الشارع" type="text" class="form-control sub-width m-auto my-2">
                                        <div class="d-flex ">
                                            <input placeholder="مدينة" type="text" class="form-control inp-width  my-2">
                                            <input placeholder="منطقة" type="text" class="form-control inp-width my-2">
                                        </div>
                                        <div class="d-flex ">
                                            <input placeholder="الرمز البريدي" type="text" class="form-control inp-width  my-2">
                                            <input placeholder="رقم المبني" type="text" class="form-control inp-width my-2">
                                        </div>
                                        <select aria-placeholder="hi" class="form-control sub-width m-auto" name="" id="">
                                            <optgroup>
                                                <option value="">مصر</option>
                                                <option value="">سوريا</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="sub-head"><h5 class="mx-4">عنوان الشحن </h5></div>
                                    <div class="fatora">
                                        <div class="d-flex">
                                            <input type="checkbox" class=" mx-5  my-2"> <span class="bold"> نسخ عنوان الفوترة</span>
                                        </div>
                                        <input placeholder="اسم الشارع" type="text" class="form-control sub-width m-auto my-2">
                                        <div class="d-flex ">
                                            <input placeholder="مدينة" type="text" class="form-control inp-width  my-2">
                                            <input placeholder="منطقة" type="text" class="form-control inp-width my-2">
                                        </div>
                                        <div class="d-flex ">
                                            <input placeholder="الرمز البريدي" type="text" class="form-control inp-width  my-2">
                                        </div>
                                        <select aria-placeholder="hi" class="form-control sub-width m-auto" name="" id="">
                                            <optgroup>
                                            <option value="">مصر</option>
                                            <option value="">سوريا</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 add-sub">
                                <h5 class="text-primary">المرفقات</h5>
                                <div class="d-flex align-content-center justify-content-center text-center">
                                    <div>
                                        <button class="btn btn-light">تصفح ملفاتك</button>
                                        <h5 class="my-3">او</h5>
                                        <h5>قم بسحب الملفات مباشرة هنا</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-holder">
                                <button class="btn btn-primary submit">حفظ</button> <button class="btn btn-dark re-submit">اعادة تعيين</button>
                            </div>
                    </form>
                  </div>
               </div>
            </section>
      </div>
@endsection

