<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-star-half-alt"></i> <?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/overview">KVacDoor</a></li>
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
                    <img src="/assets/img/banner/steam-resolver.png" style="width: 90%;" class="img-fluid img-thumbnail img-circle" alt="KvacDoor">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h5>Steam Resolver - Lifetime Subscription</h5>
                <div class="ecommerce-details-price d-flex flex-wrap">

                    <p class="text-primary font-medium-3 mr-1 mb-0">£80.00</p>
                </div>
                <hr>
                <p class="mb-0">The steam resolver is a database of over <b>1,000,000+ garry's mod players.</b></p>
                <ul class="mb-0">
                    <li>You can find the information of a player by searching his steam name, steamid 32 or 64 or steam profile URL.</li>
                    <li>You will be able to access different information such as IP address, location and some additional information.</li>
                </ul>
                <b>After purchase the activation is instantaneous.</b></p>
                <hr>
                <p>Availability - <span class="text-success">In stock</span></p>
                <hr>
                <img src="/assets/img/payment/list.png" alt="Payment Method" style="max-width:200px;">
                <hr>

                <div class="d-flex flex-column flex-sm-row">
                    <a href="/external?url=https%3A%2F%2Fshoppy.gg%2Fproduct%2FazrSwuc" target="_blank">
                        <button class="btn btn-success btn-sm mr-0 mr-sm-1 mb-1 mb-sm-0"><i class="fa fa-shopping-cart mr-25"></i> Buy Now</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!-- <div class="item-features py-5">
        <div class="row text-center pt-2">
            <div class="col-12 col-md-4 mb-4 mb-md-0 ">
                <div class="w-75 mx-auto">
                    <h1><i class="fa fa-blind text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">Lua Scanner</h5>
                    <p>Quickly find flaws and exploits in your garry's mod addons.</p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <div class="w-75 mx-auto">
                    <h1><i class="fab fa-accessible-icon text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">Smart Lua</h5>
                    <p>Inject your lua codes discreetly in one click in one of your addons with the Smart Lua tool.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <div class="w-75 mx-auto">
                    <h1><i class="fa fa-code text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">Obfuscateur</h5>
                    <p>Thanks to the obfuscator make any lua code totally unreadable
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="item-features py-5">
        <div class="row text-center pt-2">
            <div class="col-12 col-md-4 mb-4 mb-md-0 ">
                <div class="w-75 mx-auto">
                    <h1><i class="fa fa-history text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">History</h5>
                    <p>This access allows you to manage all your servers, so you can share them with your friends or reconnect them in case of disconnection on the panel!</p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <div class="w-75 mx-auto">
                    <h1><i class="fa fa-download text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">FileSteal FTP</h5>
                    <p>Make a backup of your garry's mod servers in one click and download it directly from your KVacDoor administration space.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <div class="w-75 mx-auto">
                    <h1><i class="fa fa-camera text-warning"></i></h1>
                    <h5 class="mt-2 font-weight-bold">Vidéos & Screenshots</h5>
                    <p>Make videos and screenshots of connected players in real time!
                    </p>
                </div>
            </div>
        </div>
    </div> -->
    <hr>
    <div class="card-body">
        <div class="mt-4 mb-2 text-center">
            <h2>A PROBLEM ?</h2>
            <h5>Do not hesitate to contact <u><a href="#">@WaDixix#1337</a></u> or <u><a href="#">@Alex.#7331</a></u> for more information. </h5>
        </div>
    </div>
<?php
        Logs::AddLogs(
        "User ".$AUTHUSER['username']." visited the steam resolver market page.", 
        "warning", 
        "fa fa-shopping-cart"
    );
?>
</div>