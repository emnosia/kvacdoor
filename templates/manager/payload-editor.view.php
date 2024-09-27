<link rel="stylesheet" href="/assets/plugins/codemirror/codemirror.css">
<script src="/assets/plugins/codemirror/codemirror.js"></script>
<script src="/assets/plugins/codemirror/selection/active-line.js"></script>
<script src="/assets/plugins/codemirror/edit/matchbrackets.js"></script>
<script src="/assets/plugins/codemirror/lua/glua.js"></script>
<link rel="stylesheet" href="/assets/plugins/codemirror/monokai.css">

<div class="card">
    <div class="card-body">
        <form id="edit-payload-form">

            <h4 class="card-title">Lua Editor</h4>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="payload-title" placeholder="Payload Name">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Category">
                </div>
            </div>

            <div class="form-group">
                <textarea class="form-control" id="input-lua" name="edit-payload-content" rows="6"></textarea>
            </div>

            <button class="btn btn-success btn-block" onclick="e.preventDefault()">Save</button>

            <input type="hidden" name="edit-payload-category" value="{{ AUTHUSER.username }}">

        </form>
    </div>
</div>

<script>
    const payload_id = <?= $_GET['id']; ?>;
    $.ajax({
        method: "GET",
        url: "/api/payloads?id=" + payload_id,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content")
        }
    }).done(function(data) {
        $('[name="edit-payload-content"]').val(data.content);
        $('#payload-title').val(data.name);
        var editor = CodeMirror.fromTextArea(document.getElementById("input-lua"), {
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            mode: "lua",
            theme: "monokai",
            value: data.content
        }).setSize(null, 600);
    });
</script>