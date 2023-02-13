<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>   إنشاء فاتورة مبيعات </title>
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/all.min.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
         rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <div class="container-fluid">
         <div   id="wrapper">
            <aside id="sidebar-wrapper">
               <div class="sidebar-brand">
                  <img id="sideImg" src="images/LOGO ARABIC AND ENGLISH.png" alt="">
               </div>
               <ul class="sidebar-nav">
                  <li >
                     <a href="dashboard.html"><i class="fa-solid fa-gauge-high side-icon"></i><span class="mx-4">لوحةالمتابعة</span></a>
                  </li>
                  <li>
                     <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                     <i class="fa-solid fa-sack-dollar side-icon"></i><span class="ms-1 d-none d-sm-inline toggle-span">المبيعات</a>
                     <ul class="collapse  nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                        <li class="w-100">
                           <a href="clients.html" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-users users-icon "></i>  العملاء</span>
                                 <span>
                           <a href="add-client.html"><i class="fa-solid fa-plus plus"></i></a></span></div> </a>
                        </li>
                        <li >
                           <a href="quotations.html" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-file-contract"></i>  عروض الأسعار</span>
                                 <span>
                           <a href="add-quotation.html"><i class="fa-solid fa-plus plus"></i></a></span></div> </a>
                        </li>
                        <li >
                           <a href="Sales-invoices.html" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-file-invoice-dollar"></i>  فواتير المبيعات</span>
                                 <span>
                           <a href="add-sales-bill.html"><i class="fa-solid fa-plus plus"></i></a></span></div> </a>
                        </li>
                        <li >
                           <a href="customer-bonds.html" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-file-lines"></i>   سندات العملاء </span>
                                 <span>
                           <a href="add-bonds.html"><i class="fa-solid fa-plus plus"></i></a></span></div> </a>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                     <i class="fa-solid fa-cart-shopping side-icon"></i><span class="ms-1 d-none d-sm-inline toggle-span">المشتريات </a>
                     <ul class="collapse  nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                        <li class="w-100">
                           <a href="#" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-handshake"></i>  الموردين</span>
                                 <span><i class="fa-solid fa-plus plus"></i></span>
                              </div>
                           </a>
                        </li>
                        <li >
                           <a href="#" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-file-circle-check"></i>   أوامر الشراء</span>
                                 <span><i class="fa-solid fa-plus plus"></i></span>
                              </div>
                           </a>
                        </li>
                        <li >
                           <a href="#" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-money-bill-wheat"></i>فواتير المشتريات</span>
                                 <span><i class="fa-solid fa-plus plus"></i></span>
                              </div>
                           </a>
                        </li>
                        <li >
                           <a href="#" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-file-lines"></i>   سندات الموردين </span>
                                 <span><i class="fa-solid fa-plus plus"></i></span>
                              </div>
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                     <i class="fa-solid fa-table-cells side-icon"></i><span class="ms-1 d-none d-sm-inline toggle-span">المنتجات والتكاليف</a>
                     <ul class="collapse  nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                        <li class="w-100">
                           <a href="#" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-box-open"></i>المنتجات والتكاليف</span>
                                 <span><i class="fa-solid fa-plus plus"></i></span>
                              </div>
                           </a>
                        </li>
                        <li >
                           <a href="#" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-location-arrow"></i>المواقع</span>
                                 <span><i class="fa-solid fa-plus plus"></i></span>
                              </div>
                           </a>
                        </li>
                        <li >
                           <a href="#" class="nav-link px-0">
                              <div class="space"><span class="d-none d-sm-inline text">
                                 <i class="fa-solid fa-boxes-stacked"></i> أوامر التصنيع</span>
                                 <span><i class="fa-solid fa-plus plus"></i></span>
                              </div>
                           </a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </aside>
            <div id="navbar-wrapper">
               <nav class="navbar navbar-expand-lg bg-body-tertiary ">
                  <div class="container-fluid nav-content">
                     <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a> <a class="navbar-brand" href="#">  مرحبا بك  <span class="heading">اسم المستخدم</span>  في <span class="heading">اسم الشركة</span></a>
                     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                           <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-list-ul"></i></a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="#"><i class="fa-regular fa-comment-dots"></i></a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="#"><i class="fa-solid fa-circle-dot"></i></a>
                           </li>
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-house-chimney"></i>
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">Action</a></li>
                                 <li><a class="dropdown-item" href="#">Another action</a></li>
                                 <li>
                                    <hr class="dropdown-divider">
                                 </li>
                                 <li><a class="dropdown-item" href="#">Something else here</a></li>
                              </ul>
                           </li>
                        </ul>
                     </div>
                  </div>
               </nav>
            </div>
            <section id="content-wrapper" class="content-header">
               <div class="row">
                  <div class="col-lg-12 mt-3">
                     <ul class="d-flex align-content-center">
                        <li><span  class="text-dark ml-3">المبيعات</span></li>
                        <li class="text-dark">
                           <i class="fa fa-angle-double-left mx-2 "></i><a href="Sales-invoices.html"> فواتير مبيعات</a>
                        </li>
                        <li class="text-primary">
                           <i class="fa fa-angle-double-left mx-2 "></i><a href="add-sales-bill.html"> إنشاء فاتورة مبيعات </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </section>
            <section>
               <div class="d-flex justify-content-sm-end mx-5">
                  <button class="btn btn-primary mx-2"> <a href="customer-bonds.html" class="text-light">رجوع</a></button>
               </div>
               <div class="container my-3">
                  <div class="row">
                     <div class="col-md-12 hi-mohasba">
                        <h4 class="mx-4"> إنشاء سند عميل</h4>
                     </div>
                  </div>
                  <div class="row bg-light pb-4 brdr">
                     <form action="" method="post">
                        <div class="col-md-6 ">
                           <div class="form my-5">
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">  المرجع</label><input type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">  العميل </label><input type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5"> تاريخ الإصدار</label><input type="date" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between my-3">
                                 <label class="mt-3 ml-5">شروط الدفع</label>
                                 <select class="form-control w-75" name="" id="">
                                    <optgroup>
                                       <option value="">1</option>
                                       <option value=""> 2</option>
                                    </optgroup>
                                 </select>
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5">الوصف</label><input type="text" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5"> تاريخ الاستحقاق </label><input type="date" class="form-control w-75 my-2">
                              </div>
                              <div class="d-flex align-content-center justify-content-sm-between">
                                 <label class="mt-3 ml-5"> تاريخ التوريد  </label><input type="date" class="form-control w-75 my-2">
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 mt-5 ">
                           <div class="mb-3">
                              <div class="sub-head">
                                 <h5 class="mx-4"> تفاصيل بيانات العميل </h5>
                              </div>
                              <div class="fatora d-flex justify-content-around">
                                 <div>
                                    <h5>الاسم</h5>
                                    <h5>الهاتف</h5>
                                    <h5>البريد الإلكتروني</h5>
                                    <h5>الرقم الضريبي</h5>
                                 </div>
                                 <div class="text-secondary">
                                    <h5>احمد</h5>
                                    <h5>01112345125</h5>
                                    <h5> ahmed123@gmail.com</h5>
                                    <h5> 5504</h5>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div >
                           <table class="table text-center">
                              <thead class="table-head">
                                 <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">المنتج</th>
                                    <th scope="col">الوصف </th>
                                    <th scope="col">الكمية </th>
                                    <th scope="col">سعر الوحدة </th>
                                    <th scope="col">شامل؟</th>
                                    <th scope="col">الخصم</th>
                                    <th scope="col">الاجمالي قبل الضريبة </th>
                                    <th scope="col">الضريبة %</th>
                                    <th scope="col">قيمة الضريبة </th>
                                    <th scope="col">القيمة </th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>Mark</td>
                                 </tr>
                              </tbody>
                           </table>
                           <button class="btn btn-primary">اضافةالمزيد</button>
                        </div>
                        <div class="col-md-8 my-3"></div>
                        <div class="col-md-4 my-3 calc d-flex justify-content-around align-content-center ">
                           <div class="text-primary">
                              <h2><span>الاجمالي قبل الضريبة</span></h2>
                              <h2><span>قيمة الضريبة</span></h2>
                              <h2><span>المجموع</span></h2>
                           </div>
                           <div>
                              <h2><span>00.00</span> </h2>
                              <h2><span>00.00</span> </h2>
                              <h2><span>00.00</span> </h2>
                           </div>
                        </div>
                        <div>
                           <div class="accordion accordion-flush" id="accordionFlushExample">
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    الشروط والأحكام
                                    </button>
                                 </h2>
                                 <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    ملاحظات
                                    </button>
                                 </h2>
                                 <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    السندات
                                    </button>
                                 </h2>
                                 <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                       <div class="form my-5">
                                          <div class="d-flex align-content-center justify-content-sm-between">
                                             <label class="mt-3 ml-5"> رقم المرجع</label><input type="text" class="form-control w-75 my-2">
                                          </div>
                                          <div class="d-flex align-content-center justify-content-sm-between my-3">
                                             <label class="mt-3 ml-5">الجهة</label>
                                             <select class="form-control w-75" name="" id="">
                                                <optgroup>
                                                   <option value="">1</option>
                                                   <option value=""> 2</option>
                                                </optgroup>
                                             </select>
                                          </div>
                                          <div class="d-flex align-content-center justify-content-sm-between my-3">
                                             <label class="mt-3 ml-5">الحساب</label>
                                             <select class="form-control w-75" name="" id="">
                                                <optgroup>
                                                   <option value="">1</option>
                                                   <option value="">2 </option>
                                                </optgroup>
                                             </select>
                                          </div>
                                          <div class="d-flex align-content-center justify-content-sm-between my-3">
                                             <label class="mt-3 ml-5">النوع</label>
                                             <select class="form-control w-75" name="" id="">
                                                <optgroup>
                                                   <option value="">1</option>
                                                   <option value=""> 2</option>
                                                </optgroup>
                                             </select>
                                          </div>
                                          <div class="d-flex align-content-center justify-content-sm-between">
                                             <label class="mt-3 ml-5">الوصف</label><input type="text" class="form-control w-75 my-2">
                                          </div>
                                          <div class="d-flex align-content-center justify-content-sm-between">
                                             <label class="mt-3 ml-5"> التاريخ</label><input type="date" class="form-control w-75 my-2">
                                          </div>
                                          <div class="d-flex align-content-center justify-content-sm-between">
                                             <label class="mt-3 ml-5">تخصيص السند تلقائيًا حسب أقدمية الفواتير</label><input type="checkbox" class=" m-auto my-2">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseThree">
                                    المرفقات
                                    </button>
                                 </h2>
                                 <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
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
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseOne">
                                    معلومات إضافية
                                    </button>
                                 </h2>
                                 <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                       <label class="mx-4">إضافة إلى</label><input type="radio"> مشروع   <input type="radio"> مهمة
                                       <br>
                                       <div class="d-flex align-content-center justify-content-sm-between my-3">
                                          <label class="mt-3 ml-5">إضافة مشروع/ مهمة</label>
                                          <select class="form-control w-75" name="" id="">
                                             <optgroup>
                                                <option value="">1</option>
                                                <option value=""> 2</option>
                                             </optgroup>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="btn-holder">
                           <button class="btn btn-primary submit">حفظ وموافقة</button> <button class="btn btn-dark re-submit">حفظ كمسودة</button>
                        </div>
                     </form>
                  </div>
               </div>
            </section>
         </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
      <script src="js/main.js"></script>
   </body>
</html>
