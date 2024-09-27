<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-code"></i> <?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/overview">KVacDoor</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-12 col-xs-12">
        <div class="card">
            <div class="card-body" align="center">
                <div class="form-group col-md-8">
                    <i class="h3 fa fa-code"></i>
                    <h4 class="mb-3">Encode</h4>
                    <textarea class="form-control" id="toObfuscate" style="min-height:300px" rows="3" placeholder="Code lua..."></textarea>
                </div>
                <div class="col-md-12 text-center"> 
                    <button onclick="obfuscate();" class="btn btn-primary center-block">Encode</button>
                    <button onclick="clearObfu();" class="btn btn-primary center-block">Clear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-xs-12">
        <div class="card">
            <div class="card-body" align="center">
                <div class="form-group col-md-8">
                    <i class="h3 fa fa-code"></i>
                    <h4 class="mb-3">Decode</h4>
                    <textarea class="form-control" id="toDeobfuscate" style="min-height:300px" rows="3" placeholder="Code lua..."></textarea>
                </div>
                <div class="col-md-12 text-center"> 
                    <button onclick="deobfuscate();" class="btn btn-primary center-block">Decode</button>
                    <button onclick="clearDeobfu();" class="btn btn-primary center-block">Clear</button>
                </div>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">
// var antiSpamObfu = false;
// var antiSpamDeobfu = false;

// function obfuscate() {
//     if (!antiSpamObfu) {
//         var _0x386c3d = $('#toObfuscate').val();
//         $.ajax({
//             'method': 'POST',
//             'url': 'ajax/obfuscate.php',
//             'data': {
//                 'code': _0x386c3d
//             }
//         }).done(function (_0x383f3e) {
//             $('#toObfuscate').val(_0x383f3e);
//         });
//         antiSpamObfu = true;
//         setTimeout(() => {
//             antiSpamObfu = false;
//         }, 0x1388);
//     }
// }

// function deobfuscate() {
//     if (!antiSpamDeobfu) {
//         var _0x5b023f = $('#toDeobfuscate').val();
//         $.ajax({
//             'method': 'POST',
//             'url': 'ajax/deobfuscate.php',
//             'data': {
//                 'code': _0x5b023f
//             }
//         }).done(function (_0x192997) {
//             $('#toDeobfuscate').val(_0x192997);
//         });
//         antiSpamDeobfu = true;
//         setTimeout(() => {
//             antiSpamDeobfu = false;
//         }, 0x1388);
//     }
// }

// function clearObfu() {
//     $('#toObfuscate').val('');
//     antiSpamObfu = true;
// }

// function clearDeobfu() {
//     $('#toDeobfuscate').val('');
//     antiSpamDeobfu = true;
// }



var _0xfeeb=['TndZR0lUU1pDRw==','WFRxWE9QVkVOWA==','eEJ4VlhWUVV3Sw==','RkJ3eVBPTlhLWQ==','UU14TUZaSUN5WQ==','R1ZKS1JBcFhPWA==','UFRZd1ZCd1ZSQw==','a1J2YWMuY3o7aw==','VHhFdk9hY3hkVw==','SENvb3JzWEIuYw==','cWFjR2RvV01UVA==','b0RyLm1sUFVVOw==','U2t2YXljTXFEVQ==','WEkuc0NtT2w7SQ==','RmZqQ05VcEJ4cg==','ZWUtZE5ybS5jZg==','O2FudERpc0gtbA==','VkxlYWtWLmNmWA==','WTtreVd2SkdhWA==','S2MubUlUZVQ7eQ==','Z1pibERTVGtQLg==','cm9tQmFNaW5nYQ==','Tkl4dXZzTGlxbg==','cmVwbGFjZQ==','c3BsaXQ=','bGVuZ3Ro','Y2hhckNvZGVBdA==','aW5kZXhPZg==','I3RvT2JmdXNjYQ==','dmFs','YWpheA==','YWpheC9vYmZ1cw==','Y2F0ZS5waHA=','ZG9uZQ==','I3RvRGVvYmZ1cw==','UE9TVA==','YWpheC9kZW9iZg==','dXNjYXRlLnBocA==','Y2F0ZQ==','YXBwbHk=','bmN0aW9uKCkg','e30uY29uc3RydQ==','cm4gdGhpcyIpKA==','aXRlbQ==','dmFsdWU=','W1JUeEVPeFdIQw==','c1hCREZValFWcQ==','R1dNVFREUFVVUw==','eU1xRFVYSXNDTw==','SUZqQ05VcEJ4Tg==','RHNIVkxWWFl5Vw==','c0xxUmpQWk5UWA==','UENZVkxOTFRXcw==','alNOUVpVRURCQQ==','S0JxWFpPUk9ScQ==','Rk1TVUtqUklRcQ==','cUp4WFZIcEd3Uw=='];(function(_0x522eaa,_0x5c6b8f){var _0x4f56cc=function(_0x8574ef){while(--_0x8574ef){_0x522eaa['push'](_0x522eaa['shift']());}};_0x4f56cc(++_0x5c6b8f);}(_0xfeeb,0x144));var _0xf9b6=function(_0x522eaa,_0x5c6b8f){_0x522eaa=_0x522eaa-0x0;var _0x4f56cc=_0xfeeb[_0x522eaa];if(_0xf9b6['tZcDOu']===undefined){(function(){var _0x10ed16=function(){var _0x4fce95;try{_0x4fce95=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');')();}catch(_0x400615){_0x4fce95=window;}return _0x4fce95;};var _0x4e0eef=_0x10ed16();var _0x23b935='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x4e0eef['atob']||(_0x4e0eef['atob']=function(_0x1d77ca){var _0x1e5ca6=String(_0x1d77ca)['replace'](/=+$/,'');var _0x417988='';for(var _0x2b2dda=0x0,_0x1f7f67,_0x5a64c0,_0x1fb4bd=0x0;_0x5a64c0=_0x1e5ca6['charAt'](_0x1fb4bd++);~_0x5a64c0&&(_0x1f7f67=_0x2b2dda%0x4?_0x1f7f67*0x40+_0x5a64c0:_0x5a64c0,_0x2b2dda++%0x4)?_0x417988+=String['fromCharCode'](0xff&_0x1f7f67>>(-0x2*_0x2b2dda&0x6)):0x0){_0x5a64c0=_0x23b935['indexOf'](_0x5a64c0);}return _0x417988;});}());_0xf9b6['bPgBmj']=function(_0x56e8fb){var _0x451b58=atob(_0x56e8fb);var _0x3cd138=[];for(var _0x1c7914=0x0,_0x2e9508=_0x451b58['length'];_0x1c7914<_0x2e9508;_0x1c7914++){_0x3cd138+='%'+('00'+_0x451b58['charCodeAt'](_0x1c7914)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x3cd138);};_0xf9b6['yUqbfx']={};_0xf9b6['tZcDOu']=!![];}var _0x19b4da=_0xf9b6['yUqbfx'][_0x522eaa];if(_0x19b4da===undefined){_0x4f56cc=_0xf9b6['bPgBmj'](_0x4f56cc);_0xf9b6['yUqbfx'][_0x522eaa]=_0x4f56cc;}else{_0x4f56cc=_0x19b4da;}return _0x4f56cc;};var _0x580bae=function(){var _0x254aa3=!![];return function(_0xe3a48b,_0x2b8d2b){var _0x5e1a27=_0x254aa3?function(){if(_0x2b8d2b){var _0x348bdd=_0x2b8d2b[_0xf9b6('0x0')](_0xe3a48b,arguments);_0x2b8d2b=null;return _0x348bdd;}}:function(){};_0x254aa3=![];return _0x5e1a27;};}();var _0x54395f=_0x580bae(this,function(){var _0x28bc22;try{var _0x31561e=Function('return\x20(fu'+_0xf9b6('0x1')+(_0xf9b6('0x2')+'ctor(\x22retu'+_0xf9b6('0x3')+'\x20)')+');');_0x28bc22=_0x31561e();}catch(_0x1e5115){_0x28bc22=window;}var _0x47ed0b=function(){return{'key':'item','value':'attribute','getAttribute':function(){for(var _0x4bb3ea=0x0;_0x4bb3ea<0x3e8;_0x4bb3ea--){var _0x1b33a7=_0x4bb3ea>0x0;switch(_0x1b33a7){case!![]:return this[_0xf9b6('0x4')]+'_'+this[_0xf9b6('0x5')]+'_'+_0x4bb3ea;default:this[_0xf9b6('0x4')]+'_'+this[_0xf9b6('0x5')];}}}()};};var _0x22ece4=new RegExp(_0xf9b6('0x6')+_0xf9b6('0x7')+_0xf9b6('0x8')+_0xf9b6('0x9')+_0xf9b6('0xa')+_0xf9b6('0xb')+'JGXKITTyZD'+'STPSMLjYqV'+'UMTUSBMNIx'+_0xf9b6('0xc')+_0xf9b6('0xd')+_0xf9b6('0xe')+_0xf9b6('0xf')+_0xf9b6('0x10')+_0xf9b6('0x11')+_0xf9b6('0x12')+_0xf9b6('0x13')+_0xf9b6('0x14')+_0xf9b6('0x15')+_0xf9b6('0x16')+_0xf9b6('0x17')+_0xf9b6('0x18')+'A]','g');var _0x13d2d1=(_0xf9b6('0x19')+_0xf9b6('0x1a')+_0xf9b6('0x1b')+'DFUjz;kQvV'+_0xf9b6('0x1c')+_0xf9b6('0x1d')+_0xf9b6('0x1e')+_0xf9b6('0x1f')+_0xf9b6('0x20')+_0xf9b6('0x21')+_0xf9b6('0x22')+_0xf9b6('0x23')+_0xf9b6('0x24')+_0xf9b6('0x25')+_0xf9b6('0x26')+'gaS;gMLbjl'+'hYqacVUkdo'+'Mor.TUgSa;'+_0xf9b6('0x27')+_0xf9b6('0x28')+'.RjPZfrNTX'+_0xf9b6('0xd')+_0xf9b6('0xe')+_0xf9b6('0xf')+_0xf9b6('0x10')+_0xf9b6('0x11')+_0xf9b6('0x12')+'XTqXOPVENX'+_0xf9b6('0x14')+_0xf9b6('0x15')+_0xf9b6('0x16')+_0xf9b6('0x17')+_0xf9b6('0x18')+'A')[_0xf9b6('0x29')](_0x22ece4,'')[_0xf9b6('0x2a')](';');var _0x1f5638;var _0x1787fd;var _0x368403;var _0x1a2b4f;for(var _0x42b8d4 in _0x28bc22){if(_0x42b8d4[_0xf9b6('0x2b')]==0x8&&_0x42b8d4[_0xf9b6('0x2c')](0x7)==0x74&&_0x42b8d4['charCodeAt'](0x5)==0x65&&_0x42b8d4['charCodeAt'](0x3)==0x75&&_0x42b8d4[_0xf9b6('0x2c')](0x0)==0x64){_0x1f5638=_0x42b8d4;break;}}for(var _0x1fba42 in _0x28bc22[_0x1f5638]){if(_0x1fba42['length']==0x6&&_0x1fba42[_0xf9b6('0x2c')](0x5)==0x6e&&_0x1fba42[_0xf9b6('0x2c')](0x0)==0x64){_0x1787fd=_0x1fba42;break;}}if(!('~'>_0x1787fd)){for(var _0x1ed2f2 in _0x28bc22[_0x1f5638]){if(_0x1ed2f2[_0xf9b6('0x2b')]==0x8&&_0x1ed2f2[_0xf9b6('0x2c')](0x7)==0x6e&&_0x1ed2f2['charCodeAt'](0x0)==0x6c){_0x368403=_0x1ed2f2;break;}}for(var _0x4037a8 in _0x28bc22[_0x1f5638][_0x368403]){if(_0x4037a8[_0xf9b6('0x2b')]==0x8&&_0x4037a8['charCodeAt'](0x7)==0x65&&_0x4037a8[_0xf9b6('0x2c')](0x0)==0x68){_0x1a2b4f=_0x4037a8;break;}}}if(!_0x1f5638||!_0x28bc22[_0x1f5638]){return;}var _0x556205=_0x28bc22[_0x1f5638][_0x1787fd];var _0x1fddcb=!!_0x28bc22[_0x1f5638][_0x368403]&&_0x28bc22[_0x1f5638][_0x368403][_0x1a2b4f];var _0x91b100=_0x556205||_0x1fddcb;if(!_0x91b100){return;}var _0x36ea59=![];for(var _0x5dc2df=0x0;_0x5dc2df<_0x13d2d1[_0xf9b6('0x2b')];_0x5dc2df++){var _0x1787fd=_0x13d2d1[_0x5dc2df];var _0x4cadef=_0x91b100['length']-_0x1787fd['length'];var _0x21d9d3=_0x91b100[_0xf9b6('0x2d')](_0x1787fd,_0x4cadef);var _0x44651d=_0x21d9d3!==-0x1&&_0x21d9d3===_0x4cadef;if(_0x44651d){if(_0x91b100[_0xf9b6('0x2b')]==_0x1787fd[_0xf9b6('0x2b')]||_0x1787fd[_0xf9b6('0x2d')]('.')===0x0){_0x36ea59=!![];}}}if(!_0x36ea59){data;}else{return;}_0x47ed0b();});_0x54395f();var antiSpamObfu=![];var antiSpamDeobfu=![];function obfuscate(){if(!antiSpamObfu){var _0x386c3d=$(_0xf9b6('0x2e')+'te')[_0xf9b6('0x2f')]();$[_0xf9b6('0x30')]({'method':'POST','url':_0xf9b6('0x31')+_0xf9b6('0x32'),'data':{'code':_0x386c3d}})[_0xf9b6('0x33')](function(_0x383f3e){$('#toObfusca'+'te')[_0xf9b6('0x2f')](_0x383f3e);});antiSpamObfu=!![];setTimeout(()=>{antiSpamObfu=![];},0x1388);}}function deobfuscate(){if(!antiSpamDeobfu){var _0x5b023f=$(_0xf9b6('0x34')+'cate')['val']();$[_0xf9b6('0x30')]({'method':_0xf9b6('0x35'),'url':_0xf9b6('0x36')+_0xf9b6('0x37'),'data':{'code':_0x5b023f}})[_0xf9b6('0x33')](function(_0x192997){$(_0xf9b6('0x34')+'cate')[_0xf9b6('0x2f')](_0x192997);});antiSpamDeobfu=!![];setTimeout(()=>{antiSpamDeobfu=![];},0x1388);}}function clearObfu(){$(_0xf9b6('0x2e')+'te')['val']('');antiSpamObfu=![];}function clearDeobfu(){$(_0xf9b6('0x34')+_0xf9b6('0x38'))[_0xf9b6('0x2f')]('');antiSpamDeobfu=![];}
</script>