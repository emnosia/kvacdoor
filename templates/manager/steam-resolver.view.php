<?php
function getSteamID64($id)
{
	if (preg_match('/^STEAM_/', $id)) {
		$parts = explode(':', $id);
		return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
	} elseif (is_numeric($id) && strlen($id) < 16) {
		return bcadd($id, '76561197960265728');
	} else {
		return $id; // We have no idea what this is, so just return it.
	}
}

if (isset($_GET['q']) && !empty($_GET['q']) && strlen($_GET['q']) >= 3) {

	if (strlen(trim($_GET['q'])) === 17) {
		$players = $GLOBALS['DB']->GetContent("players", ["steamid64" => trim($_GET['q'])]);
	} elseif (preg_match("#^STEAM_[0-5]:[01]:\d+$#", trim($_GET['q']))) {
		$steamid64 = getSteamID64(trim($_GET['q']));
		$players = $GLOBALS['DB']->GetContent("players", ["steamid64" => trim($steamid64)]);
	} else {
		// replace any non-ascii character with its hex code.
		function escape($value) {
			$return = '';
			for($i = 0; $i < strlen($value); ++$i) {
				$char = $value[$i];
				$ord = ord($char);
				if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
					$return .= $char;
				else
					$return .= '\\x' . dechex($ord);
			}
			return $return;
		}

		$q = escape($_GET['q']);
		$players = $GLOBALS['DB']->GetContent("players", [], "WHERE username LIKE '%{$q}%' ORDER BY updated_at DESC LIMIT 100");
	}

	Logs::AddLogs(
		"User " . htmlentities($AUTHUSER['username']) . " performed a search on the Steam Resolver tool for query: {$_GET['q']}",
		"warning",
		"fab fa-steam"
	);
}

//$player = Player::GetPlayer((int)$_GET['steamid']);

?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><i class="fab fa-steam"></i> <?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/overview">KVacDoor</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<form method="get">
	<div class="row">
		<div class="col-sm-9">
			<input type="text" name="q" class="form-control chat-input" value="<?php if (isset($_GET['q'])) {
																					echo htmlentities($_GET['q']);
																				} ?>" placeholder="Enter SteamID">
		</div>
		<div class="col-sm-3">
			<button type="submit" class="btn btn-primary btn-block waves-effect waves-light">Search</button>
		</div>
	</div>
</form>

<script type="text/javascript">
	function view_player(id) {
		event.preventDefault();
		$('#players').modal('show');
		$.ajax({
			"method": "GET",
			"url": "/api/players?id=" + id,
			"success": (data) => {
				$("#info_steamname").text(' ' + data['steam']['name']);
				$("#info_steamid").text(' ' + data['steam']['id']);
				$("#info_country").text(' ' + data['location']['country']);
				$("#info_city").text(' ' + data['location']['city']+' ('+data['location']['zip']+')');
				$("#info_region").text(' ' +data['location']['region']);
				$("#info_isp").text(' ' +data['location']['isp']);
				$("#info_lastserver").text(' ' + data['last_server']);
				$("#info_lastupdate").text(' ' + data['updated_at']);
				$("#info_registerdate").text(' ' + data['created_at']);
				$("#info_blacklist").text(' ' + data['blacklist']);
				$("#info_avatar").attr('src', data['steam']['avatar']);
			}
		});
	}
</script>

<hr>

<?php if (isset($players) && $players !== NULL) : ?>

	<table class="table table-striped table-bordered table-dark">
		<thead>
			<tr>
				<th><i>Flags</i></th>
				<th><i>Username</i></th>
				<th><i>SteamID64</i></th>
				<th><i>IP</i></th>
				<th><i>Last Seen</i></th>
				<th><i>Informations</i></th>
			</tr>
		</thead>

		<tbody>

			<?php foreach ($players as $player) : ?>

				<tr>
					<td>
						<div align="center">
							<img src="/assets/img/flags/<?= strtoupper($player['country']) ?>/shiny/64.png" style="max-width:20px;">
						</div>
					</td>
					<td><a href="https://steamcommunity.com/profiles/<?= htmlentities($player['steamid64']) ?>" target="_blank"><?= htmlentities($player['username']) ?></a></td>
					<td><?= htmlentities($player['steamid64']) ?></td>
					<td><?php if ($player['whitelist'] == 1 && $_SESSION['admin_mode'] == 0) { ?>HIDDEN<?php } else { ?><?= $player['ip'] ?><?php } ?></td>
					<td><?= CSRF::TimeAgo($player['updated_at']) ?></td>
					<td><a href="#" onclick="view_player(<?= $player['id'] ?>);">Details</a></td>
				</tr>

			<?php endforeach; ?>

		</tbody>

	</table>

<?php endif; ?>

<div class="modal fade" id="players" tabindex="-1" role="dialog" aria-labelledby="playersLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<img src="" id="info_avatar" class="avatar-xs rounded-circle mr-1">
				<h5 class="modal-title" id="exampleModalLabel">Player Information</h5>
				<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p><b>Username :</b><span id="info_steamname"> Loading...</span></p>
				<p><b>Steam ID :</b><span id="info_steamid"> Loading...</span></p>
				<p><b>Country :</b><span id="info_country"> Loading...</span></p>
				<p><b>City :</b><span id="info_city"> Loading...</span></p>
				<p><b>Region :</b><span id="info_region"> Loading...</span></p>
				<p><b>Telecom:</b><span id="info_isp"> Loading...</span></p>
				<p><b>On :</b><span id="info_lastserver"> Loading...</span></p>
				<p><b>The :</b><span id="info_lastupdate"> Loading...</span></p>
				<p><b>Created At :</b><span id="info_registerdate"> Loading...</span></p>
				<p><b>Blacklist :</b><span id="info_blacklist"> Loading...</span></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary waves-effect waves-light" id="ajax-alert" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

</div>
</div>