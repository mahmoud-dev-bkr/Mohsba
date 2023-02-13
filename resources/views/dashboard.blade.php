<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>لوحة المتابعة</title>
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
                                <li><span  class="text-dark ml-3">الصفحة الرئيسية</span></li>
                                <li class="text-primary">
                                    <i class="fa fa-angle-double-left mx-2 "></i><a href="dashboard.html">لوحةالمتابعة</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="container my-3">
                        <div class="row">
                            <div class="col-md-12 hi-mohasba">
                                <h4 class="mx-4">مرحبا بك في محاسبة</h4>
                            </div>
                        </div>
                        <div class="row bg-light pb-4 brdr">
                            <div class="col-md-6">
                                <div class="my-3">
                                    <h5>خطوات عامة</h5>
                                    <p class="text-secondary">(هذه الخطوات هي لمساعدتك لتبدأ باستخدام قيود)</p>
                                </div>
                                <div>
                                    <ul class="mohasba-list">
                                        <li><i class="fa-solid fa-box-open"></i> <a href="">ليس لديك أي منتجات، اضغط هنا لإضافة منتج</a></li>
                                        <li><i class="fa-solid fa-users users-icon "></i> <a href="">ليس لديك أي عملاء، اضغط هنا لإضافة عميل</a></li>
                                        <li><i class="fa-solid fa-handshake-simple"></i> <a href="">ليس لديك أي موردين، اضغط هنا لإضافة مورد</a></li>
                                        <li><i class="fa-solid fa-file-circle-check"></i> <a href="">ليس لديك أي فواتير مشتريات، اضغط هنا لإضافة فاتورة مشتريات</a></li>
                                        <li><i class="fa-solid fa-file-invoice-dollar"></i> <a href="">ليس لديك أي فواتير مبيعات، اضغط هنا لإضافة فاتورة مبيعات</a></li>
                                        <li><i class="fa-solid fa-location-arrow"></i> <a href="">لديك 1 مواقع. اضغط هنا لإضافة المزيد</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="my-3">
                                    <h5>خطوات متقدمة</h5>
                                    <p class="text-secondary">(هذه الخطوات هي للمستخدمين الذين لديهم خبرة محاسبية)</p>
                                </div>
                                <div>
                                    <ul class="mohasba-list">
                                        <li><i class="fa-solid fa-chart-column"></i> <a href="">اضغط هنا لإضافة حساب </a></li>
                                        <li><i class="fa-solid fa-receipt"></i> <a href="">اضغط هنا لإضافة رصيد افتتاحي</a></li>
                                    </ul>
                                </div>
                            </div>
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