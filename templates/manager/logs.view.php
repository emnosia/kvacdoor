<div class="row">
    <div class="col-lg-12">

        <form>
            <div class="form-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher...">
            </div>
        </form>

        <div class="card">
            <div class="card-body card-scroll">
                <h4 class="card-title d-inline-block">Logs</h4>
                <div id="logs">
                    <?php foreach (Logs::GetLastLogs(10000) as $logger): ?>
                    <?php if(preg_match("#text-muted#", $logger['content']) && isset($_SESSION['admin_mode'])) continue; ?>
                    <?= substr($logger['content'], 0, 300); ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

const searchInput = document.querySelector('#searchInput');
let timeout;

searchInput.addEventListener('input', (event) => {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        const searchValue = event.target.value;
        
        // Effectue la requête API en utilisant fetch()
        fetch("/api/admin/search?q=" + searchValue)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            // Traitement des données retournées par l'API
            console.log(data);
            $('#logs').empty();
            $.each(data.result, function (index, log) {
                index++;
                console.log(log);
                $('#logs').append(log.content);
            });
        })
        .catch(function(error) {
            console.error("Erreur lors de la requête API : ", error);
        });


    }, 500);
});

function test()
{
    Swal.fire({
        title: "Good job!",
        text: "You clicked the button!",
        type: "success",
        confirmButtonClass: "btn btn-confirm mt-2"
    })
}

function verif(user_id, action)
{
    $.ajax({
        "method": "POST",
        "data": "action="+action+"&userid="+user_id,
        "url": "ajax/admin_verification.php",
        "success": (data) => {
            test();
        }
    });
}
</script>