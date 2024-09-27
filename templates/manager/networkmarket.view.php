<style>
    .card-pricing{position:relative;border-radius:10px}.card-pricing .card-pricing-icon{font-size:22px;-webkit-box-shadow:0 1px 2px rgba(0,0,0,0.075);box-shadow:0 1px 2px rgba(0,0,0,0.075);height:60px;display:inline-block;width:60px;line-height:62px;border-radius:50%}.card-pricing .card-pricing-features{color:#bbb;list-style:none;margin:0;padding:20px 0 0 0}.card-pricing .card-pricing-features li{padding:15px}
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-star-half-alt"></i> <?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/overview">KVacDoor</a></li>
                    <li class="breadcrumb-item"><a href="/market">Market</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-5 mt-2">
            <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                <div class="d-flex align-items-center justify-content-center">
                    <img src="/assets/img/banner/network-access.png" style="width: 90%;" class="img-fluid img-thumbnail img-circle" alt="KvacDoor">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h5>Network Access - 1 Month</h5>
                <div class="ecommerce-details-price d-flex flex-wrap">

                    <p class="text-primary font-medium-3 mr-1 mb-0">Starting at £20.00</p>
                </div>
                <hr>
                <p>With KVacDoor Network, You can interrupt any connection in 1 click
                <br><b>After purchase the activation is instantaneous.</b></p>
                <hr>
                <p>Availability - <span class="text-success">In stock</span></p>
                <hr>
                <img src="/assets/img/payment/list.png" alt="Payment Method" style="max-width:200px;">
                <hr>
            </div>
        </div>
    </div>
    <hr>
    <div class="item-features">
        <div class="row text-center pt-2">
            <div class="col-12 col-md-6 mb-4">
                <div class="w-75 mx-auto">
                    <h1><i class="fa fa-globe text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">Private Network</h5>
                    <p>A network designed and developed for online gaming attacks</p>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4">
                <div class="w-75 mx-auto">
                    <h1><i class="fa fa-check-circle text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">Custom Methods</h5>
                    <p>Methods designed to take down specific providers, together focused on games.</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="card-body">
        <div class="mt-4 mb-2 text-center">
            <h2>A PROBLEM ?</h2>
            <h5>Do not hesitate to contact <u><a href="#">@WaDixix#1337</a></u> or <u><a href="#">@Alex.#7331</a></u> for more information. </h5>
        </div>
    </div>
<?php
    Logs::AddLogs(
    "User ".$AUTHUSER['username']." visited the network access market page.", 
    "warning", 
    "fa fa-shopping-cart"
    );
?>
</div>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <!-- Plans -->
        <div class="row">

            <div class="col-lg-6 col-xl-3 col-md-12 col-sm-12">
                <div class="card card-pricing">
                    <div class="card-body text-center">
                        <i class="card-pricing-icon fa fa-star-half-alt text-primary"></i>
                        <h5 class="font-weight-bold mt-4 text-uppercase">Bronze</h5>

                        <ul class="card-pricing-features">
                            <li>1 Concurrent ✅</li>
                            <li>300 Seconds ✅</li>
                            <li>Layer 4 Methods ✅</li>
                            <li>Layer 7 Methods ✅</li>
                            <li>Gaming Methods ❌</li>
                            <li>Hosting Methods ❌</li>
                            <li>Bypass Methods (Cloudflare) ❌</li>
                            <li>Nuke Methods ❌</li>
                            <li>API Access ❌</li>
                        </ul>

                        <h2 class="mt-4">£20</h2>
                        <p class="text-muted">1 Month</p>
                        <a href="/external?url=https%3A%2F%2Fshoppy.gg%2Fproduct%2FjTcICbH" class="btn btn-primary mt-4 mb-2 btn-rounded waves-effect waves-light">Get Started <i class="mdi mdi-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- end Pricing_card -->
            </div>
            <!-- end col -->
            <div class="col-lg-6 col-xl-3 col-md-12 col-sm-12">
                <div class="card card-pricing">
                    <div class="card-body text-center">
                        <i class="card-pricing-icon fa fa-star-half-alt text-primary"></i>
                        <h5 class="font-weight-bold mt-4 text-uppercase">Silver</h5>

                        <ul class="card-pricing-features">
                            <li>3 Concurrent ✅</li>
                            <li>600 Seconds ✅</li>
                            <li>Layer 4 Methods ✅</li>
                            <li>Layer 7 Methods ✅</li>
                            <li>Gaming Methods ✅</li>
                            <li>Hosting Methods ✅</li>
                            <li>Bypass Methods (Cloudflare) ❌</li>
                            <li>Nuke Methods ❌</li>
                            <li>API Access ❌</li>
                        </ul>

                        <h2 class="mt-4">£40</h2>
                        <p class="text-muted">1 Month</p>
                        <a href="/external?url=https%3A%2F%2Fshoppy.gg%2Fproduct%2F305eVeK" class="btn btn-primary mt-4 mb-2 btn-rounded waves-effect waves-light">Get Started <i class="mdi mdi-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- end Pricing_card -->
            </div>
            <!-- end col -->

            <div class="col-lg-6 col-xl-3 col-md-12 col-sm-12">
                <div class="card card-pricing">
                    <div class="card-body text-center">
                        <i class="card-pricing-icon fa fa-star-half-alt text-primary"></i>
                        <h5 class="font-weight-bold mt-4 text-uppercase">Gold</h5>

                        <ul class="card-pricing-features">
                            <li>8 Concurrent ✅</li>
                            <li>1200 Seconds ✅</li>
                            <li>Layer 4 Methods ✅</li>
                            <li>Layer 7 Methods ✅</li>
                            <li>Gaming Methods ✅</li>
                            <li>Hosting Methods ✅</li>
                            <li>Bypass Methods (Cloudflare)✅</li>
                            <li>Nuke Methods (200Gbps) ✅</li>
                            <li>API Access ✅</li>
                        </ul>

                        <h2 class="mt-4">£70</h2>
                        <p class="text-muted">1 Month</p>
                        <a href="/external?url=https%3A%2F%2Fshoppy.gg%2Fproduct%2F305eVeK" disabled="disabled" class="btn btn-primary disabled mt-4 mb-2 btn-rounded waves-effect waves-light">Soon <i class="mdi mdi-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- end Pricing_card -->
            </div>

            <div class="col-lg-6 col-xl-3 col-md-12 col-sm-12">
                <div class="card card-pricing">
                    <div class="card-body text-center">
                        <i class="card-pricing-icon fa fa-star-half-alt text-primary"></i>
                        <h5 class="font-weight-bold mt-4 text-uppercase">Enterprise</h5>

                        <ul class="card-pricing-features">
                            <li>25 Concurrent ✅</li>
                            <li>Unlimited Seconds ✅</li>
                            <li>Layer 4 Methods ✅</li>
                            <li>Layer 7 Methods ✅</li>
                            <li>Gaming Methods ✅</li>
                            <li>Hosting Methods ✅</li>
                            <li>Bypass Methods (Cloudflare)✅</li>
                            <li>Nuke Methods (+500Gbps) ✅</li>
                            <li>API Access ✅</li>
                        </ul>

                        <h2 class="mt-4">£800</h2>
                        <p class="text-muted">Lifetime</p>
                        <a href="/external?url=https%3A%2F%2Fshoppy.gg%2Fproduct%2F305eVeK" disabled="disabled" class="btn btn-primary disabled mt-4 mb-2 btn-rounded waves-effect waves-light">Soon <i class="mdi mdi-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- end Pricing_card -->
            </div>

        </div>
        <!-- end row -->
    </div>
    <!-- end col-->
</div>