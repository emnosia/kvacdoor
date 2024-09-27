<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-rocket"></i> <?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/panel">KVacDoor</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-success float-right mb-4" onclick="create_payload_pnl()"><i class="fa fa-plus" aria-hidden="true"></i> Create New Payload</button>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Content</th>
                            <th scope="col">Execution</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="payload-tbl">
                        <?php foreach ($payloads as $payload): ?>
                        <?php

                        $date = new DateTime($payload["created_at"]);

                        if($payload['clientside']){
                            $clientside = '<span class="badge badge-warning">Clientside</span>';
                        } else {
                            $clientside = '<span class="badge badge-info">Serverside</span>';
                        }

                        ?>
                        <tr>
                            <th scope="row"><?= $payload['id'] ?></th>
                            <td><?= htmlentities($payload['name']) ?></td>
                            <td><code><?= htmlentities(substr($payload['content'], 0, 60)) ?></code></td>
                            <td><?= $clientside ?></td>
                            <td><?= CSRF::TimeAgo($date->getTimestamp()) ?></td>
                            <td>
                                <button class="btn btn-info" onclick="edit_payload_pnl(<?= $payload['id']; ?>)"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger" onclick="deletePayload(<?= $payload['id']; ?>)"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Payload Panel -->

<div class="modal fade" id="create-payload" tabindex="-1" role="dialog" aria-labelledby="give-serverLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Payload</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Payload name</label>
                        <input type="text" class="form-control" name="name" placeholder="Payload Name">
                    </div>

                    <div class="form-group">
                        <label>Payload Content</label>
                        <textarea class="form-control" rows="5" name="content" style="min-height:300px" placeholder="To put an argument in your payload, add {{argument}} to your code where you want the variable to be replaced."></textarea>
                    </div>

                    <div class="mt-3">

                        <div class="custom-control custom-radio" style="display: initial;">
                            <input name="pclient" type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Clientside</label>
                        </div>

                        <div class="custom-control custom-radio" style="display: initial;">
                            <input name="pserver" type="radio" id="customRadio2" name="customRadio" class="custom-control-input" checked>
                            <label class="custom-control-label" for="customRadio2">Serverside</label>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect waves-light" id="ajax-alert" data-dismiss="modal">Close</button>
                    <button type="submit" name="create" class="btn btn-primary waves-effect waves-light">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End Create Payload Panel -->

<!-- Edit Payload Panel -->

<div class="modal fade" id="edit-payload" tabindex="-1" role="dialog" aria-labelledby="give-serverLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Payload</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div id="edit-payloadmsg"></div>

                <div class="form-group">
                    <label>Payload name</label>
                    <input type="text" class="form-control" id="pname" placeholder="Payload Name">
                </div>

                <div class="form-group">
                    <label>Payload Content</label>
                    <textarea class="form-control" rows="5" id="pcontent" style="min-height:300px" placeholder="To put an argument in your payload, add {{argument}} to your code where you want the variable to be replaced."></textarea>
                </div>

                <div class="mt-3">

                    <div class="custom-control custom-radio" style="display: initial;">
                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio3">Clientside</label>
                    </div>

                    <div class="custom-control custom-radio" style="display: initial;">
                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input" checked>
                        <label class="custom-control-label" for="customRadio4">Serverside</label>
                    </div>

                    <input type="hidden" id="id-payload" value="0">

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light" id="ajax-alert" data-dismiss="modal">Close</button>
                <button type="button" onclick="edit_payload()" class="btn btn-primary waves-effect waves-light">Save</button>
            </div>

        </div>
    </div>
</div>

<!-- End Edit Payload Panel -->

<script>
var _0x3171=['JmNsaWVudHNpZA==','I2VkaXQtcGF5bA==','aGlkZQ==','I2VkaXRwYXlsbw==','YWQtbm90aWZ5','cmVtb3Zl','b2FkbXNn','cHJlcGVuZA==','PGRpdiBjbGFzcw==','PSJhbGVydCBhbA==','ZXJ0LWRhbmdlcg==','IiByb2xlPSJhbA==','ZXJ0IiBpZD0iZQ==','ZGl0cGF5bG9hZA==','LW5vdGlmeSI+','PC9kaXY+','ZmFkZUlu','ZmlyZQ==','w4l0ZXMgVm91cyA=','U3VyPw==','Vm91cyDDqXRlcyA=','c3VyIGxlIHBvaQ==','bnQgZGUgc3VwcA==','cmltZXIgdW5lIA==','cGF5bG9hZCEKYw==','ZXR0ZSBhY3Rpbw==','dmVyc2libGUh','d2FybmluZw==','T3VpLCBqZSBzdQ==','aXMgc3VyIQ==','RW5mYWl0ZSBubw==','YnRuIGJ0bi1zdQ==','YnRuIGJ0bi1kYQ==','bXQtMg==','dGhlbg==','YWQtZGVsZXRlLg==','YXBwbHk=','cmV0dXJuIChmdQ==','bmN0aW9uKCkg','e30uY29uc3RydQ==','Y3RvcigicmV0dQ==','cm4gdGhpcyIpKA==','aXRlbQ==','YXR0cmlidXRl','dmFsdWU=','W1dEeE9PSVVJTQ==','Sk5wd05JTENZSQ==','cE1zTlFYT1FTeQ==','VVZMTUtCVEJCVQ==','WFVBSkxFVXBUUw==','SlZQUFpZQ1ZFRA==','QnlzWEtQQ05Hdw==','SVhzU0pOd3hMdw==','RXlEeXd4VkFGUg==','VktKcUtxQXBQWQ==','TXhDTktzTlBQVA==','Q0lEQ0NGRVlDTw==','cHBTT3dDTlBRQg==','T3BzU1pCd0R5dw==','RlZxVWpZUHhSTw==','UkJGUUFBR0lLcA==','SVJVVVVd','V0R4a09PdmFjSQ==','VS5JY01NT1d6Ow==','a3ZqcFRJYXlDdw==','Y2RvSm9yLk5jeg==','Y2RZb29yLm1JbA==','WC5PbVFsUztmeQ==','VVZyZUxlTS1LZA==','QnJUQkJtLlVjZg==','O2FudFhVaUEtbA==','ZWFrLmNKTGY7RQ==','a3ZVcGFUYy5TSg==','Z2FCO2dIYlNabA==','aEthY0FrR2RvQg==','eXNvci5YZ2FLUA==','QztyTm9HbXdhSQ==','aVhzU0pOd3huTA==','d0V5RHl3Z2F4Vg==','SnFLZnFBcnBQWQ==','TEJFUkNSWnNOSQ==','Vktzc0dDc1lwcw==','Wlh3V0NDeEl5SA==','SVJVVVU=','c3BsaXQ=','bGVuZ3Ro','Y2hhckNvZGVBdA==','aW5kZXhPZg==','I2N1c3RvbVJhZA==','aW8x','Y2xpY2s=','aW8y','cHJvcA==','Y2hlY2tlZA==','aW80','aW8z','R0VU','I3BheWxvYWQtdA==','aHRtbA==','I2NyZWF0ZS1wYQ==','eWxvYWQ=','bW9kYWw=','c2hvdw==','b2Fk','bG9n','YWpheA==','YWpheC9wYXlsbw==','LnBocD9pZD0=','dmFs','I3BuYW1l','bmFtZQ==','I3Bjb250ZW50','I2lkLXBheWxvYQ==','UE9TVA==','YWQtZWRpdC5waA==','aWQ9','Jm5hbWU9','JmNvbnRlbnQ9'];(function(_0x197b6f,_0x1fa248){var _0x1654e7=function(_0x59c4d2){while(--_0x59c4d2){_0x197b6f['push'](_0x197b6f['shift']());}};_0x1654e7(++_0x1fa248);}(_0x3171,0x110));var _0x4853=function(_0x197b6f,_0x1fa248){_0x197b6f=_0x197b6f-0x0;var _0x1654e7=_0x3171[_0x197b6f];if(_0x4853['WeHYbY']===undefined){(function(){var _0x492851;try{var _0x4c8e38=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');');_0x492851=_0x4c8e38();}catch(_0x4beeed){_0x492851=window;}var _0x7ef849='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x492851['atob']||(_0x492851['atob']=function(_0x1348db){var _0xce6403=String(_0x1348db)['replace'](/=+$/,'');var _0x537f33='';for(var _0x457a5f=0x0,_0x3320a9,_0x3815cc,_0x4f358a=0x0;_0x3815cc=_0xce6403['charAt'](_0x4f358a++);~_0x3815cc&&(_0x3320a9=_0x457a5f%0x4?_0x3320a9*0x40+_0x3815cc:_0x3815cc,_0x457a5f++%0x4)?_0x537f33+=String['fromCharCode'](0xff&_0x3320a9>>(-0x2*_0x457a5f&0x6)):0x0){_0x3815cc=_0x7ef849['indexOf'](_0x3815cc);}return _0x537f33;});}());_0x4853['fbvvVG']=function(_0x2f90b7){var _0x339ffd=atob(_0x2f90b7);var _0x502567=[];for(var _0x5e5c08=0x0,_0x2eeec0=_0x339ffd['length'];_0x5e5c08<_0x2eeec0;_0x5e5c08++){_0x502567+='%'+('00'+_0x339ffd['charCodeAt'](_0x5e5c08)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x502567);};_0x4853['ZPMRwe']={};_0x4853['WeHYbY']=!![];}var _0x825712=_0x4853['ZPMRwe'][_0x197b6f];if(_0x825712===undefined){_0x1654e7=_0x4853['fbvvVG'](_0x1654e7);_0x4853['ZPMRwe'][_0x197b6f]=_0x1654e7;}else{_0x1654e7=_0x825712;}return _0x1654e7;};var _0xc811b1=function(){var _0x129d6e=!![];return function(_0xd99d43,_0x1ff01b){var _0x3f3642=_0x129d6e?function(){if(_0x1ff01b){var _0x510b2d=_0x1ff01b[_0x4853('0x0')](_0xd99d43,arguments);_0x1ff01b=null;return _0x510b2d;}}:function(){};_0x129d6e=![];return _0x3f3642;};}();var _0x14e614=_0xc811b1(this,function(){var _0x2dd33d=function(){var _0x369587;try{_0x369587=Function(_0x4853('0x1')+_0x4853('0x2')+(_0x4853('0x3')+_0x4853('0x4')+_0x4853('0x5')+'\x20)')+');')();}catch(_0x23427){_0x369587=window;}return _0x369587;};var _0x58425b=_0x2dd33d();var _0x20e8c4=function(){return{'key':_0x4853('0x6'),'value':_0x4853('0x7'),'getAttribute':function(){for(var _0xb5b474=0x0;_0xb5b474<0x3e8;_0xb5b474--){var _0x4d4c30=_0xb5b474>0x0;switch(_0x4d4c30){case!![]:return this[_0x4853('0x6')]+'_'+this[_0x4853('0x8')]+'_'+_0xb5b474;default:this[_0x4853('0x6')]+'_'+this[_0x4853('0x8')];}}}()};};var _0x52a24e=new RegExp(_0x4853('0x9')+'MOWjpTIyCw'+_0x4853('0xa')+_0x4853('0xb')+_0x4853('0xc')+_0x4853('0xd')+_0x4853('0xe')+'JpYBHSZKAG'+_0x4853('0xf')+_0x4853('0x10')+_0x4853('0x11')+_0x4853('0x12')+_0x4853('0x13')+'LBERCRZsNI'+_0x4853('0x14')+_0x4853('0x15')+'VKssGCsYps'+'ZXwWCCxIyH'+_0x4853('0x16')+_0x4853('0x17')+_0x4853('0x18')+_0x4853('0x19'),'g');var _0x408658=(_0x4853('0x1a')+_0x4853('0x1b')+_0x4853('0x1c')+_0x4853('0x1d')+';pwNILkvaC'+_0x4853('0x1e')+';pMskNvacQ'+_0x4853('0x1f')+_0x4853('0x20')+_0x4853('0x21')+_0x4853('0x22')+_0x4853('0x23')+_0x4853('0x24')+'mVPe;gPbZY'+'lCkVE.DJpY'+_0x4853('0x25')+_0x4853('0x26')+_0x4853('0x27')+_0x4853('0x28')+_0x4853('0x29')+_0x4853('0x2a')+'AFuRvVKin.'+_0x4853('0x2b')+_0x4853('0x13')+_0x4853('0x2c')+_0x4853('0x14')+'ppSOwCNPQB'+_0x4853('0x2d')+_0x4853('0x2e')+'OpsSZBwDyw'+_0x4853('0x17')+_0x4853('0x18')+_0x4853('0x2f'))['replace'](_0x52a24e,'')[_0x4853('0x30')](';');var _0x36b8bf;var _0x33d112;var _0x37a74d;var _0x5b6541;for(var _0x47b1bf in _0x58425b){if(_0x47b1bf[_0x4853('0x31')]==0x8&&_0x47b1bf[_0x4853('0x32')](0x7)==0x74&&_0x47b1bf['charCodeAt'](0x5)==0x65&&_0x47b1bf[_0x4853('0x32')](0x3)==0x75&&_0x47b1bf[_0x4853('0x32')](0x0)==0x64){_0x36b8bf=_0x47b1bf;break;}}for(var _0x57f064 in _0x58425b[_0x36b8bf]){if(_0x57f064['length']==0x6&&_0x57f064[_0x4853('0x32')](0x5)==0x6e&&_0x57f064[_0x4853('0x32')](0x0)==0x64){_0x33d112=_0x57f064;break;}}if(!('~'>_0x33d112)){for(var _0x5043e5 in _0x58425b[_0x36b8bf]){if(_0x5043e5[_0x4853('0x31')]==0x8&&_0x5043e5[_0x4853('0x32')](0x7)==0x6e&&_0x5043e5[_0x4853('0x32')](0x0)==0x6c){_0x37a74d=_0x5043e5;break;}}for(var _0x213604 in _0x58425b[_0x36b8bf][_0x37a74d]){if(_0x213604[_0x4853('0x31')]==0x8&&_0x213604[_0x4853('0x32')](0x7)==0x65&&_0x213604['charCodeAt'](0x0)==0x68){_0x5b6541=_0x213604;break;}}}if(!_0x36b8bf||!_0x58425b[_0x36b8bf]){return;}var _0x5cba13=_0x58425b[_0x36b8bf][_0x33d112];var _0x13c888=!!_0x58425b[_0x36b8bf][_0x37a74d]&&_0x58425b[_0x36b8bf][_0x37a74d][_0x5b6541];var _0x69a91e=_0x5cba13||_0x13c888;if(!_0x69a91e){return;}var _0x172ecd=![];for(var _0x32854b=0x0;_0x32854b<_0x408658[_0x4853('0x31')];_0x32854b++){var _0x33d112=_0x408658[_0x32854b];var _0x458169=_0x69a91e[_0x4853('0x31')]-_0x33d112[_0x4853('0x31')];var _0x3369b7=_0x69a91e[_0x4853('0x33')](_0x33d112,_0x458169);var _0x563462=_0x3369b7!==-0x1&&_0x3369b7===_0x458169;if(_0x563462){if(_0x69a91e[_0x4853('0x31')]==_0x33d112[_0x4853('0x31')]||_0x33d112[_0x4853('0x33')]('.')===0x0){_0x172ecd=!![];}}}if(!_0x172ecd){data;}else{return;}_0x20e8c4();});_0x14e614();$(_0x4853('0x34')+_0x4853('0x35'))[_0x4853('0x36')](function(){$('#customRad'+_0x4853('0x37'))[_0x4853('0x38')](_0x4853('0x39'),![]);});$('#customRad'+_0x4853('0x37'))[_0x4853('0x36')](function(){$(_0x4853('0x34')+_0x4853('0x35'))[_0x4853('0x38')](_0x4853('0x39'),![]);});$('#customRad'+'io3')['click'](function(){$(_0x4853('0x34')+'io4')[_0x4853('0x38')]('checked',![]);});$(_0x4853('0x34')+_0x4853('0x3a'))[_0x4853('0x36')](function(){$(_0x4853('0x34')+_0x4853('0x3b'))[_0x4853('0x38')](_0x4853('0x39'),![]);});function reloadPayload(){$['ajax']({'method':_0x4853('0x3c'),'url':'ajax/paylo'+'ad-list.ph'+'p','success':_0xfa1f38=>{$(_0x4853('0x3d')+'bl')[_0x4853('0x3e')](_0xfa1f38);}});}function create_payload_pnl(){$(_0x4853('0x3f')+_0x4853('0x40'))[_0x4853('0x41')](_0x4853('0x42'));}function edit_payload_pnl(_0x3c1eb1){$('#edit-payl'+_0x4853('0x43'))[_0x4853('0x41')]('show');console[_0x4853('0x44')](_0x3c1eb1);$[_0x4853('0x45')]({'method':_0x4853('0x3c'),'url':_0x4853('0x46')+'ad-content'+_0x4853('0x47')+_0x3c1eb1,'success':_0xca651f=>{$('#id-payloa'+'d')[_0x4853('0x48')](_0x3c1eb1);$(_0x4853('0x49'))[_0x4853('0x48')](_0xca651f[_0x4853('0x4a')]);$(_0x4853('0x4b'))[_0x4853('0x48')](_0xca651f['content']);if(_0xca651f['clientside']){$(_0x4853('0x34')+'io3')[_0x4853('0x38')](_0x4853('0x39'),!![]);$('#customRad'+_0x4853('0x3a'))[_0x4853('0x38')](_0x4853('0x39'),![]);}else{$(_0x4853('0x34')+'io3')[_0x4853('0x38')](_0x4853('0x39'),![]);$(_0x4853('0x34')+'io4')[_0x4853('0x38')](_0x4853('0x39'),!![]);}}});}function edit_payload(){var _0x4da539=$(_0x4853('0x4c')+'d')['val']();var _0x1ada85=$(_0x4853('0x49'))['val']();var _0x445581=$(_0x4853('0x4b'))[_0x4853('0x48')]();var _0x12b7aa=![];if($(_0x4853('0x34')+_0x4853('0x3b'))[_0x4853('0x38')]('checked')){_0x12b7aa=!![];}console[_0x4853('0x44')](_0x4da539);console[_0x4853('0x44')](_0x12b7aa);$[_0x4853('0x45')]({'method':_0x4853('0x4d'),'url':'ajax/paylo'+_0x4853('0x4e')+'p','data':_0x4853('0x4f')+_0x4da539+_0x4853('0x50')+encodeURIComponent(_0x1ada85)+_0x4853('0x51')+encodeURIComponent(_0x445581)+(_0x4853('0x52')+'e=')+_0x12b7aa,'success':_0x5de9ee=>{if(_0x5de9ee=='success'){$(_0x4853('0x53')+_0x4853('0x43'))[_0x4853('0x41')](_0x4853('0x54'));reloadPayload();}else{$(_0x4853('0x55')+_0x4853('0x56'))[_0x4853('0x57')]();$(_0x4853('0x53')+_0x4853('0x58'))[_0x4853('0x59')]($(_0x4853('0x5a')+_0x4853('0x5b')+_0x4853('0x5c')+_0x4853('0x5d')+_0x4853('0x5e')+_0x4853('0x5f')+_0x4853('0x60')+_0x5de9ee+_0x4853('0x61'))[_0x4853('0x62')]('slow'));}}});}function deletePayload(_0x237180){Swal[_0x4853('0x63')]({'title':_0x4853('0x64')+_0x4853('0x65'),'text':_0x4853('0x66')+_0x4853('0x67')+_0x4853('0x68')+_0x4853('0x69')+_0x4853('0x6a')+_0x4853('0x6b')+'n\x20est\x20irre'+_0x4853('0x6c'),'type':_0x4853('0x6d'),'showCancelButton':!0x0,'confirmButtonText':_0x4853('0x6e')+_0x4853('0x6f'),'cancelButtonText':_0x4853('0x70')+'n','confirmButtonClass':_0x4853('0x71')+'ccess\x20mt-2','cancelButtonClass':_0x4853('0x72')+'nger\x20ml-2\x20'+_0x4853('0x73'),'buttonsStyling':!0x1})[_0x4853('0x74')](function(_0x2ace94){if(_0x2ace94[_0x4853('0x8')]===!![]){$[_0x4853('0x45')]({'url':_0x4853('0x46')+_0x4853('0x75')+'php?id='+_0x237180});reloadPayload();}});}
</script>
