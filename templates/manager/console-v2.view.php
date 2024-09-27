<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="dot" style="height: 12px; width: 12px; background-color: #22a003; border-radius: 50%;display:inline-block;"></i> <?= htmlentities($server['hostname']) ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/panel">KVacDoor</a></li>
                    <li class="breadcrumb-item"><a href="/servers">Servers</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills d-flex justify-content-center">

                    <li class="nav-item mx-2">
                        <a href="#tab-console" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="fa fa-terminal d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fa fa-terminal"></i> Console</span>
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a href="#tab-execution" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <i class="fa fa-rocket d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fa fa-rocket"></i> Execution</span>
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a href="#tab-players" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="fa fa-users d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fa fa-users"></i> List Of Players</span>
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a href="#tab-statistics" data-toggle="tab" aria-expanded="false" class="nav-link" title="ONLY FOR PREMIUM MEMBERS">
                            <i class="fas fa-chart-line d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fas fa-chart-line"></i> Statistics</span>
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a href="#tab-detection" data-toggle="tab" aria-expanded="false" class="nav-link" title="ONLY FOR PREMIUM MEMBERS">
                            <i class="fas fa-bullseye d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fas fa-bullseye"></i> Detection</span>
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a href="#tab-file-manager" data-toggle="tab" aria-expanded="false" class="nav-link" title="ONLY FOR PREMIUM MEMBERS">
                            <i class="fa fa-folder d-lg-none d-block"></i>
                            <span class="d-none d-lg-block"><i class="fa fa-folder"></i> File Manager</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane show active" id="tab-console">

        <div class="row">
            <div class="col-xl-4 col-md-12">
                <div class="card">

                    <div class="card-body">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr>
                                    <td><strong><i class="fa fa-server"></i> IP</strong></td>
                                    <td class="text-right"><small data-action="ip"><a href="steam://connect/<?= $server['ip'] ?>"><?= $server['ip'] ?></a></small></td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fa fa-users"></i> Slots</strong></td>
                                    <td class="text-right"><small data-action="slots"><?= $server['used_slots'] ?>/<?= $server['max_slots'] ?></small></td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fa fa-map"></i> Map</strong></td>
                                    <td class="text-right"><small data-action="map"><?= $server['map'] ?></small></td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fa fa-gamepad"></i> Gamemode</strong></td>
                                    <td class="text-right"><small data-action="gamemode"><?= $server['gamemode'] ?></small></td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fa fa-terminal"></i> Remote Console</strong></td>
                                    <td class="text-right"><small data-action="rcon"><?= substr($server['rcon'], 0, 32) ?></small></td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fa fa-lock"></i> Server Password</strong></td>
                                    <td class="text-right"><small data-action="password"><?= $server['password'] ?></small></td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fa fa-bug"></i> Uptime</strong></td>
                                    <td class="text-right"><small data-action="uptime"><?= $server['uptime'] ?></small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center my-3">
                        <button data-attr="power" data-action="restart" onclick="$('#restart-modal').modal('show')" class="btn btn-block btn-outline-warning"><i class="fa fa-sync"></i> Restart Server</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="chat-conversation" align="left">
                            <ul id="chat_console" class="conversation-list slimscroll" style="max-height: 328px;">
                                <?php foreach($messages as $message): ?>
                                <li class="clearfix">
                                    <div class="chat-avatar odd">
                                        <img src="<?= $message['avatar'] ?>" />
                                        <i title="<?= $message['created_at'] ?>"><?= substr($message["created_at"], "11") ?></i>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <i><?= $message['username'] ?></i>
                                            <p><?= $message['content'] ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="row">
                                <div class="input-group-prepend">
                                    <button id="actual_state" onclick="consoleStateChange()" class="btn btn-primary waves-effect waves-light" type="button">COMMAND</button>
                                </div>
                                <div class="col">
                                    <input id="command-text" type="text" class="form-control chat-input" placeholder="Execute a command" maxlength="128" />
                                </div>
                                <div class="col-auto">
                                    <button onclick="command();" type="submit" class="btn btn-danger chat-send btn-block waves-effect waves-light">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="tab-execution">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 text-center">
                                <div class="nav flex-column nav-pills nav-pills-tab" id="cat-payload-tab" role="tablist" aria-orientation="vertical">
                                    <?php foreach($categories as $category): ?>
                                    <a class="nav-link show mb-2 <?php if ($category['id'] == 1): ?>active<?php endif; ?>" data-toggle="pill" href="#cat-payload-<?= $category['id'] ?>"><?= $category['name'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-sm-9 chat">
                                <div class="tab-content pt-0">
                                    <?php foreach($categories as $category): ?>
                                    <div class="tab-pane fade <?php if ($category['id'] == 1): ?>active show<?php endif; ?>" id="cat-payload-<?= $category['id'] ?>">
                                        <?php foreach($payloads as $payload): ?>
                                        <?php if($category['id'] == $payload['category']): ?>
                                        <button type="button" onclick="" class="btn btn-block btn--md btn-primary waves-effect waves-light"><?= $payload['name']; ?></button>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="tab-players">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="table-responsive chat">
                            <table class="table table-bordered table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>SteamID64</th>
                                        <th>Group</th>
                                        <th>Kills</th>
                                        <th>Deaths</th>
                                        <th>Ping</th>
                                        <th>IP</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-players">
                                    <?php foreach($players as $player): ?>
                                    <tr>
                                        <th scope="row"><?= $index++ ?></th>
                                        <td><?= htmlentities($player['nick']) ?></td>
                                        <td><?= htmlentities($player['steamid']) ?></td>
                                        <td><?= htmlentities($player['usergroup']) ?></td>
                                        <td><?= htmlentities($player['frags']) ?></td>
                                        <td><?= htmlentities($player['death']) ?></td>
                                        <td><?= htmlentities($player['ping']) ?></td>
                                        <td><?= htmlentities($player['ip']) ?></td>
                                        <td><button class="btn btn-purple btn-sm" onclick="managePlayer('{{ player.steamid }}', this)"><i class="fa fa-wrench"></i> Manage</button></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="tab-statistics">
        {% include 'partials/console343-chat.html.twig' %}
    </div>
    <div class="tab-pane" id="tab-detection">

        <h2>Anticheat enabled</h2>

        <?php if ($detection['anticheat']['snte']): ?>                               
        <div class="alert alert-danger fade show" role="alert">
            <div class="alert-heading">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <b>SNTE</b>
            </div>
            The SNTE anti-cheat is enabled on the server
        </div>
        <?php else: ?>
        <div class="alert alert-success fade show" role="alert">
            <div class="alert-heading">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <b>SNTE</b>
            </div>
            The SNTE anti-cheat has not been detected on the server.
        </div>
        <?php endif; ?>
        <?php if ($detection['anticheat']['cac']): ?>                               
        <div class="alert alert-danger fade show" role="alert">
            <div class="alert-heading">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <b>CAC</b>
            </div>
            The CAC anti-cheat is enabled on the server
        </div>
        <?php else: ?>
        <div class="alert alert-success fade show" role="alert">
            <div class="alert-heading">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <b>CAC</b>
            </div>
            The CAC anti-cheat has not been detected on the server.
        </div>
        <?php endif; ?>

        <hr>

        <h2>Net Exploit</h2>

        <?php foreach($detection['backdoor'] as $backdoor): ?>
        <div class="alert alert-warning fade show" role="alert">
            <div class="alert-heading">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <b><?= $backdoor['name'] ?></b>
            </div>
            <?= $backdoor['filename'] ?><br>
            <code class="bg-dark"><?= str_replace("\n", "<br>", $backdoor['function']) ?></code>
        </div>  
        <?php endforeach; ?>
        <div class="alert alert-info fade show" role="alert">
            <div class="alert-heading">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <b>404 Not Found</b>
            </div>
            No Exploit Found on this server
        </div>
    </div>
    <div class="tab-pane" id="tab-diagnostics">
        {% include 'partials/diagnostics-chat.html.twig' %}
    </div>
    <div class="tab-pane" id="tab-file-manager">
        {% include 'partials/console-cha2.html.twig' %}
    </div>
</div>

<script>

/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.3.8
 *
 */
(function(e){e.fn.extend({slimScroll:function(f){var a=e.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},f);this.each(function(){function v(d){if(r){d=d||window.event;
var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);e(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&n(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function n(d,g,e){k=!1;var f=b.outerHeight()-c.outerHeight();g&&(g=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),g=Math.min(Math.max(g,0),f),g=0<d?Math.ceil(g):Math.floor(g),c.css({top:g+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());g=
l*(b[0].scrollHeight-b.outerHeight());e&&(g=d,d=g/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),f),c.css({top:d+"px"}));b.scrollTop(g);b.trigger("slimscrolling",~~g);w();p()}function x(){u=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),30);c.css({height:u+"px"});var a=u==b.outerHeight()?"none":"block";c.css({display:a})}function w(){x();clearTimeout(B);l==~~l?(k=a.allowPageScroll,C!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;C=l;u>=b.outerHeight()?k=!0:(c.stop(!0,
!0).fadeIn("fast"),a.railVisible&&m.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(B=setTimeout(function(){a.disableFadeOut&&r||y||z||(c.fadeOut("slow"),m.fadeOut("slow"))},1E3))}var r,y,z,B,A,u,l,C,k=!1,b=e(this);if(b.parent().hasClass(a.wrapperClass)){var q=b.scrollTop(),c=b.siblings("."+a.barClass),m=b.siblings("."+a.railClass);x();if(e.isPlainObject(f)){if("height"in f&&"auto"==f.height){b.parent().css("height","auto");b.css("height","auto");var h=b.parent().parent().height();b.parent().css("height",
h);b.css("height",h)}else"height"in f&&(h=f.height,b.parent().css("height",h),b.css("height",h));if("scrollTo"in f)q=parseInt(a.scrollTo);else if("scrollBy"in f)q+=parseInt(a.scrollBy);else if("destroy"in f){c.remove();m.remove();b.unwrap();return}n(q,!1,!0)}}else if(!(e.isPlainObject(f)&&"destroy"in f)){a.height="auto"==a.height?b.parent().height():a.height;q=e("<div></div>").addClass(a.wrapperClass).css({position:"relative",overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",
width:a.width,height:a.height});var m=e("<div></div>").addClass(a.railClass).css({width:a.size,height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=e("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?"block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,
WebkitBorderRadius:a.borderRadius,zIndex:99}),h="right"==a.position?{right:a.distance}:{left:a.distance};m.css(h);c.css(h);b.wrap(q);b.parent().append(c);b.parent().append(m);a.railDraggable&&c.bind("mousedown",function(a){var b=e(document);z=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);n(0,c.position().top,!1)});b.bind("mouseup.slimscroll",function(a){z=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",
function(a){a.stopPropagation();a.preventDefault();return!1});m.hover(function(){w()},function(){p()});c.hover(function(){y=!0},function(){y=!1});b.hover(function(){r=!0;w();p()},function(){r=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(A=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&(n((A-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),A=b.originalEvent.touches[0].pageY)});
x();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),n(0,!0)):"top"!==a.start&&(n(e(a.start).position().top,null,!0),a.alwaysVisible||c.hide());window.addEventListener?(this.addEventListener("DOMMouseScroll",v,!1),this.addEventListener("mousewheel",v,!1)):document.attachEvent("onmousewheel",v)}});return this}});e.fn.extend({slimscroll:e.fn.slimScroll})})(jQuery);

$(".slimscroll").slimScroll({ height: "auto", position: "right", size: "8px", touchScrollStep: 20, color: "#9ea5ab" });
</script>