<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fa fa-server"></i> <?= $title ?></h4>

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
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Hostname</th>
                            <th scope="col">IP</th>
                            <th scope="col">Gamemode</th>
                            <th scope="col">Slots</th>
                            <th scope="col">Last Ping</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="game-server-list">
                        <?php foreach ($userServers as $server): ?>
                        <?php if($server['last_update'] + 130 < time()) continue; ?>
                        <tr>
                            <th scope="row"><?= $serverIndex++ ?></th>
                            <td><?= htmlentities($server['hostname']) ?></td>
                            <td><?= htmlentities($server['ip']) ?></td>
                            <td><?= htmlentities($server['gamemode']) ?></td>
                            <td><?= $server['used_slots'] ?>/<?= $server['max_slots'] ?></td>
                            <td><?= date('Y-m-d H:i:s', $server['last_update']); ?></td>
                            <td>
                                <?php if ($AUTHUSER['roles'] >= 1): ?>
                                <a href="servers/<?= $server['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-terminal"></i> Console</a>
                                <?php else: ?>
                                <a href="/market/premium-access" class="btn btn-outline-primary btn-sm"><i class="fa fa-lock"></i> Locked</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($AUTHUSER['roles'] >= 1): ?>
<script>
const escapeHtml = (content) => {
    const map = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#039;",
    };
    return content.toString().replace(/[&<>"']/g, (m) => map[m]);
};

const updateServerTable = () => {
    fetch("/api/servers.php")
        .then((response) => response.json())
        .then((data) => {
            const serverTable = document.getElementById("game-server-list");
            serverTable.innerHTML = "";
            data.forEach((server, index) => {
                index++;
                const row = document.createElement("tr");
                row.innerHTML = `
            <th scope="row">${index}</th>
            <td>${escapeHtml(server.hostname)}</td>
            <td>${escapeHtml(server.ip)}</td>
            <td>${escapeHtml(server.gamemode)}</td>
            <td>${escapeHtml(server.used_slots)}/${escapeHtml(server.max_slots)}</td>
            <td>${escapeHtml(server.last_ping)}</td>
            <td><a href="/servers/${server.id}" class="btn btn-primary btn-sm"><i class="fa fa-terminal"></i> Console</a></td>
            `;
                serverTable.appendChild(row);
            });
        })
        .catch((error) => console.error(error));
};

setInterval(updateServerTable, 5000);
</script>
<?php endif; ?>