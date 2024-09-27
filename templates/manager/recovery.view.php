<?php 

$test = "v0cKo%".CSRF::GenString(7)."x\\a".CSRF::GenString(7)."Yam".CSRF::GenString(3)."aha".CSRF::GenString(6)."x\\a".CSRF::GenString(9)."==";

?>
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <i class="h1 fas fa-life-ring"></i>
            <h3 class="mb-3">Account Recovery</h3>
            <p class="text-white">If you lose your discord account</p>
            <p class="text-danger">This key is completely private! don't give it to anyone</p>
        </div>
        <div align="center">
            <button id="loadingstop" onclick="savekey();" class="ladda-button btn btn-primary" data-style="expand-right">
                <span class="ladda-label">Download</span>
                <span class="ladda-spinner"></span>
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
<script>
    function savekey()
    {
        var blob = new Blob(["<?= $AUTHUSER['recovery'] ?>"], {type: "text/plain;charset=utf-8"});
        saveAs(blob, "kvacdoor_recovery_key.txt");
        let _0x39e8e6 = $(_0x464e('0x12'));
        setTimeout(function () {
            _0x39e8e6[_0x464e('0x13')](_0x464e('0x14'));
            _0x39e8e6[_0x464e('0x13')]('disabled');
        }, 0x1f4);
    }
</script>