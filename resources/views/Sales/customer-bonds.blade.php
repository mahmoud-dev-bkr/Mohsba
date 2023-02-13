@extends('layouts.vertical', ['title' => 'سندات العملاء'])
@section('content')
<div class="container-fluid">
       <section id="content-wrapper" class="content-header">
          <div class="row">
             <div class="col-lg-12 mt-3">
                <ul class="d-flex align-content-center">
                   <li><span  class="text-dark ml-3">المبيعات</span></li>
                   <li class="text-primary">
                      <i class="fa fa-angle-double-left mx-2 "></i><a href="customer-bonds.html"> سندات العملاء</a>
                   </li>
                </ul>
             </div>
          </div>
       </section>
       <section>
          <div class="d-flex justify-content-sm-end mx-5">
             <button class="btn btn-primary mx-2"> جميع السندات  </button>
             <button class="btn btn-primary mx-2">    سندات الموردين  </button>
             <button class="btn btn-primary mx-2"> سندات العملاء  </button>
             <button class="btn btn-primary mx-2">   تصدير  </button>
             <button class="btn btn-primary mx-2">    <a href="add-bonds.html" class="text-light"> انشاء سند عميل</a> <i class="fa-solid fa-plus mx-1"></i> </button>
          </div>
          <div class="container my-3">
             <div class="row">
                <div class="col-md-12 hi-mohasba">
                   <h4 class="mx-4"> سندات العملاء</h4>
                </div>
             </div>
             <div class="row bg-light pb-4 brdr">
                <div class="col-md-12 clients ">
                   <div>
                      <img src="images/sandat.svg"  alt="">
                      <h1 class="my-3">ليس لديك أي سندات عملاء</h1>
                      <p class="text-secondary my-4 ">يتيح لك قيود عمل فاتورة دفع للعميل لإثبات المبلغ الذي دفعه العميل لأجل عملية بيع.</p>
                      <button class="btn btn-primary mx-2"> تصدير  </button><button class="btn btn-primary mx-2">  <a href="add-bonds.html" class="text-light"> انشاء سند عميل</a>  <i class="fa-solid fa-plus"></i></button>
                   </div>
                </div>
             </div>
          </div>
       </section>
 </div>
@endsection
@section('script')
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
      <script src="{{ URL('js/main.js') }}"></script>
@endsection
